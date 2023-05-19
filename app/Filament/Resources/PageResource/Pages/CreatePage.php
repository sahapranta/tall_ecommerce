<?php

namespace App\Filament\Resources\PageResource\Pages;

use App\Filament\Resources\PageResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePage extends CreateRecord
{

    public static function getResource(): string
    {
        return config('filament-pages.filament.resource', PageResource::class);
    }
}
