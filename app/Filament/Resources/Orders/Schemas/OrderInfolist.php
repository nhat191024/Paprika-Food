<?php

namespace App\Filament\Resources\Orders\Schemas;

use App\Enums\OrderType;
use Filament\Infolists\Components\RepeatableEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrderInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('admin/order.infolist.sections.order_info'))
                    ->columnSpan(2)
                    ->columns(2)
                    ->schema([
                        TextEntry::make('order_number')
                            ->label(__('admin/order.infolist.fields.order_number'))
                            ->copyable()
                            ->weight('bold'),

                        TextEntry::make('status')
                            ->label(__('admin/order.infolist.fields.status'))
                            ->badge()
                            ->formatStateUsing(fn ($state) => __('admin/order.status.' . $state->getValue()))
                            ->color(fn ($state) => $state->color()),

                        TextEntry::make('order_type')
                            ->label(__('admin/order.infolist.fields.order_type'))
                            ->badge()
                            ->formatStateUsing(fn ($state) => __('admin/order.order_type.' . $state->value))
                            ->color(fn ($state) => match ($state) {
                                OrderType::ONLINE => 'info',
                                OrderType::DINE_IN => 'warning',
                            }),

                        TextEntry::make('payment_method')
                            ->label(__('admin/order.infolist.fields.payment_method'))
                            ->badge()
                            ->formatStateUsing(fn ($state) => __('admin/order.payment_method.' . $state->value))
                            ->color('gray'),

                        TextEntry::make('created_at')
                            ->label(__('admin/order.infolist.fields.created_at'))
                            ->dateTime('d/m/Y H:i')
                            ->columnSpanFull(),
                    ]),

                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('admin/order.infolist.sections.customer_info'))
                            ->schema([
                                TextEntry::make('customer.name')
                                    ->label(__('admin/order.infolist.fields.customer_name'))
                                    ->placeholder('—'),

                                TextEntry::make('customer.email')
                                    ->label(__('admin/order.infolist.fields.customer_email'))
                                    ->placeholder('—'),
                            ]),

                        Section::make(__('admin/order.infolist.sections.delivery_info'))
                            ->visible(fn ($record) => $record->order_type === OrderType::ONLINE)
                            ->schema([
                                TextEntry::make('delivery_recipient_name')
                                    ->label(__('admin/order.infolist.fields.recipient_name'))
                                    ->placeholder('—'),

                                TextEntry::make('delivery_phone')
                                    ->label(__('admin/order.infolist.fields.delivery_phone'))
                                    ->placeholder('—'),

                                TextEntry::make('delivery_address_detail')
                                    ->label(__('admin/order.infolist.fields.delivery_address'))
                                    ->placeholder('—')
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('admin/order.infolist.sections.payment_info'))
                            ->schema([
                                TextEntry::make('voucher_code')
                                    ->label(__('admin/order.infolist.fields.voucher_code'))
                                    ->placeholder('—')
                                    ->badge()
                                    ->color('success')
                                    ->icon('heroicon-o-ticket')
                                    ->columnSpanFull(),

                                TextEntry::make('total_amount')
                                    ->label(__('admin/order.infolist.fields.total_amount'))
                                    ->money('EUR', locale: 'el'),

                                TextEntry::make('discount_amount')
                                    ->label(__('admin/order.infolist.fields.discount_amount'))
                                    ->money('EUR', locale: 'el'),

                                TextEntry::make('final_amount')
                                    ->label(__('admin/order.infolist.fields.final_amount'))
                                    ->money('EUR', locale: 'el')
                                    ->weight('bold')
                                    ->size('lg'),
                            ]),
                    ]),

                Section::make(__('admin/order.infolist.sections.items'))
                    ->columnSpanFull()
                    ->schema([
                        RepeatableEntry::make('items')
                            ->hiddenLabel()
                            ->columns(4)
                            ->schema([
                                TextEntry::make('product.name')
                                    ->label(__('admin/order.infolist.fields.product_name'))
                                    ->state(fn ($record) => $record->product->getTranslation('name', app()->getLocale())),

                                TextEntry::make('quantity')
                                    ->label(__('admin/order.infolist.fields.quantity')),

                                TextEntry::make('price')
                                    ->label(__('admin/order.infolist.fields.price'))
                                    ->money('EUR', locale: 'el'),

                                TextEntry::make('subtotal')
                                    ->label(__('admin/order.infolist.fields.subtotal'))
                                    ->state(fn ($record) => $record->price * $record->quantity)
                                    ->money('EUR', locale: 'el')
                                    ->weight('bold'),

                                RepeatableEntry::make('selections')
                                    ->label(__('admin/order.infolist.sections.selections'))
                                    ->columnSpanFull()
                                    ->columns(2)
                                    ->schema([
                                        TextEntry::make('product.name')
                                            ->label(__('admin/order.infolist.fields.selection_product'))
                                            ->state(fn ($record) => $record->product->getTranslation('name', app()->getLocale())),

                                        TextEntry::make('extra_price')
                                            ->label(__('admin/order.infolist.fields.extra_price'))
                                            ->money('EUR', locale: 'el'),
                                    ])
                                    ->hidden(fn ($record) => $record->selections->isEmpty()),
                            ]),
                    ]),
            ]);
    }
}
