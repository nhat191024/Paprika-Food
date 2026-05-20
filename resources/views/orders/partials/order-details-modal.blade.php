@php
    $status = $order->status->getValue();
    $steps = [
        'pending' => __('admin/order.status.pending'),
        'processing' => __('admin/order.status.processing'),
        'ready' => __('admin/order.status.ready'),
        'completed' => __('admin/order.status.completed'),
    ];
    $activeIndex = array_search($status, array_keys($steps), true);
    $activeIndex = $activeIndex === false ? -1 : $activeIndex;
@endphp

<flux:modal name="order-details-{{ $order->id }}" class="w-full max-w-2xl" :closable="false">
    <div class="space-y-6">
        <div class="flex items-start justify-between gap-4 border-b border-zinc-200 pb-4 dark:border-zinc-800">
            <div>
                <flux:heading size="lg">{{ __('client/orders.details') }}</flux:heading>
                <p class="mt-1 text-sm text-zinc-500">#{{ $order->order_number }}</p>
                <p class="mt-1 text-sm text-zinc-500">{{ $order->created_at->format('M d, Y') }}</p>
                @if($order->scheduled_delivery_time)
                    <p class="mt-2 flex items-center gap-1.5 text-sm font-bold text-brand-red">
                        <flux:icon.clock class="size-4" />
                        {{ __('client/checkout.delivery_time') }}: {{ $order->scheduled_delivery_time->format('M d, Y H:i') }}
                    </p>
                @else
                    <p class="mt-2 flex items-center gap-1.5 text-sm font-bold text-emerald-600 dark:text-emerald-400">
                        <flux:icon.bolt class="size-4" />
                        {{ __('client/checkout.asap') }}
                    </p>
                @endif
            </div>

            <div class="flex items-center gap-2">
                <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-bold text-brand-red dark:bg-red-500/10">
                    {{ __('admin/order.status.' . $status) }}
                </span>
                <flux:modal.close>
                    <flux:button variant="ghost" icon="x-mark" :title="__('client/orders.close')" />
                </flux:modal.close>
            </div>
        </div>

        @if($status === 'cancelled')
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-700 dark:border-red-900 dark:bg-red-950 dark:text-red-200">
                {{ __('admin/order.status.cancelled') }}
            </div>
        @else
            <section class="space-y-3">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('client/orders.order_status') }}</h3>

                <div class="relative grid grid-cols-4 gap-3">
                    <div class="absolute left-0 right-0 top-4 h-1 rounded-full bg-zinc-200 dark:bg-zinc-800"></div>
                    <div
                        class="absolute left-0 top-4 h-1 rounded-full bg-amber-400"
                        style="width: {{ max(0, min(3, $activeIndex)) / 3 * 100 }}%;"
                    ></div>

                    @foreach($steps as $stepKey => $label)
                        @php
                            $index = array_search($stepKey, array_keys($steps), true);
                            $isActive = $index !== false && $index <= $activeIndex;
                        @endphp

                        <div class="relative z-10 flex flex-col items-center gap-2 text-center">
                            <div class="{{ $isActive ? 'bg-amber-400 text-zinc-900' : 'bg-zinc-200 text-zinc-500 dark:bg-zinc-800 dark:text-zinc-300' }} flex size-8 items-center justify-center rounded-full text-xs font-black">
                                {{ $index + 1 }}
                            </div>
                            <div class="{{ $isActive ? 'text-zinc-900 dark:text-white' : 'text-zinc-500' }} text-xs font-semibold">
                                {{ $label }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        <section class="space-y-3">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('client/orders.ordered_items') }}</h3>

            <div class="divide-y divide-zinc-200 rounded-2xl border border-zinc-200 bg-zinc-50 dark:divide-zinc-800 dark:border-zinc-800 dark:bg-zinc-950">
                @foreach($order->items as $item)
                    <div class="flex gap-4 p-4">
                        <div class="size-16 shrink-0 overflow-hidden rounded-2xl bg-white dark:bg-zinc-900">
                            @if($item->product->thumbnail->first())
                                <div class="relative size-full flex items-center justify-center">
                                    <img src="{{ $item->product->thumbnail->first()->getUrl() }}" alt="{{ $item->product_name ?? $item->product->name }}" class="size-full object-contain" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="hidden size-full items-center justify-center bg-white dark:bg-zinc-900">
                                        <svg class="size-6 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                        </svg>
                                    </div>
                                </div>
                            @else
                                <div class="flex size-full items-center justify-center bg-white dark:bg-zinc-900">
                                    <svg class="size-6 text-zinc-300 dark:text-zinc-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 15.75l5.159-5.159a2.25 2.25 0 013.182 0l5.159 5.159m-1.5-1.5l1.409-1.409a2.25 2.25 0 013.182 0l2.909 2.909m-18 3.75h16.5a1.5 1.5 0 001.5-1.5V6a1.5 1.5 0 00-1.5-1.5H3.75A1.5 1.5 0 002.25 6v12a1.5 1.5 0 001.5 1.5zm10.5-11.25h.008v.008h-.008V8.25zm.375 0a.375.375 0 11-.75 0 .375.375 0 01.75 0z" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <div class="min-w-0 flex-1">
                            <p class="truncate text-sm font-black text-zinc-900 dark:text-white">
                                {{ $item->product_name ?? $item->product->name }}
                            </p>
                            @if($item->product_variant_name)
                                <p class="text-xs text-zinc-500">{{ $item->product_variant_name }}</p>
                            @endif

                            @if($item->selections->isNotEmpty())
                                <div class="mt-2 space-y-2">
                                    @foreach($item->selections->groupBy(fn ($selection) => $selection->combo_group_name ?: __('client/orders.add_ons')) as $groupName => $selections)
                                        <div>
                                            <p class="text-xs font-bold text-zinc-700 dark:text-zinc-200">{{ $groupName }}</p>
                                            <ul class="mt-1 space-y-1">
                                                @foreach($selections as $selection)
                                                    <li class="flex items-start justify-between gap-2 text-xs text-zinc-600 dark:text-zinc-300">
                                                        <span class="min-w-0 truncate">{{ $selection->selection_name ?? ($selection->product->name ?? '') }}</span>
                                                        @if((float) $selection->extra_price !== 0.0)
                                                            <span class="shrink-0 font-semibold text-zinc-900 dark:text-white">+{{ number_format((float) $selection->extra_price, 2) }} EUR</span>
                                                        @endif
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>

                        <div class="text-right">
                            <p class="text-sm font-bold text-zinc-900 dark:text-white">{{ number_format((float) $item->price, 2) }} EUR</p>
                            <p class="text-xs text-zinc-500">x{{ $item->quantity }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <section class="grid gap-4 md:grid-cols-2">
            <div class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('client/orders.recipient_information') }}</h3>
                <p class="mt-2 text-sm font-semibold text-zinc-900 dark:text-white">{{ $order->delivery_recipient_name ?: '—' }}</p>
                <p class="text-sm text-zinc-500">{{ $order->delivery_phone ?: '—' }}</p>
            </div>

            <div class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('client/orders.delivery_address') }}</h3>
                <p class="mt-2 whitespace-pre-line text-sm text-zinc-700 dark:text-zinc-200">{{ $order->delivery_address_detail ?: '—' }}</p>
            </div>
        </section>

        <section class="rounded-2xl border border-zinc-200 bg-white p-4 dark:border-zinc-800 dark:bg-zinc-900">
            <h3 class="text-sm font-bold text-zinc-900 dark:text-white">{{ __('client/orders.payment_summary') }}</h3>

            <div class="mt-3 space-y-2 text-sm">
                <div class="flex items-center justify-between text-zinc-600 dark:text-zinc-300">
                    <span>{{ __('client/orders.subtotal') }}</span>
                    <span class="text-zinc-900 dark:text-white">{{ number_format((float) $order->total_amount, 2) }} EUR</span>
                </div>
                <div class="flex items-center justify-between text-zinc-600 dark:text-zinc-300">
                    <span class="text-brand-red">{{ __('client/orders.discount') }}</span>
                    <span class="text-brand-red">-{{ number_format((float) $order->discount_amount, 2) }} EUR</span>
                </div>
                <div class="flex items-center justify-between border-t border-zinc-200 pt-2 text-base font-black dark:border-zinc-800">
                    <span>{{ __('client/orders.total') }}</span>
                    <span class="text-brand-red">{{ number_format((float) $order->final_amount, 2) }} EUR</span>
                </div>
                <div class="pt-1 text-xs text-zinc-500">
                    {{ __('client/orders.payment_via') }} {{ __('admin/order.payment_method.' . $order->payment_method->value) }}
                </div>
            </div>
        </section>

        <div class="flex justify-end gap-2 border-t border-zinc-200 pt-4 dark:border-zinc-800">
            <flux:modal.close>
                <flux:button variant="filled">{{ __('client/orders.close') }}</flux:button>
            </flux:modal.close>
            <flux:button :href="route('menu')" wire:navigate class="!bg-brand-red !text-white">
                {{ __('client/orders.reorder') }}
            </flux:button>
        </div>
    </div>
</flux:modal>

