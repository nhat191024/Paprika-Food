<?php

namespace App\Filament\Resources\Orders\Pages;

use App\Filament\Resources\Orders\OrderResource;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use App\States\Order\Ready;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('confirm')
                ->label(__('admin/order.actions.confirm'))
                ->icon('heroicon-o-check-circle')
                ->color('info')
                ->visible(fn () => $this->record->status instanceof Pending)
                ->action(function () {
                    $this->record->status->transitionTo(Processing::class);
                    $this->record->refresh();
                    $this->fillForm();
                }),

            Action::make('ready')
                ->label(__('admin/order.actions.ready'))
                ->icon('heroicon-o-clock')
                ->color('warning')
                ->visible(fn () => $this->record->status instanceof Processing)
                ->action(function () {
                    $this->record->status->transitionTo(Ready::class);
                    $this->record->refresh();
                    $this->fillForm();
                }),

            Action::make('complete')
                ->label(__('admin/order.actions.complete'))
                ->icon('heroicon-o-check-badge')
                ->color('success')
                ->visible(fn () => $this->record->status instanceof Ready)
                ->action(function () {
                    $this->record->status->transitionTo(Completed::class);
                    $this->record->refresh();
                    $this->fillForm();
                }),

            Action::make('cancel')
                ->label(__('admin/order.actions.cancel'))
                ->icon('heroicon-o-x-circle')
                ->color('danger')
                ->requiresConfirmation()
                ->modalHeading(__('admin/order.actions.cancel'))
                ->modalDescription(__('admin/order.actions.cancel_confirm'))
                ->modalSubmitActionLabel(__('admin/order.actions.cancel_confirm_button'))
                ->visible(fn () => ! ($this->record->status instanceof Completed) && ! ($this->record->status instanceof Cancelled))
                ->action(function () {
                    $this->record->status->transitionTo(Cancelled::class);
                    $this->record->refresh();
                    $this->fillForm();
                }),
        ];
    }
}
