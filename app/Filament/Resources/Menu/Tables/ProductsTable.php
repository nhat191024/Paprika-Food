<?php

namespace App\Filament\Resources\Menu\Tables;

use App\States\Product\Active;
use App\States\Product\Inactive;
use App\States\Product\OutOfStock;
use Filament\Actions\Action;
use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ProductsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label(__('admin/menu.product.table.thumbnail'))
                    ->state(fn($record) => $record->getFirstMediaUrl('thumbnail', 'thumbnail_webp') ?: $record->getFirstMediaUrl('thumbnail'))
                    ->square()
                    ->defaultImageUrl(asset('images/placeholder.png')),

                TextColumn::make('name')
                    ->label(__('admin/menu.product.table.name'))
                    ->state(fn($record) => $record->getTranslation('name', app()->getLocale()))
                    ->searchable(query: fn($query, string $value) => $query->whereJsonContainsLocale('name', app()->getLocale(), $value))
                    ->sortable()
                    ->description(fn($record) => $record->slug),

                TextColumn::make('category.name')
                    ->label(__('admin/menu.product.table.category'))
                    ->state(fn($record) => $record->category?->getTranslation('name', app()->getLocale()))
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                TextColumn::make('price')
                    ->label(__('admin/menu.product.table.price'))
                    ->money('EUR', locale: 'el')
                    ->sortable(),

                IconColumn::make('is_combo')
                    ->label(__('admin/menu.product.table.is_combo'))
                    ->boolean(),

                TextColumn::make('status')
                    ->label(__('admin/menu.product.table.status'))
                    ->badge()
                    ->state(fn($record) => match ($record->status::$name) {
                        Active::$name => __('admin/menu.product.status.active'),
                        Inactive::$name => __('admin/menu.product.status.inactive'),
                        OutOfStock::$name => __('admin/menu.product.status.out_of_stock'),
                        default => $record->status::$name,
                    })
                    ->color(fn($record) => $record->status->color()),

                TextColumn::make('created_at')
                    ->label(__('admin/menu.product.table.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category_id')
                    ->label(__('admin/menu.product.filters.category'))
                    ->relationship('category', 'name')
                    ->getOptionLabelFromRecordUsing(fn($record) => $record->getTranslation('name', app()->getLocale()))
                    ->preload()
                    ->searchable(),

                SelectFilter::make('status')
                    ->label(__('admin/menu.product.filters.status'))
                    ->options([
                        Active::$name => __('admin/menu.product.status.active'),
                        Inactive::$name => __('admin/menu.product.status.inactive'),
                        OutOfStock::$name => __('admin/menu.product.status.out_of_stock'),
                    ]),

                Filter::make('is_combo')
                    ->label(__('admin/menu.product.filters.is_combo'))
                    ->query(fn(Builder $query) => $query->where('is_combo', true)),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('change_status')
                        ->label(__('admin/menu.product.bulk_actions.change_status'))
                        ->icon('heroicon-o-arrow-path')
                        ->schema([
                            Select::make('status')
                                ->label(__('admin/menu.product.bulk_actions.status'))
                                ->options([
                                    Active::$name    => __('admin/menu.product.status.active'),
                                    Inactive::$name  => __('admin/menu.product.status.inactive'),
                                    OutOfStock::$name => __('admin/menu.product.status.out_of_stock'),
                                ])
                                ->required(),
                        ])
                        ->modalHeading(__('admin/menu.product.bulk_actions.change_status_modal_heading'))
                        ->action(fn(Collection $records, array $data) => $records->each(
                            fn($record) => $record->update(['status' => $data['status']])
                        ))
                        ->deselectRecordsAfterCompletion()
                        ->successNotificationTitle(__('admin/menu.product.notifications.change_status_success'))
                        ->failureNotificationTitle(__('admin/menu.product.notifications.change_status_failure')),

                    // DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
