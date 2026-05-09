<?php

namespace App\Filament\Resources\Menu;

use App\Enums\FilamentNavigationGroup;
use App\Filament\Resources\Menu\CategoryResource\RelationManagers\ChildrenRelationManager;
use App\Filament\Resources\Menu\Pages\CreateCategory;
use App\Filament\Resources\Menu\Pages\EditCategory;
use App\Filament\Resources\Menu\Pages\ListCategories;
use App\Filament\Resources\Menu\Schemas\CategoryForm;
use App\Filament\Resources\Menu\Tables\CategoriesTable;
use App\Models\Category;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use UnitEnum;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedTag;

    protected static string|UnitEnum|null $navigationGroup = FilamentNavigationGroup::MENU;

    protected static ?int $navigationSort = 1;

    public static function getNavigationLabel(): string
    {
        return __('admin/sidebar.navigation.labels.categories');
    }

    public static function getModelLabel(): string
    {
        return __('admin/menu.category.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin/menu.category.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return CategoryForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return CategoriesTable::configure($table);
    }

    public static function getRelations(): array
    {
        return [
            ChildrenRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListCategories::route('/'),
            'create' => CreateCategory::route('/create'),
            'edit' => EditCategory::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ])
            ->whereNull('parent_id')
            ->withCount(['products', 'children']);
    }
}
