<?php

namespace App\Filament\Kelola\Resources\MyPlaceResource\Pages;

use App\Filament\Kelola\Resources\MyPlaceResource;
use Filament\Resources\Pages\ListRecords;

class ListMyPlaces extends ListRecords
{
    protected static string $resource = MyPlaceResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
