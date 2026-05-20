<div class="rounded-3xl border border-dashed border-zinc-300 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
    <flux:icon name="shopping-bag" class="mx-auto mb-4 size-12 text-zinc-400" />
    <p class="text-lg font-bold">{{ __('client/orders.empty') }}</p>
    <flux:button :href="route('menu')" wire:navigate class="mt-5 !bg-brand-red !text-white">
        {{ __('client/cart.browse_menu') }}
    </flux:button>
</div>

