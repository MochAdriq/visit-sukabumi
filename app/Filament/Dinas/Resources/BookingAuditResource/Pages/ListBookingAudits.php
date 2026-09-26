<?php

namespace App\Filament\Dinas\Resources\BookingAuditResource\Pages;

use App\Filament\Dinas\Resources\BookingAuditResource;
use Filament\Resources\Pages\ListRecords;

class ListBookingAudits extends ListRecords
{
    protected static string $resource = BookingAuditResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
