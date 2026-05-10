<?php

namespace App\Filament\Resources\Content\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use RalphJSmit\Filament\Upload\Filament\Forms\Components\AdvancedFileUpload;

class BannerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Section::make(__('admin/banner.form.sections.general'))
                    ->columnSpan(2)
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('title')
                                    ->label(__('admin/banner.form.fields.title'))
                                    ->maxLength(255),

                                TextInput::make('link')
                                    ->label(__('admin/banner.form.fields.link'))
                                    ->url()
                                    ->maxLength(255),
                            ]),
                    ]),

                Section::make(__('admin/banner.form.sections.settings'))
                    ->columnSpan(1)
                    ->schema([
                        Toggle::make('status')
                            ->label(__('admin/banner.form.fields.status'))
                            ->default(true),
                    ]),

                Section::make(__('admin/banner.form.sections.image'))
                    ->columnSpanFull()
                    ->schema([
                        AdvancedFileUpload::make('image')
                            ->label(__('admin/banner.form.fields.image'))
                            ->image()
                            ->editable()
                            ->spatieMediaLibrary(collection: 'image')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
