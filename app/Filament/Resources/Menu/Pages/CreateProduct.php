<?php

namespace App\Filament\Resources\Menu\Pages;

use App\Filament\Resources\Menu\ProductResource;
use Filament\Resources\Pages\CreateRecord;

class CreateProduct extends CreateRecord
{
    protected static string $resource = ProductResource::class;
}
