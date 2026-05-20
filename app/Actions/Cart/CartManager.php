<?php

namespace App\Actions\Cart;

use App\Models\ComboGroup;
use App\Models\ComboGroupItem;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Voucher;
use App\States\Product\Active;
use App\States\Voucher\Active as VoucherActive;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class CartManager
{
    private const SESSION_KEY = 'cart.items';

    private const SESSION_ORDER_IDS_KEY = 'cart.order_ids';

    private const SESSION_VOUCHER_KEY = 'cart.voucher';

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
        session()->forget(self::SESSION_VOUCHER_KEY);
    }

    public function applyVoucher(string $code): void
    {
        session()->put(self::SESSION_VOUCHER_KEY, $code);
    }

    public function removeVoucher(): void
    {
        session()->forget(self::SESSION_VOUCHER_KEY);
    }

    /**
     * @return array<string, mixed>
     */
    public function summary(): array
    {
        $items = array_values($this->items());

        $locale = app()->getLocale();
        $fallback = config('app.fallback_locale', 'en');

        $items = array_map(function (array $item) use ($locale, $fallback) {
            if (isset($item['name_translations'])) {
                $item['name'] = $item['name_translations'][$locale]
                    ?? $item['name_translations'][$fallback]
                    ?? collect($item['name_translations'])->first()
                    ?? $item['name'];
            }
            if (isset($item['variant_name_translations']) && $item['variant_name_translations']) {
                $item['variant_name'] = $item['variant_name_translations'][$locale]
                    ?? $item['variant_name_translations'][$fallback]
                    ?? collect($item['variant_name_translations'])->first()
                    ?? $item['variant_name'];
            }

            if (isset($item['combo_selections'])) {
                foreach ($item['combo_selections'] as &$selection) {
                    if (isset($selection['combo_group_name_translations'])) {
                        $selection['combo_group_name'] = $selection['combo_group_name_translations'][$locale]
                            ?? $selection['combo_group_name_translations'][$fallback]
                            ?? collect($selection['combo_group_name_translations'])->first()
                            ?? $selection['combo_group_name'];
                    }
                    if (isset($selection['label_translations'])) {
                        $selection['label'] = $selection['label_translations'][$locale]
                            ?? $selection['label_translations'][$fallback]
                            ?? collect($selection['label_translations'])->first()
                            ?? $selection['label'];
                    }
                }
            }

            return $item;
        }, $items);

        $subtotal = collect($items)->sum(fn (array $item): float => (float) $item['subtotal']);

        $discountAmount = 0.0;
        $voucherCode = null;
        $voucherId = null;

        $code = session()->get(self::SESSION_VOUCHER_KEY);
        if ($code && $subtotal > 0) {
            $voucher = Voucher::query()->where('code', $code)->first();

            if ($voucher &&
                $voucher->status instanceof VoucherActive &&
                $voucher->start_date->startOfDay() <= now() &&
                $voucher->end_date->endOfDay() >= now() &&
                $subtotal >= (float) $voucher->min_order_amount &&
                ($voucher->is_unlimited || $voucher->used_count < $voucher->usage_limit)
            ) {
                if ($voucher->discount_type === 'percentage') {
                    $discountAmount = $subtotal * ((float) $voucher->discount_value / 100);
                } else {
                    $discountAmount = (float) $voucher->discount_value;
                }

                if ($voucher->max_discount && $voucher->max_discount > 0) {
                    $discountAmount = min($discountAmount, (float) $voucher->max_discount);
                }

                $discountAmount = min($discountAmount, $subtotal); // Cannot discount more than subtotal
                $voucherCode = $voucher->code;
                $voucherId = $voucher->id;
            } else {
                // Invalid voucher, remove it quietly
                $this->removeVoucher();
            }
        }

        return [
            'items' => $items,
            'count' => collect($items)->sum(fn (array $item): int => (int) $item['quantity']),
            'subtotal' => $this->money($subtotal),
            'discount' => $this->money($discountAmount),
            'total' => $this->money(max(0, $subtotal - $discountAmount)),
            'voucher_code' => $voucherCode,
            'voucher_id' => $voucherId,
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

                $labelTranslations = [];
                if ($item->product) {
                    $labelTranslations = $item->product->getTranslations('name');
                } elseif ($item->variant) {
                    $productTranslations = $item->variant->product->getTranslations('name');
                    $variantTranslations = $item->variant->getTranslations('name');
                    $locales = array_unique(array_merge(array_keys($productTranslations), array_keys($variantTranslations)));
                    foreach ($locales as $loc) {
                        $labelTranslations[$loc] = trim(($productTranslations[$loc] ?? '').' '.($variantTranslations[$loc] ?? ''));
                    }
                }

                return [
                    'combo_group_id' => $item->combo_group_id,
                    'combo_group_item_id' => $item->id,
                    'combo_group_name' => $item->comboGroup->name,
                    'combo_group_name_translations' => $item->comboGroup->getTranslations('name'),
                    'product_id' => $selectionProduct?->id,
                    'product_variant_id' => $item->product_variant_id,
                    'label' => $selectionName,
                    'label_translations' => $labelTranslations,
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
            'name_translations' => $product->getTranslations('name'),
            'variant_name' => $variant?->name,
            'variant_name_translations' => $variant ? $variant->getTranslations('name') : null,
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
