<?php

namespace App\Filament\Dinas\Resources\PlaceMonitoringResource\Pages;

use App\Filament\Dinas\Resources\PlaceMonitoringResource;
use Filament\Resources\Pages\ListRecords;

class ListPlaceMonitorings extends ListRecords
{
    protected static string $resource = PlaceMonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
