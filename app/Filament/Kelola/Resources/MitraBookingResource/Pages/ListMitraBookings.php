<?php

namespace App\Filament\Kelola\Resources\MitraBookingResource\Pages;

use App\Filament\Kelola\Resources\MitraBookingResource;
use Filament\Resources\Pages\ListRecords;

class ListMitraBookings extends ListRecords
{
    protected static string $resource = MitraBookingResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
