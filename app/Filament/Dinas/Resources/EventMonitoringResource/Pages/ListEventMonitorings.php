<?php

namespace App\Filament\Dinas\Resources\EventMonitoringResource\Pages;

use App\Filament\Dinas\Resources\EventMonitoringResource;
use Filament\Resources\Pages\ListRecords;

class ListEventMonitorings extends ListRecords
{
    protected static string $resource = EventMonitoringResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
