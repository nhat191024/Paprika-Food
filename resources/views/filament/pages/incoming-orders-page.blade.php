<x-filament-panels::page>
    <audio id="notification-sound" src="{{ asset('sound/notificaiton.mp3') }}" preload="auto"></audio>

    <div
        wire:poll.5s="pollOrders"
        x-data
        @play-notification-sound.window="
            const audio = document.getElementById('notification-sound');
            if (audio) { audio.currentTime = 0; audio.play().catch(() => {}); }
        "
    >
        {{-- Pending Orders Section --}}
        <div class="mb-8">
            <div class="mb-4 flex items-center gap-3">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">
                    {{ __('admin/order.status.pending') }}
                </h2>
                <span class="inline-flex items-center rounded-full bg-gray-100 px-2.5 py-0.5 text-sm font-medium text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                    {{ $pendingOrders->count() }}
                </span>
            </div>

            @if ($pendingOrders->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-200 bg-white py-12 dark:border-gray-700 dark:bg-gray-900">
                    <x-filament::icon class="mb-3 h-10 w-10 text-gray-300 dark:text-gray-600" icon="heroicon-o-check-circle" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('admin/order.incoming.no_pending') }}
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($pendingOrders as $order)
                        <div class="flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm dark:border-gray-700 dark:bg-gray-900">
                            {{-- Card body --}}
                            <div class="flex flex-1 flex-col gap-2 p-4">
                                <p class="text-sm font-bold text-gray-950 dark:text-white">
                                    {{ $order->order_number }}
                                </p>

                                <div class="flex flex-wrap gap-1.5">
                                    <x-filament::badge color="gray">
                                        {{ __('admin/order.status.' . $order->status->getValue()) }}
                                    </x-filament::badge>
                                    <x-filament::badge color="{{ $order->order_type->value === 'online' ? 'info' : 'warning' }}">
                                        {{ __('admin/order.order_type.' . $order->order_type->value) }}
                                    </x-filament::badge>
                                </div>

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->customer?->name ?? '—' }}
                                </p>
                            </div>

                            {{-- Card footer --}}
                            <div class="border-t border-gray-100 px-4 py-2 dark:border-gray-800">
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ number_format((float) $order->final_amount, 2) }} €
                                    &middot;
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                                <x-filament::button class="flex-1" wire:click="confirmOrder({{ $order->id }})" wire:loading.attr="disabled" wire:target="confirmOrder({{ $order->id }})" size="sm" color="success" icon="heroicon-o-check-circle">
                                    {{ __('admin/order.actions.confirm') }}
                                </x-filament::button>

                                <x-filament::button tag="a" href="{{ \App\Filament\Pages\IncomingOrdersPage::getViewOrderUrl($order) }}" size="sm" color="gray" icon="heroicon-o-eye" outlined>
                                    {{ __('admin/order.actions.view') }}
                                </x-filament::button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Processing Orders Section --}}
        <div>
            <div class="mb-4 flex items-center gap-3">
                <h2 class="text-lg font-semibold text-gray-950 dark:text-white">
                    {{ __('admin/order.status.processing') }}
                </h2>
                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-0.5 text-sm font-medium text-blue-700 dark:bg-blue-900/30 dark:text-blue-300">
                    {{ $processingOrders->count() }}
                </span>
            </div>

            @if ($processingOrders->isEmpty())
                <div class="flex flex-col items-center justify-center rounded-xl border border-dashed border-gray-200 bg-white py-12 dark:border-gray-700 dark:bg-gray-900">
                    <x-filament::icon class="mb-3 h-10 w-10 text-gray-300 dark:text-gray-600" icon="heroicon-o-clock" />
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        {{ __('admin/order.incoming.no_processing') }}
                    </p>
                </div>
            @else
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                    @foreach ($processingOrders as $order)
                        <div class="flex flex-col overflow-hidden rounded-xl border border-blue-100 bg-white shadow-sm dark:border-blue-900/40 dark:bg-gray-900">
                            {{-- Card body --}}
                            <div class="flex flex-1 flex-col gap-2 p-4">
                                <p class="text-sm font-bold text-gray-950 dark:text-white">
                                    {{ $order->order_number }}
                                </p>

                                <div class="flex flex-wrap gap-1.5">
                                    <x-filament::badge color="info">
                                        {{ __('admin/order.status.' . $order->status->getValue()) }}
                                    </x-filament::badge>
                                    <x-filament::badge color="{{ $order->order_type->value === 'online' ? 'info' : 'warning' }}">
                                        {{ __('admin/order.order_type.' . $order->order_type->value) }}
                                    </x-filament::badge>
                                </div>

                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ $order->customer?->name ?? '—' }}
                                </p>
                            </div>

                            {{-- Card footer --}}
                            <div class="border-t border-gray-100 px-4 py-2 dark:border-gray-800">
                                <p class="text-xs text-gray-400 dark:text-gray-500">
                                    {{ number_format((float) $order->final_amount, 2) }} €
                                    &middot;
                                    {{ $order->created_at->diffForHumans() }}
                                </p>
                            </div>

                            {{-- Actions --}}
                            <div class="flex items-center gap-2 border-t border-gray-100 px-4 py-3 dark:border-gray-800">
                                <x-filament::button class="flex-1" wire:click="markReady({{ $order->id }})" wire:loading.attr="disabled" wire:target="markReady({{ $order->id }})" size="sm" color="warning" icon="heroicon-o-clock">
                                    {{ __('admin/order.actions.ready') }}
                                </x-filament::button>

                                <x-filament::button tag="a" href="{{ \App\Filament\Pages\IncomingOrdersPage::getViewOrderUrl($order) }}" size="sm" color="gray" icon="heroicon-o-eye" outlined>
                                    {{ __('admin/order.actions.view') }}
                                </x-filament::button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
