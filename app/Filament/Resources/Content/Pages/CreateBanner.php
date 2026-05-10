<?php

namespace App\Filament\Resources\Content\Pages;

use App\Filament\Resources\Content\BannerResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBanner extends CreateRecord
{
    protected static string $resource = BannerResource::class;
}
