<?php

namespace App\Filament\Resources\Content\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class BannersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image')
                    ->label(__('admin/banner.table.image'))
                    ->state(fn ($record) => $record->getFirstMediaUrl('image', 'webp') ?: $record->getFirstMediaUrl('image'))
                    ->width(120)
                    ->height(60)
                    ->defaultImageUrl(asset('images/placeholder.png')),

                TextColumn::make('title')
                    ->label(__('admin/banner.table.title'))
                    ->searchable()
                    ->sortable(),

                TextColumn::make('link')
                    ->label(__('admin/banner.table.link'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('sort_order')
                    ->label(__('admin/banner.table.sort_order'))
                    ->sortable(),

                IconColumn::make('status')
                    ->label(__('admin/banner.table.status'))
                    ->boolean(),

                TextColumn::make('created_at')
                    ->label(__('admin/banner.table.created_at'))
                    ->dateTime('d/m/Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('sort_order')
            ->reorderable('sort_order');
    }
}
