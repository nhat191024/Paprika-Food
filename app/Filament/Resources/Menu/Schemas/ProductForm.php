<?php

namespace App\Filament\Resources\Menu\Schemas;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;

use App\States\Product\Active;
use App\States\Product\Inactive;
use App\States\Product\OutOfStock;

use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;

use Filament\Schemas\Schema;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;

use Illuminate\Support\Str;

use RalphJSmit\Filament\Upload\Filament\Forms\Components\AdvancedFileUpload;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->components([
                Grid::make(1)
                    ->columnSpan(2)
                    ->schema([
                        Section::make(__('admin/menu.product.form.sections.general'))
                            ->schema([
                                Grid::make(2)
                                    ->schema([
                                        TextInput::make('name.en')
                                            ->label(__('admin/menu.product.form.fields.name_en'))
                                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'en') ?? ''))
                                            ->live(onBlur: true)
                                            ->afterStateUpdated(fn($set, ?string $state) => $set('slug', Str::slug($state ?? '')))
                                            ->required()
                                            ->maxLength(255),

                                        TextInput::make('name.el')
                                            ->label(__('admin/menu.product.form.fields.name_el'))
                                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'el') ?? ''))
                                            ->maxLength(255),

                                        TextInput::make('slug')
                                            ->label(__('admin/menu.product.form.fields.slug'))
                                            ->required()
                                            ->unique(table: 'products', column: 'slug', ignoreRecord: true)
                                            ->maxLength(255)
                                            ->columnSpanFull(),

                                        Textarea::make('description.en')
                                            ->label(__('admin/menu.product.form.fields.description_en'))
                                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('description', 'en') ?? ''))
                                            ->rows(4),

                                        Textarea::make('description.el')
                                            ->label(__('admin/menu.product.form.fields.description_el'))
                                            ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('description', 'el') ?? ''))
                                            ->rows(4),
                                    ]),
                            ]),

                        Section::make(__('admin/menu.product.form.sections.variants'))
                            ->collapsible()
                            ->collapsed()
                            ->schema([
                                Repeater::make('variants')
                                    ->hiddenLabel()
                                    ->relationship()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name.en')
                                                    ->label(__('admin/menu.product.form.fields.variant_name_en'))
                                                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'en') ?? ''))
                                                    ->required()
                                                    ->maxLength(255),

                                                TextInput::make('name.el')
                                                    ->label(__('admin/menu.product.form.fields.variant_name_el'))
                                                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'el') ?? ''))
                                                    ->maxLength(255),

                                                TextInput::make('price_adjustment')
                                                    ->label(__('admin/menu.product.form.fields.price_adjustment'))
                                                    ->numeric()
                                                    ->prefix('€')
                                                    ->default(0),

                                                TextInput::make('sort_order')
                                                    ->label(__('admin/menu.product.form.fields.variant_sort_order'))
                                                    ->numeric()
                                                    ->default(0),

                                                Toggle::make('is_active')
                                                    ->label(__('admin/menu.product.form.fields.variant_is_active'))
                                                    ->default(true)
                                                    ->columnSpanFull(),
                                            ]),
                                    ])
                                    ->addActionLabel(__('admin/menu.product.form.sections.add_variants'))
                                    ->columnSpanFull(),
                            ]),

                        Section::make(__('admin/menu.product.form.sections.combo_groups'))
                            ->collapsible()
                            ->collapsed(fn($record) => $record === null || ! $record->is_combo)
                            ->visible(fn(Get $get) => (bool) $get('is_combo'))
                            ->schema([
                                Repeater::make('comboGroups')
                                    ->hiddenLabel()
                                    ->relationship()
                                    ->schema([
                                        Grid::make(2)
                                            ->schema([
                                                TextInput::make('name.en')
                                                    ->label(__('admin/menu.product.form.fields.combo_group_name_en'))
                                                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'en') ?? ''))
                                                    ->required()
                                                    ->maxLength(255),

                                                TextInput::make('name.el')
                                                    ->label(__('admin/menu.product.form.fields.combo_group_name_el'))
                                                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->getTranslation('name', 'el') ?? ''))
                                                    ->maxLength(255),

                                                TextInput::make('min_select')
                                                    ->label(__('admin/menu.product.form.fields.min_select'))
                                                    ->numeric()
                                                    ->minValue(0)
                                                    ->default(1)
                                                    ->required(),

                                                TextInput::make('max_select')
                                                    ->label(__('admin/menu.product.form.fields.max_select'))
                                                    ->numeric()
                                                    ->minValue(1)
                                                    ->default(1)
                                                    ->required(),

                                                Toggle::make('is_required')
                                                    ->label(__('admin/menu.product.form.fields.is_required'))
                                                    ->default(true)
                                                    ->columnSpanFull(),
                                            ]),

                                        Repeater::make('items')
                                            ->label(__('admin/menu.product.form.fields.items'))
                                            ->relationship()
                                            ->schema([
                                                Grid::make(2)
                                                    ->schema([
                                                        Select::make('item_type')
                                                            ->label(__('admin/menu.product.form.fields.item_type'))
                                                            ->options([
                                                                'product' => __('admin/menu.product.form.fields.item_type_product'),
                                                                'variant' => __('admin/menu.product.form.fields.item_type_variant'),
                                                            ])
                                                            ->default('product')
                                                            ->live()
                                                            ->dehydrated(false)
                                                            ->afterStateHydrated(fn($component, $record) => $component->state(
                                                                $record?->product_variant_id ? 'variant' : 'product'
                                                            )),

                                                        TextInput::make('extra_price')
                                                            ->label(__('admin/menu.product.form.fields.extra_price'))
                                                            ->numeric()
                                                            ->prefix('€')
                                                            ->default(0)
                                                            ->minValue(0),

                                                        Select::make('product_id')
                                                            ->label(__('admin/menu.product.form.fields.item_product_id'))
                                                            ->options(
                                                                fn() => Product::query()
                                                                    ->orderBy('id', 'desc')
                                                                    ->get()
                                                                    ->mapWithKeys(fn($p) => [$p->id => $p->getTranslation('name', app()->getLocale())])
                                                            )
                                                            ->searchable()
                                                            ->visible(fn(Get $get) => $get('item_type') === 'product')
                                                            ->required(fn(Get $get) => $get('item_type') === 'product'),

                                                        Select::make('product_variant_id')
                                                            ->label(__('admin/menu.product.form.fields.item_variant_id'))
                                                            ->options(
                                                                fn() => ProductVariant::query()
                                                                    ->with('product')
                                                                    ->where('is_active', true)
                                                                    ->get()
                                                                    ->mapWithKeys(fn($v) => [
                                                                        $v->id => $v->product->getTranslation('name', app()->getLocale())
                                                                            . ' — ' . $v->getTranslation('name', app()->getLocale()),
                                                                    ])
                                                            )
                                                            ->searchable()
                                                            ->visible(fn(Get $get) => $get('item_type') === 'variant')
                                                            ->required(fn(Get $get) => $get('item_type') === 'variant'),
                                                    ]),
                                            ])
                                            ->addActionLabel(__('admin/menu.product.form.fields.add_item'))
                                            ->columnSpanFull(),
                                    ])
                                    ->addActionLabel(__('admin/menu.product.form.sections.add_combo_groups'))
                                    ->columnSpanFull(),
                            ]),
                    ]),

                Grid::make(1)
                    ->columnSpan(1)
                    ->schema([
                        Section::make(__('admin/menu.product.form.sections.pricing'))
                            ->schema([
                                Select::make('category_id')
                                    ->label(__('admin/menu.product.form.fields.category_id'))
                                    ->options(fn() => Category::all()->mapWithKeys(
                                        fn($c) => [$c->id => $c->getTranslation('name', app()->getLocale())]
                                    ))
                                    ->searchable()
                                    ->required(),

                                TextInput::make('price')
                                    ->label(__('admin/menu.product.form.fields.price'))
                                    ->numeric()
                                    ->prefix('€')
                                    ->minValue(0)
                                    ->required(),

                                Select::make('status')
                                    ->label(__('admin/menu.product.form.fields.status'))
                                    ->options([
                                        Active::$name => __('admin/menu.product.status.active'),
                                        Inactive::$name => __('admin/menu.product.status.inactive'),
                                        OutOfStock::$name => __('admin/menu.product.status.out_of_stock'),
                                    ])
                                    ->afterStateHydrated(fn($component, $record) => $component->state($record?->status?->getValue() ?? Active::$name))
                                    ->required(),

                                Toggle::make('is_combo')
                                    ->label(__('admin/menu.product.form.fields.is_combo'))
                                    ->default(false)
                                    ->live(),
                            ]),

                        Section::make(__('admin/menu.product.form.sections.thumbnail'))
                            ->schema([
                                AdvancedFileUpload::make('thumbnail')
                                    ->label(__('admin/menu.product.form.fields.thumbnail'))
                                    ->image()
                                    ->editable()
                                    ->spatieMediaLibrary(collection: 'thumbnail')
                                    ->columnSpanFull(),
                            ]),
                    ]),
            ]);
    }
}
