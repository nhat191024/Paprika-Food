<?php

namespace App\Filament\Resources\Vouchers\Schemas;

use App\States\Voucher\Active;
use App\States\Voucher\Inactive;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;

class VoucherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin/voucher.form.sections.general'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                TextInput::make('code')
                                    ->label(__('admin/voucher.form.fields.code'))
                                    ->required()
                                    ->unique(ignoreRecord: true)
                                    ->maxLength(50)
                                    ->placeholder('SUMMER2025'),

                                Select::make('status')
                                    ->label(__('admin/voucher.form.fields.status'))
                                    ->options([
                                        Active::$name => __('admin/voucher.states.active'),
                                        Inactive::$name => __('admin/voucher.states.inactive'),
                                    ])
                                    ->required()
                                    ->default(Active::$name),
                            ]),
                    ]),

                Section::make(__('admin/voucher.form.sections.discount'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                Select::make('discount_type')
                                    ->label(__('admin/voucher.form.fields.discount_type'))
                                    ->options([
                                        'fixed' => __('admin/voucher.discount_types.fixed'),
                                        'percent' => __('admin/voucher.discount_types.percent'),
                                    ])
                                    ->required()
                                    ->live()
                                    ->default('fixed'),

                                TextInput::make('discount_value')
                                    ->label(__('admin/voucher.form.fields.discount_value'))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->suffix(fn(Get $get): string => $get('discount_type') === 'percent' ? '%' : 'EUR'),

                                TextInput::make('min_order_amount')
                                    ->label(__('admin/voucher.form.fields.min_order_amount'))
                                    ->required()
                                    ->numeric()
                                    ->minValue(0)
                                    ->default(0)
                                    ->suffix('EUR'),

                                TextInput::make('max_discount')
                                    ->label(__('admin/voucher.form.fields.max_discount'))
                                    ->numeric()
                                    ->minValue(0)
                                    ->nullable()
                                    ->suffix('EUR')
                                    ->visible(fn(Get $get): bool => $get('discount_type') === 'percent'),
                            ]),
                    ]),

                Section::make(__('admin/voucher.form.sections.validity'))
                    ->columnSpanFull()
                    ->schema([
                        Grid::make(2)
                            ->schema([
                                DatePicker::make('start_date')
                                    ->label(__('admin/voucher.form.fields.start_date'))
                                    ->required()
                                    ->default(now()),

                                DatePicker::make('end_date')
                                    ->label(__('admin/voucher.form.fields.end_date'))
                                    ->required()
                                    ->after('start_date'),

                                Toggle::make('is_unlimited')
                                    ->label(__('admin/voucher.form.fields.is_unlimited'))
                                    ->live()
                                    ->default(false)
                                    ->columnSpanFull(),

                                TextInput::make('usage_limit')
                                    ->label(__('admin/voucher.form.fields.usage_limit'))
                                    ->numeric()
                                    ->minValue(1)
                                    ->nullable()
                                    ->visible(fn(Get $get): bool => ! $get('is_unlimited')),
                            ]),
                    ]),
            ]);
    }
}
