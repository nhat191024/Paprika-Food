<?php

namespace App\Actions\Cart;

use App\Models\ComboGroup;
use App\Models\ComboGroupItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\States\Product\Active;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartManager
{
    private const SESSION_KEY = 'cart.items';

    private const SESSION_ORDER_IDS_KEY = 'cart.order_ids';

    /**
     * @param  array<int|string>  $comboItemIds
     * @return array<string, mixed>
     */
    public function add(int $productId, ?int $variantId, int $quantity, array $comboItemIds = []): array
    {
        $quantity = max(1, min(99, $quantity));
        $product = $this->findProduct($productId);
        $variant = $this->resolveVariant($product, $variantId);
        $selectedItems = $this->resolveComboItems($product, $comboItemIds);
        $item = $this->buildCartItem($product, $variant, $selectedItems, $quantity);
        $items = $this->items();

        if (isset($items[$item['key']])) {
            $items[$item['key']]['quantity'] = min(99, $items[$item['key']]['quantity'] + $quantity);
            $items[$item['key']]['subtotal'] = $this->money($items[$item['key']]['unit_price'] * $items[$item['key']]['quantity']);
        } else {
            $items[$item['key']] = $item;
        }

        session()->put(self::SESSION_KEY, $items);

        return $this->summary();
    }

    /**
     * @return array<string, mixed>
     */
    public function update(string $key, int $quantity): array
    {
        $items = $this->items();

        if (! isset($items[$key])) {
            return $this->summary();
        }

        if ($quantity < 1) {
            unset($items[$key]);
        } else {
            $items[$key]['quantity'] = min(99, $quantity);
            $items[$key]['subtotal'] = $this->money($items[$key]['unit_price'] * $items[$key]['quantity']);
        }

        session()->put(self::SESSION_KEY, $items);

        return $this->summary();
    }

    /**
     * @return array<string, mixed>
     */
    public function remove(string $key): array
    {
        $items = $this->items();
        unset($items[$key]);
        session()->put(self::SESSION_KEY, $items);

        return $this->summary();
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    /**
     * @return array<string, mixed>
     */
    public function summary(): array
    {
        $items = array_values($this->items());
        $subtotal = collect($items)->sum(fn (array $item): float => (float) $item['subtotal']);

        return [
            'items' => $items,
            'count' => collect($items)->sum(fn (array $item): int => (int) $item['quantity']),
            'subtotal' => $this->money($subtotal),
            'total' => $this->money($subtotal),
            'is_empty' => $items === [],
        ];
    }

    public function rememberOrder(int $orderId): void
    {
        $orderIds = session()->get(self::SESSION_ORDER_IDS_KEY, []);
        array_unshift($orderIds, $orderId);

        session()->put(self::SESSION_ORDER_IDS_KEY, array_values(array_unique($orderIds)));
    }

    /**
     * @return array<int>
     */
    public function rememberedOrderIds(): array
    {
        return session()->get(self::SESSION_ORDER_IDS_KEY, []);
    }

    /**
     * @return array<string, mixed>
     */
    private function items(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    private function findProduct(int $productId): Product
    {
        $product = Product::query()
            ->with([
                'thumbnail',
                'variants' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order'),
                'comboGroups.items.comboGroup',
                'comboGroups.items.product.thumbnail',
                'comboGroups.items.variant.product.thumbnail',
            ])
            ->find($productId);

        if (! $product || ! $product->status instanceof Active) {
            throw ValidationException::withMessages([
                'product_id' => __('client/cart.errors.product_unavailable'),
            ]);
        }

        return $product;
    }

    private function resolveVariant(Product $product, ?int $variantId): ?ProductVariant
    {
        if ($product->variants->isEmpty()) {
            return null;
        }

        if (! $variantId) {
            throw ValidationException::withMessages([
                'variant_id' => __('client/cart.errors.variant_required'),
            ]);
        }

        $variant = $product->variants->firstWhere('id', $variantId);

        if (! $variant) {
            throw ValidationException::withMessages([
                'variant_id' => __('client/cart.errors.variant_invalid'),
            ]);
        }

        return $variant;
    }

    /**
     * @param  array<int|string>  $comboItemIds
     * @return Collection<int, ComboGroupItem>
     */
    private function resolveComboItems(Product $product, array $comboItemIds): Collection
    {
        $comboItemIds = collect($comboItemIds)
            ->filter(fn ($itemId): bool => filled($itemId))
            ->map(fn ($itemId): int => (int) $itemId)
            ->unique()
            ->values();

        if (! $product->is_combo) {
            if ($comboItemIds->isNotEmpty()) {
                throw ValidationException::withMessages([
                    'combo_items' => __('client/cart.errors.combo_not_allowed'),
                ]);
            }

            return collect();
        }

        $availableItems = $product->comboGroups
            ->flatMap(fn (ComboGroup $group): Collection => $group->items)
            ->keyBy('id');
        $selectedItems = $comboItemIds->map(fn (int $itemId) => $availableItems->get($itemId));

        if ($selectedItems->contains(null)) {
            throw ValidationException::withMessages([
                'combo_items' => __('client/cart.errors.combo_invalid'),
            ]);
        }

        $selectedItems = $selectedItems->filter();

        foreach ($product->comboGroups as $group) {
            $effectiveMax = max(1, (int) $group->max_select);
            $effectiveMin = min(
                $group->is_required ? max(1, (int) $group->min_select) : 0,
                $effectiveMax,
            );
            $selectedCount = $selectedItems->where('combo_group_id', $group->id)->count();

            if ($selectedCount < $effectiveMin || $selectedCount > $effectiveMax) {
                throw ValidationException::withMessages([
                    'combo_items' => __('client/cart.errors.combo_range', [
                        'group' => $group->name,
                        'min' => $effectiveMin,
                        'max' => $effectiveMax,
                    ]),
                ]);
            }
        }

        $unavailableItem = $selectedItems->first(function (ComboGroupItem $item): bool {
            if ($item->product) {
                return ! $item->product->status instanceof Active;
            }

            return ! $item->variant
                || ! $item->variant->is_active
                || ! ($item->variant->product->status instanceof Active);
        });

        if ($unavailableItem) {
            throw ValidationException::withMessages([
                'combo_items' => __('client/cart.errors.combo_unavailable'),
            ]);
        }

        return $selectedItems->values();
    }

    /**
     * @param  Collection<int, ComboGroupItem>  $selectedItems
     * @return array<string, mixed>
     */
    private function buildCartItem(Product $product, ?ProductVariant $variant, Collection $selectedItems, int $quantity): array
    {
        $comboSelections = $selectedItems
            ->sortBy('id')
            ->map(function (ComboGroupItem $item): array {
                $selectionProduct = $item->product ?? $item->variant?->product;
                $selectionName = $item->product?->name ?? trim(($item->variant?->product?->name ?? '').' '.$item->variant?->name);

                return [
                    'combo_group_id' => $item->combo_group_id,
                    'combo_group_item_id' => $item->id,
                    'combo_group_name' => $item->comboGroup->name,
                    'product_id' => $selectionProduct?->id,
                    'product_variant_id' => $item->product_variant_id,
                    'label' => $selectionName,
                    'extra_price' => $this->money($item->extra_price),
                ];
            })
            ->values()
            ->all();

        $unitPrice = (float) $product->price
            + (float) ($variant?->price_adjustment ?? 0)
            + collect($comboSelections)->sum(fn (array $selection): float => (float) $selection['extra_price']);
        $configuration = [
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'combo_group_item_ids' => Arr::pluck($comboSelections, 'combo_group_item_id'),
        ];
        $key = sha1(json_encode($configuration));

        return [
            'key' => $key,
            'product_id' => $product->id,
            'product_variant_id' => $variant?->id,
            'name' => $product->name,
            'variant_name' => $variant?->name,
            'image' => $product->thumbnail->first()?->getUrl(),
            'quantity' => $quantity,
            'unit_price' => $this->money($unitPrice),
            'subtotal' => $this->money($unitPrice * $quantity),
            'combo_selections' => $comboSelections,
        ];
    }

    private function money(mixed $value): float
    {
        return round((float) $value, 2);
    }
}
