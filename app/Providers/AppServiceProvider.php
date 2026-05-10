<?php

namespace App\Providers;

use App\Enums\FilamentNavigationGroup;

use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Validation\Rules\Password;

use Filament\Facades\Filament;
use Filament\Navigation\NavigationGroup;

use Slimani\MediaManager\Models\File;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->configureDefaults();

        Filament::registerNavigationGroups([
            'system'   => NavigationGroup::make(fn() => FilamentNavigationGroup::SYSTEM->getLabel()),
        ]);

        File::registerMediaConversionsUsing(function (File $file, ?Media $media = null) {
            $file->addMediaConversion('thumb')
                ->width(150)
                ->height(150)
                ->format('webp')
                ->optimize()
                ->queued();

            $file->addMediaConversion('square')
                ->width(500)
                ->height(500)
                ->format('webp')
                ->optimize()
                ->queued();
        });
    }

    /**
     * Configure default behaviors for production-ready applications.
     */
    protected function configureDefaults(): void
    {
        Date::use(CarbonImmutable::class);

        DB::prohibitDestructiveCommands(
            app()->isProduction(),
        );

        Password::defaults(
            fn(): ?Password => app()->isProduction()
                ? Password::min(12)
                ->mixedCase()
                ->letters()
                ->numbers()
                ->symbols()
                ->uncompromised()
                : null,
        );
    }
}
