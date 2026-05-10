<?php

namespace App\Filament\Resources\Orders\Tables;

use App\Enums\OrderType;
use App\Enums\PaymentMethods;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use App\States\Order\Ready;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrdersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number')
                    ->label(__('admin/order.table.order_number'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('customer.name')
                    ->label(__('admin/order.table.customer'))
                    ->searchable()
                    ->sortable()
                    ->placeholder('—'),

                TextColumn::make('status')
                    ->label(__('admin/order.table.status'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => __('admin/order.status.' . $state->getValue()))
                    ->color(fn ($state) => $state->color()),

                TextColumn::make('order_type')
                    ->label(__('admin/order.table.order_type'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => __('admin/order.order_type.' . $state->value))
                    ->color(fn ($state) => match ($state) {
                        OrderType::ONLINE => 'info',
                        OrderType::DINE_IN => 'warning',
                    }),

                TextColumn::make('payment_method')
                    ->label(__('admin/order.table.payment_method'))
                    ->badge()
                    ->formatStateUsing(fn ($state) => __('admin/order.payment_method.' . $state->value))
                    ->color('gray'),

                TextColumn::make('items_count')
                    ->label(__('admin/order.table.items_count'))
                    ->counts('items')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('final_amount')
                    ->label(__('admin/order.table.final_amount'))
                    ->money('EUR', locale: 'el')
                    ->sortable(),

                TextColumn::make('created_at')
                    ->label(__('admin/order.table.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin/order.filters.status'))
                    ->options([
                        Pending::$name => __('admin/order.status.pending'),
                        Processing::$name => __('admin/order.status.processing'),
                        Ready::$name => __('admin/order.status.ready'),
                        Completed::$name => __('admin/order.status.completed'),
                        Cancelled::$name => __('admin/order.status.cancelled'),
                    ])
                    ->query(fn (Builder $query, array $data) => $data['value']
                        ? $query->whereState('status', $data['value'])
                        : $query),

                SelectFilter::make('order_type')
                    ->label(__('admin/order.filters.order_type'))
                    ->options([
                        OrderType::ONLINE->value => __('admin/order.order_type.online'),
                        OrderType::DINE_IN->value => __('admin/order.order_type.dine_in'),
                    ]),

                SelectFilter::make('payment_method')
                    ->label(__('admin/order.filters.payment_method'))
                    ->options([
                        PaymentMethods::CASH->value => __('admin/order.payment_method.cash'),
                        PaymentMethods::CREDIT_CARD->value => __('admin/order.payment_method.credit_card'),
                    ]),

                Filter::make('date')
                    ->label(__('admin/order.filters.date'))
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('date_from')
                            ->label(__('admin/order.filters.date_from'))
                            ->native(false),
                        \Filament\Forms\Components\DatePicker::make('date_to')
                            ->label(__('admin/order.filters.date_to'))
                            ->native(false),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['date_from'], fn ($q) => $q->whereDate('created_at', '>=', $data['date_from']))
                            ->when($data['date_to'], fn ($q) => $q->whereDate('created_at', '<=', $data['date_to']));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
