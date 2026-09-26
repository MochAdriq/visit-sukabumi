<?php

namespace App\Filament\Dinas\Resources\TaxSettingResource\Pages;

use App\Filament\Dinas\Resources\TaxSettingResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxSettings extends ListRecords
{
    protected static string $resource = TaxSettingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Tarif Pajak'),
        ];
    }
}
