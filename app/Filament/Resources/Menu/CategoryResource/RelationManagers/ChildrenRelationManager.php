<?php

namespace App\Filament\Resources\Menu\CategoryResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ChildrenRelationManager extends RelationManager
{
    protected static string $relationship = 'children';

    public static function getTitle(Model $ownerRecord, string $pageClass): string
    {
        return __('admin/menu.category.relation.children.title');
    }

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                TextInput::make('name.en')
                    ->label(__('admin/menu.category.form.fields.name_en'))
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'en') ?? ''))
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                    ->required()
                    ->maxLength(255),

                TextInput::make('name.el')
                    ->label(__('admin/menu.category.form.fields.name_el'))
                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'el') ?? ''))
                    ->maxLength(255),

                TextInput::make('slug')
                    ->label(__('admin/menu.category.form.fields.slug'))
                    ->required()
                    ->unique(table: 'categories', column: 'slug', ignoreRecord: true)
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('order')
                    ->label(__('admin/menu.category.table.order'))
                    ->sortable(),

                TextColumn::make('name')
                    ->label(__('admin/menu.category.table.name'))
                    ->state(fn($record) => $record->getTranslation('name', app()->getLocale()))
                    ->searchable(query: fn($query, string $value) => $query->whereJsonContainsLocale('name', app()->getLocale(), $value)),

                TextColumn::make('slug')
                    ->label(__('admin/menu.category.table.slug'))
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('products_count')
                    ->label(__('admin/menu.category.table.products_count'))
                    ->counts('products')
                    ->badge()
                    ->color('gray'),
            ])
            ->headerActions([
                CreateAction::make(),
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('order')
            ->reorderable('order');
    }
}
