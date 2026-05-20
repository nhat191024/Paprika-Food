<x-layouts::main title="{{ __('client/cart.title') }}">
    <div class="-mx-6 -mt-6 flex-1 bg-zinc-50 px-6 py-12 dark:bg-zinc-950 lg:-mx-8 lg:-mt-8 lg:px-8">
        <div class="mx-auto max-w-4xl">
            <div class="mb-8 flex items-center justify-between gap-4">
                <div>
                    <flux:heading size="xl">{{ __('client/cart.title') }}</flux:heading>
                    <p class="mt-2 text-zinc-500">{{ __('client/cart.page_description') }}</p>
                </div>
                <flux:button :href="route('menu')" wire:navigate variant="ghost">{{ __('client/cart.browse_menu') }}</flux:button>
            </div>

            @if($cart['is_empty'])
                <div class="rounded-3xl border border-dashed border-zinc-300 bg-white p-12 text-center dark:border-zinc-700 dark:bg-zinc-900">
                    <flux:icon name="shopping-cart" class="mx-auto mb-4 size-12 text-zinc-400" />
                    <p class="text-lg font-bold">{{ __('client/cart.empty') }}</p>
                </div>
            @else
                <div class="rounded-3xl border border-zinc-200 bg-white p-6 shadow-sm dark:border-zinc-800 dark:bg-zinc-900">
                    <div class="space-y-5">
                        @foreach($cart['items'] as $item)
                            <div class="flex gap-4 border-b border-zinc-100 pb-5 last:border-0 last:pb-0 dark:border-zinc-800">
                                <div class="size-20 shrink-0 overflow-hidden rounded-2xl bg-zinc-100 dark:bg-zinc-800">
                                    @if($item['image'])
                                        <div class="relative size-full flex items-center justify-center">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="size-full object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                            <div class="hidden size-full items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                                                <svg class="size-8 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                                </svg>
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex size-full items-center justify-center bg-zinc-100 dark:bg-zinc-800">
                                            <svg class="size-8 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <p class="font-bold">{{ $item['name'] }}</p>
                                    @if($item['variant_name'])
                                        <p class="text-sm text-zinc-500">{{ $item['variant_name'] }}</p>
                                    @endif
                                    @foreach($item['combo_selections'] as $selection)
                                        <p class="text-sm text-zinc-500">{{ $selection['combo_group_name'] }}: {{ $selection['label'] }}</p>
                                    @endforeach
                                </div>
                                <div class="text-right">
                                    <p class="font-bold">{{ number_format($item['subtotal'], 2) }} EUR</p>
                                    <p class="text-sm text-zinc-500">x{{ $item['quantity'] }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8 flex items-center justify-between border-t border-zinc-200 pt-6 dark:border-zinc-800">
                        <span class="text-xl font-black">{{ __('client/cart.total') }}</span>
                        <span class="text-xl font-black">{{ number_format($cart['total'], 2) }} EUR</span>
                    </div>

                    <flux:button :href="route('checkout.show')" wire:navigate class="mt-6 w-full !bg-brand-red !text-white">
                        {{ __('client/cart.proceed_to_checkout') }}
                    </flux:button>
                </div>
            @endif
        </div>
    </div>
</x-layouts::main>
