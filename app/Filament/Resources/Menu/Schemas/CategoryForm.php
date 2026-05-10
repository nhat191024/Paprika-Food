<?php

namespace App\Filament\Resources\Menu\Schemas;

use Filament\Schemas\Schema;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;

use Illuminate\Support\Str;

class CategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('admin/menu.category.form.sections.general'))
                    ->columnSpan(2)
                    ->schema([
                        Grid::make(2)
                            ->schema([
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
                            ]),
                    ]),
            ]);
    }
}
