<?php

namespace App\Filament\Resources\Menu;

use Illuminate\Database\Eloquent\Builder;
use App\Enums\FilamentNavigationGroup;
use App\Filament\Resources\Menu\Pages\CreateProduct;
use App\Filament\Resources\Menu\Pages\EditProduct;
use App\Filament\Resources\Menu\Pages\ListProducts;
use App\Filament\Resources\Menu\Schemas\ProductForm;
use App\Filament\Resources\Menu\Tables\ProductsTable;
use App\Models\Product;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedShoppingBag;

    protected static string|UnitEnum|null $navigationGroup = FilamentNavigationGroup::MENU;

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('admin/sidebar.navigation.labels.products');
    }

    public static function getModelLabel(): string
    {
        return __('admin/menu.product.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin/menu.product.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return ProductForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ProductsTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->with('thumbnail', 'category');
    }

    public static function getPages(): array
    {
        return [
            'index' => ListProducts::route('/'),
            'create' => CreateProduct::route('/create'),
            'edit' => EditProduct::route('/{record}/edit'),
        ];
    }
}
