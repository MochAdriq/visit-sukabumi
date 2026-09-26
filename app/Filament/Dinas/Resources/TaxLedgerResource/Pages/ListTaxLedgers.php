<?php

namespace App\Filament\Dinas\Resources\TaxLedgerResource\Pages;

use App\Filament\Dinas\Resources\TaxLedgerResource;
use Filament\Resources\Pages\ListRecords;

class ListTaxLedgers extends ListRecords
{
    protected static string $resource = TaxLedgerResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
