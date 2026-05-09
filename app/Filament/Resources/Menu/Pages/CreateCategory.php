<?php

namespace App\Filament\Resources\Menu\Pages;

use App\Filament\Resources\Menu\CategoryResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCategory extends CreateRecord
{
    protected static string $resource = CategoryResource::class;
}
