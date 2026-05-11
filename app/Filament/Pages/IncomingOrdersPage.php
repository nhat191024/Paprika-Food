<?php

namespace App\Filament\Pages;

use App\Enums\FilamentNavigationGroup;
use App\Filament\Resources\Orders\OrderResource;
use App\Models\Order;
use App\States\Order\Pending;
use App\States\Order\Processing;
use App\States\Order\Ready;
use BackedEnum;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class IncomingOrdersPage extends Page
{
    protected string $view = 'filament.pages.incoming-orders-page';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBellAlert;

    protected static string|UnitEnum|null $navigationGroup = FilamentNavigationGroup::ORDERS;

    protected static ?int $navigationSort = 2;

    public int $pendingCount = 0;

    public function mount(): void
    {
        $this->pendingCount = Order::whereState('status', Pending::class)->count('id');
    }

    public static function getNavigationLabel(): string
    {
        return __('admin/sidebar.navigation.labels.new_orders');
    }

    public function getTitle(): string
    {
        return __('admin/sidebar.navigation.labels.new_orders');
    }

    protected function getViewData(): array
    {
        return [
            'pendingOrders' => Order::whereState('status', Pending::class)
                ->with('customer')
                ->latest()
                ->get(),
            'processingOrders' => Order::whereState('status', Processing::class)
                ->with('customer')
                ->latest()
                ->get(),
        ];
    }

    public function pollOrders(): void
    {
        $newCount = Order::whereState('status', Pending::class)->count('id');

        if ($newCount > $this->pendingCount) {
            $this->dispatch('play-notification-sound');
        }

        $this->pendingCount = $newCount;
    }

    public function confirmOrder(int $id): void
    {
        $order = Order::findOrFail($id);

        if (! ($order->status instanceof Pending)) {
            Notification::make()
                ->title(__('admin/order.status.processing'))
                ->warning()
                ->send();

            return;
        }

        $order->status->transitionTo(Processing::class);

        Notification::make()
            ->title($order->order_number . ' — ' . __('admin/order.actions.confirm'))
            ->success()
            ->send();
    }

    public function markReady(int $id): void
    {
        $order = Order::findOrFail($id);

        if (! ($order->status instanceof Processing)) {
            return;
        }

        $order->status->transitionTo(Ready::class);

        Notification::make()
            ->title($order->order_number . ' — ' . __('admin/order.actions.ready'))
            ->success()
            ->send();
    }

    public static function getViewOrderUrl(Order $order): string
    {
        return OrderResource::getUrl('view', ['record' => $order]);
    }
}
