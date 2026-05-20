@php
    $cart = app(\App\Actions\Cart\CartManager::class)->summary();
@endphp

<div
    x-data="{
        cart: @js($cart),
        isOpen: false,
        isLoading: false,
        errors: null,
        formatPrice(value) {
            return Number(value || 0).toFixed(2) + ' EUR';
        },
        open() {
            this.isOpen = true;
        },
        close() {
            this.isOpen = false;
        },
        async refresh() {
            const response = await fetch(@js(route('cart.summary')), {
                headers: { 'Accept': 'application/json' },
            });
            const data = await response.json();
            this.cart = data.cart;
        },
        async updateQuantity(key, quantity) {
            this.isLoading = true;

            const response = await fetch(@js(url('/cart/items')) + '/' + key, {
                method: 'PATCH',
                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': @js(csrf_token()),
                },
                body: JSON.stringify({ quantity }),
            });
            const data = await response.json();
            this.cart = data.cart;
            this.isLoading = false;
        },
        async remove(key) {
            this.isLoading = true;

            const response = await fetch(@js(url('/cart/items')) + '/' + key, {
                method: 'DELETE',
                headers: {
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': @js(csrf_token()),
                },
            });
            const data = await response.json();
            this.cart = data.cart;
            this.isLoading = false;
        },
    }"
    x-on:cart-open.window="open(); refresh()"
    x-on:cart-updated.window="cart = $event.detail.cart; open()"
    x-cloak
>
    @if(! request()->routeIs('checkout.show'))
    <button
        type="button"
        x-show="cart.count > 0 && ! isOpen"
        x-transition
        x-on:click="open()"
        class="fixed inset-x-0 bottom-0 z-40 border-t border-red-700 bg-brand-red px-4 py-3 text-white shadow-2xl"
    >
        <span class="mx-auto flex max-w-7xl items-center justify-between gap-4 text-sm font-bold">
            <span>
                <span x-text="cart.count"></span>
                <span>{{ __('client/cart.pending_items') }}</span>
            </span>
            <span class="flex items-center gap-3">
                <span x-text="formatPrice(cart.total)"></span>
                <span class="hidden sm:inline">{{ __('client/cart.checkout_now') }}</span>
                <flux:icon name="arrow-right" class="size-4" />
            </span>
        </span>
    </button>
    @endif

    <div
        x-show="isOpen"
        x-transition.opacity
        class="fixed inset-0 z-50 bg-black/40 backdrop-blur-sm"
        x-on:click.self="close()"
    ></div>

    <aside
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="translate-y-full opacity-0 sm:translate-y-0 sm:translate-x-full"
        x-transition:enter-end="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="translate-y-0 opacity-100 sm:translate-x-0"
        x-transition:leave-end="translate-y-full opacity-0 sm:translate-y-0 sm:translate-x-full"
        class="fixed inset-x-0 bottom-0 z-50 max-h-[90vh] overflow-hidden rounded-t-3xl bg-white shadow-2xl dark:bg-zinc-950 sm:inset-x-auto sm:right-4 sm:top-4 sm:bottom-4 sm:w-[28rem] sm:rounded-3xl"
    >
        <div class="flex h-full flex-col">
            <div class="flex items-center justify-between border-b border-zinc-200 p-6 dark:border-zinc-800">
                <flux:heading size="xl">{{ __('client/cart.title') }}</flux:heading>
                <button type="button" x-on:click="close()" class="rounded-full bg-zinc-100 p-3 text-zinc-700 hover:bg-zinc-200 dark:bg-zinc-900 dark:text-zinc-200 dark:hover:bg-zinc-800">
                    <flux:icon name="x-mark" class="size-5" />
                </button>
            </div>

            <div class="flex-1 overflow-y-auto p-6">
                <template x-if="cart.items.length === 0">
                    <div class="rounded-2xl border border-dashed border-zinc-300 p-8 text-center dark:border-zinc-700">
                        <flux:icon name="shopping-cart" class="mx-auto mb-3 size-10 text-zinc-400" />
                        <p class="font-semibold">{{ __('client/cart.empty') }}</p>
                        <a href="{{ route('menu') }}" wire:navigate class="mt-4 inline-flex rounded-full bg-brand-red px-5 py-2 text-sm font-bold text-white">
                            {{ __('client/cart.browse_menu') }}
                        </a>
                    </div>
                </template>

                <template x-for="item in cart.items" :key="item.key">
                    <div class="flex gap-4 border-b border-zinc-100 py-5 last:border-0 dark:border-zinc-800">
                        <div class="size-20 shrink-0 overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-900">
                            <template x-if="item.image">
                                <img :src="item.image" :alt="item.name" class="size-full object-contain">
                            </template>
                            <template x-if="! item.image">
                                <div class="flex size-full items-center justify-center">
                                    <flux:icon name="utensils" class="size-8 text-zinc-300" />
                                </div>
                            </template>
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate font-bold text-zinc-900 dark:text-white" x-text="item.name"></p>
                            <p class="text-sm text-zinc-500" x-show="item.variant_name" x-text="item.variant_name"></p>
                            <template x-for="selection in item.combo_selections" :key="selection.combo_group_item_id">
                                <p class="text-xs text-zinc-500">
                                    <span x-text="selection.combo_group_name"></span>:
                                    <span x-text="selection.label"></span>
                                </p>
                            </template>
                            <p class="mt-2 font-semibold" x-text="formatPrice(item.unit_price)"></p>
                        </div>

                        <div class="flex shrink-0 flex-col items-center rounded-full bg-zinc-100 px-3 py-2 dark:bg-zinc-900">
                            <button type="button" x-on:click="updateQuantity(item.key, item.quantity + 1)" class="p-1" :disabled="isLoading">
                                <flux:icon name="plus" class="size-4" />
                            </button>
                            <span class="py-1 text-sm font-bold" x-text="item.quantity"></span>
                            <button type="button" x-on:click="updateQuantity(item.key, item.quantity - 1)" class="p-1" :disabled="isLoading">
                                <flux:icon name="minus" class="size-4" />
                            </button>
                        </div>
                    </div>
                </template>
            </div>

            <div class="border-t border-zinc-200 p-6 dark:border-zinc-800" x-show="cart.items.length > 0">
                <div class="mb-4 flex justify-between text-zinc-600 dark:text-zinc-300">
                    <span>{{ __('client/cart.subtotal') }}</span>
                    <span x-text="formatPrice(cart.subtotal)"></span>
                </div>
                <div class="mb-6 flex justify-between text-xl font-black text-zinc-900 dark:text-white">
                    <span>{{ __('client/cart.total') }}</span>
                    <span x-text="formatPrice(cart.total)"></span>
                </div>
                <a href="{{ route('checkout.show') }}" class="flex w-full items-center justify-center gap-3 rounded-full bg-brand-red px-6 py-4 text-sm font-black uppercase tracking-wide text-white hover:bg-red-700">
                    {{ __('client/cart.proceed_to_checkout') }}
                    <flux:icon name="arrow-right" class="size-5" />
                </a>
            </div>
        </div>
    </aside>
</div>
