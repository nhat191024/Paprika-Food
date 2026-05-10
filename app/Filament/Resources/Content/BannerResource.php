<?php

namespace App\Filament\Resources\Content;

use App\Enums\FilamentNavigationGroup;
use App\Filament\Resources\Content\Pages\CreateBanner;
use App\Filament\Resources\Content\Pages\EditBanner;
use App\Filament\Resources\Content\Pages\ListBanners;
use App\Filament\Resources\Content\Schemas\BannerForm;
use App\Filament\Resources\Content\Tables\BannersTable;
use App\Models\Banner;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class BannerResource extends Resource
{
    protected static ?string $model = Banner::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedPhoto;

    protected static string|UnitEnum|null $navigationGroup = 'system';

    protected static ?int $navigationSort = 2;

    public static function getNavigationLabel(): string
    {
        return __('admin/sidebar.navigation.labels.banners');
    }

    public static function getModelLabel(): string
    {
        return __('admin/banner.model.singular');
    }

    public static function getPluralModelLabel(): string
    {
        return __('admin/banner.model.plural');
    }

    public static function form(Schema $schema): Schema
    {
        return BannerForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return BannersTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListBanners::route('/'),
            'create' => CreateBanner::route('/create'),
            'edit' => EditBanner::route('/{record}/edit'),
        ];
    }
}
