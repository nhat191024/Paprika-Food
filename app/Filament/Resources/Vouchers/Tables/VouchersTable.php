<?php

namespace App\Filament\Resources\Vouchers\Tables;

use App\States\Voucher\Active;
use App\States\Voucher\Expired;
use App\States\Voucher\Inactive;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class VouchersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('code')
                    ->label(__('admin/voucher.table.code'))
                    ->searchable()
                    ->sortable()
                    ->copyable()
                    ->weight('bold'),

                TextColumn::make('discount_type')
                    ->label(__('admin/voucher.table.discount_type'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __('admin/voucher.discount_types.' . $state))
                    ->color(fn(string $state): string => $state === 'percent' ? 'info' : 'primary'),

                TextColumn::make('discount_value')
                    ->label(__('admin/voucher.table.discount_value'))
                    ->state(fn($record): string => $record->discount_type === 'percent'
                        ? $record->discount_value . '%'
                        : number_format($record->discount_value) . ' VND'),

                TextColumn::make('min_order_amount')
                    ->label(__('admin/voucher.table.min_order_amount'))
                    ->state(fn($record): string => number_format($record->min_order_amount) . ' VND')
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('start_date')
                    ->label(__('admin/voucher.table.start_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                TextColumn::make('end_date')
                    ->label(__('admin/voucher.table.end_date'))
                    ->date('d/m/Y')
                    ->sortable(),

                IconColumn::make('is_unlimited')
                    ->label(__('admin/voucher.table.is_unlimited'))
                    ->boolean(),

                TextColumn::make('usage')
                    ->label(__('admin/voucher.table.usage'))
                    ->state(fn($record): string => $record->is_unlimited
                        ? $record->used_count . ' / ∞'
                        : $record->used_count . ' / ' . ($record->usage_limit ?? '∞')),

                TextColumn::make('status')
                    ->label(__('admin/voucher.table.status'))
                    ->badge()
                    ->formatStateUsing(fn(string $state): string => __('admin/voucher.states.' . $state))
                    ->color(fn($record): string => $record->status->color()),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label(__('admin/voucher.filters.status'))
                    ->options([
                        Active::$name => __('admin/voucher.states.active'),
                        Inactive::$name => __('admin/voucher.states.inactive'),
                        Expired::$name => __('admin/voucher.states.expired'),
                    ]),

                SelectFilter::make('discount_type')
                    ->label(__('admin/voucher.filters.discount_type'))
                    ->options([
                        'fixed' => __('admin/voucher.discount_types.fixed'),
                        'percent' => __('admin/voucher.discount_types.percent'),
                    ]),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
