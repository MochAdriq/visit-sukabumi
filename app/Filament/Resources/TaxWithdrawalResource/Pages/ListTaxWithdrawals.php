<?php

namespace App\Filament\Resources\TaxWithdrawalResource\Pages;

use App\Filament\Resources\TaxWithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxWithdrawals extends ListRecords
{
    protected static string $resource = TaxWithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Penarikan Pajak'),
        ];
    }
}
