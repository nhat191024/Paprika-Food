<flux:modal.trigger name="order-details-{{ $order->id }}">
    <article
        role="button"
        tabindex="0"
        class="cursor-pointer rounded-3xl mb-3 border border-zinc-200 bg-white p-6 shadow-sm transition-shadow hover:shadow-md dark:border-zinc-800 dark:bg-zinc-900"
        x-data=""
        x-on:click="$dispatch('open-modal', 'order-details-{{ $order->id }}')"
        x-on:keydown.enter.prevent="$dispatch('open-modal', 'order-details-{{ $order->id }}')"
        x-on:keydown.space.prevent="$dispatch('open-modal', 'order-details-{{ $order->id }}')"
    >
        <div class="grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
            <div>
                <div class="mb-3 flex flex-wrap items-center gap-3">
                    <span class="font-black">#{{ $order->order_number }}</span>
                    <span class="text-sm text-zinc-500">{{ $order->created_at->format('M d, Y') }}</span>
                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-brand-red dark:bg-red-500/10">
                        {{ __('admin/order.status.' . $order->status->getValue()) }}
                    </span>
                    @if($order->scheduled_delivery_time)
                        <span class="flex items-center gap-1 rounded-full bg-amber-50 dark:bg-amber-500/10 px-3 py-1 text-xs font-bold text-amber-600 dark:text-amber-400">
                            <flux:icon.clock class="size-3.5" />
                            {{ $order->scheduled_delivery_time->format('M d, H:i') }}
                        </span>
                    @endif
                </div>

                <p class="font-semibold">
                    {{ $order->items->map(fn ($item) => $item->quantity . 'x ' . ($item->product_name ?? $item->product->name))->join(', ') }}
                </p>

                <div class="mt-4 flex -space-x-3">
                    @foreach($order->items->take(4) as $item)
                        <div class="size-12 overflow-hidden rounded-full border-2 border-white bg-zinc-100 dark:border-zinc-900 dark:bg-zinc-800">
                            @if($item->product->thumbnail->first())
                                <img src="{{ $item->product->thumbnail->first()->getUrl() }}" alt="{{ $item->product_name ?? $item->product->name }}" class="size-full object-contain">
                            @else
                                <div class="flex size-full items-center justify-center">
                                    <flux:icon name="utensils" class="size-5 text-zinc-300" />
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border-t border-zinc-200 pt-4 text-left md:border-l md:border-t-0 md:pl-8 md:pt-0 md:text-right dark:border-zinc-800">
                <p class="text-sm text-zinc-500">{{ $order->created_at->format('M d, Y') }}</p>
                <p class="text-2xl font-black text-brand-yellow">{{ number_format((float) $order->final_amount, 2) }} EUR</p>
                <flux:button
                    :href="route('menu')"
                    wire:navigate
                    variant="ghost"
                    class="mt-3"
                    x-on:click.stop
                >
                    {{ __('client/orders.reorder') }}
                </flux:button>
            </div>
        </div>
    </article>
</flux:modal.trigger>

