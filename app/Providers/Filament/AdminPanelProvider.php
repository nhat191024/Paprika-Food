<?php

namespace App\Providers\Filament;

use App\Enums\FilamentNavigationGroup;

use Filament\Navigation\NavigationGroup;
use Filament\Panel;
use Filament\PanelProvider;
use App\Filament\Pages\Dashboard;

use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;

use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Illuminate\Support\Facades\App;

use Octopy\Filament\Palette\PaletteSwitcherPlugin;
use Slimani\MediaManager\MediaManagerPlugin;
use SpyApp\ThemeEdinburgh\ThemeEdinburghPlugin;
use AzGasim\FilamentUnsavedChangesModal\FilamentUnsavedChangesModalPlugin;
use RalphJSmit\Filament\Upload\FilamentUpload;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()

            ->viteTheme('resources/css/filament/admin/theme.css')
            ->colors([
                'primary' => Color::Red,
            ])
            ->maxContentWidth(Width::Full)
            ->navigationGroups([
                'SYSTEM' => NavigationGroup::make(fn() => FilamentNavigationGroup::SYSTEM->getLabel()),
                'CONTENT' => NavigationGroup::make(fn() => FilamentNavigationGroup::CONTENT->getLabel()),
                'SETTINGS' => NavigationGroup::make(fn() => FilamentNavigationGroup::SETTINGS->getLabel()),
            ])

            ->topbar(false)

            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')

            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])

            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([])

            ->plugins([
                PaletteSwitcherPlugin::make(),
                ThemeEdinburghPlugin::make(),
                FilamentUnsavedChangesModalPlugin::make(),
                FilamentUpload::make(),
                MediaManagerPlugin::make()
                    ->navigationGroup('system'),
            ])

            ->unsavedChangesAlerts()

            ->bootUsing(function () {
                App::setLocale('vi');
            })

            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
