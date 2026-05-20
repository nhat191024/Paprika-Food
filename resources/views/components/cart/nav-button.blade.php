<button
    type="button"
    x-data
    x-on:click="$dispatch('cart-open')"
    class="relative inline-flex size-10 items-center justify-center rounded-full text-zinc-700 transition hover:bg-zinc-100 hover:text-brand-red dark:text-zinc-200 dark:hover:bg-zinc-800"
    aria-label="{{ __('client/cart.open_cart') }}"
>
    <flux:icon name="shopping-cart" class="size-5" />
</button>
