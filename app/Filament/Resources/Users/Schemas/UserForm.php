<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use RalphJSmit\Filament\Upload\Filament\Forms\Components\AdvancedFileUpload;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin/customer.form.sections.account_information'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('name')
                                    ->label(__('admin/customer.form.fields.name'))
                                    ->required()
                                    ->maxLength(255),
                                TextInput::make('email')
                                    ->label(__('admin/customer.form.fields.email'))
                                    ->email()
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(255),
                                TextInput::make('password')
                                    ->label(__('admin/customer.form.fields.password'))
                                    ->password()
                                    ->revealable()
                                    ->required(fn(string $operation): bool => $operation === 'create')
                                    ->dehydrateStateUsing(fn(?string $state): ?string => filled($state) ? bcrypt($state) : null)
                                    ->dehydrated(fn(?string $state): bool => filled($state))
                                    ->maxLength(255),
                                Select::make('roles')
                                    ->label(__('admin/customer.form.fields.roles'))
                                    ->multiple()
                                    ->relationship('roles', 'name')
                                    ->preload(),
                            ]),
                    ]),
                Section::make(__('admin/customer.form.sections.avatar'))
                    ->columnSpanFull()
                    ->schema([
                        AdvancedFileUpload::make('avatar')
                            ->label(__('admin/customer.form.fields.avatar'))
                            ->image()
                            ->editable()
                            ->maxFiles(1)
                            ->spatieMediaLibrary(collection: 'avatar')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
