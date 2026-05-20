@php
    $defaultComboExtras = $product->is_combo
        ? $product->comboGroups
            ->filter(fn ($group) => $group->is_required && max(1, (int) $group->min_select) > 0)
            ->mapWithKeys(function ($group): array {
                $defaultItems = $group->items
                    ->filter(fn ($item): bool => $item->product !== null || $item->variant !== null)
                    ->take(min(max(1, (int) $group->min_select), (int) $group->max_select));

                return $defaultItems->isNotEmpty()
                    ? [$group->id => $defaultItems->mapWithKeys(fn ($item): array => [$item->id => (float) $item->extra_price])->all()]
                    : [];
            })
            ->all()
        : [];

    $comboRequirements = $product->is_combo
        ? $product->comboGroups
            ->mapWithKeys(fn ($group): array => [
                $group->id => min(
                    $group->is_required ? max(1, (int) $group->min_select) : 0,
                    max(1, (int) $group->max_select),
                ),
            ])
            ->all()
        : [];
@endphp

<x-layouts::main title="{{ __('client/details.title') }}">
    <div class="-mx-6 lg:-mx-8 -mt-6 lg:-mt-8 flex-1 flex flex-col bg-zinc-50/50 dark:bg-zinc-950/50">
        <main
            class="flex-grow w-full max-w-7xl mx-auto px-6 py-12 md:py-20"
            x-data="{
                qty: 1,
                basePrice: {{ (float) $product->price }},
                selectedVariantId: @js($product->variants->first()?->id),
                variantExtra: {{ (float) ($product->variants->first()?->price_adjustment ?? 0) }},
                comboExtras: @js($defaultComboExtras),
                comboRequirements: @js($comboRequirements),
                cartError: null,
                isAddingToCart: false,
                setComboExtra(groupId, itemId, extraPrice, checked, maxSelect) {
                    if (! this.comboExtras[groupId] || maxSelect === 1) {
                        this.comboExtras[groupId] = {};
                    }

                    if (checked) {
                        this.comboExtras[groupId][itemId] = Number(extraPrice);
                    } else {
                        delete this.comboExtras[groupId][itemId];
                    }
                },
                selectedComboCount(groupId) {
                    return Object.keys(this.comboExtras[groupId] ?? {}).length;
                },
                canAddToCart() {
                    return Object.entries(this.comboRequirements)
                        .every(([groupId, minimum]) => this.selectedComboCount(groupId) >= Number(minimum));
                },
                unitPrice() {
                    return this.basePrice + this.variantExtra + Object.values(this.comboExtras)
                        .flatMap((group) => Object.values(group))
                        .reduce((total, price) => total + Number(price), 0);
                },
                totalPrice() {
                    return this.unitPrice() * this.qty;
                },
                formatPrice(price) {
                    return Number(price).toFixed(2) + ' EUR';
                },
                selectedComboItemIds() {
                    return Object.values(this.comboExtras).flatMap((group) => Object.keys(group));
                },
                async addToCart() {
                    if (! this.canAddToCart() || this.isAddingToCart) {
                        return;
                    }

                    this.isAddingToCart = true;
                    this.cartError = null;

                    const response = await fetch(@js(route('cart.items.store')), {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': @js(csrf_token()),
                        },
                        body: JSON.stringify({
                            product_id: {{ $product->id }},
                            variant_id: this.selectedVariantId,
                            quantity: this.qty,
                            combo_items: this.selectedComboItemIds(),
                        }),
                    });

                    const data = await response.json();
                    this.isAddingToCart = false;

                    if (! response.ok) {
                        this.cartError = data.message || Object.values(data.errors || {})?.[0]?.[0] || @js(__('client/cart.errors.add_failed'));
                        return;
                    }

                    window.dispatchEvent(new CustomEvent('cart-updated', { detail: { cart: data.cart } }));
                },
            }"
        >
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-20 items-start">
                <div class="lg:sticky lg:top-24" data-animate="fade-right">
                    @include('details.partials.product-image')
                </div>
                <div class="flex flex-col gap-8" data-animate="fade-left">
                    @include('details.partials.product-info')

                    @include('details.partials.variants')
                    
                    @if($product->is_combo)
                        @foreach($product->comboGroups as $group)
                            @include('details.partials.combo-group', ['group' => $group])
                        @endforeach
                    @endif

                    @include('details.partials.actions')
                </div>
            </div>
            @include('details.partials.related-items')
        </main>
        
        @include('partials.footer')
    </div>
</x-layouts::main>
