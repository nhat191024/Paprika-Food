<?php

namespace App\Filament\Resources\Menu\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ForceDeleteBulkAction;
use Filament\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class CategoriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([

                TextColumn::make('order')
                    ->label(__('admin/menu.category.table.order'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('admin/menu.category.table.name'))
                    ->state(fn ($record) => $record->getTranslation('name', app()->getLocale()))
                    ->searchable(query: fn ($query, string $value) => $query->whereJsonContainsLocale('name', app()->getLocale(), $value))
                    ->sortable(),

                TextColumn::make('slug')
                    ->label(__('admin/menu.category.table.slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('children_count')
                    ->label(__('admin/menu.category.table.children_count'))
                    ->counts('children')
                    ->badge()
                    ->color('info'),

                TextColumn::make('products_count')
                    ->label(__('admin/menu.category.table.products_count'))
                    ->counts('products')
                    ->badge()
                    ->color('gray'),

                TextColumn::make('created_at')
                    ->label(__('admin/menu.category.table.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                TrashedFilter::make()
                    ->label(__('admin/menu.category.filters.trashed')),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                ]),
            ])
            ->defaultSort('order')
            ->reorderable('order');
    }
}
