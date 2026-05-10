<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Pages\Dashboard as BaseDashboard;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class Dashboard extends BaseDashboard
{
    use HasFiltersForm;

    // protected static ?string $navigationIcon = 'heroicon-o-home';

    protected static ?string $title = 'Dashboard';

    public function filtersForm(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        DatePicker::make('startDate')
                            ->label(__('admin/dashboard.filters.start_date'))
                            ->default(now()->startOfMonth()->toDateString())
                            ->maxDate(now()),

                        DatePicker::make('endDate')
                            ->label(__('admin/dashboard.filters.end_date'))
                            ->default(now()->toDateString())
                            ->maxDate(now()),
                    ])
                    ->columns(2),
            ]);
    }
}
