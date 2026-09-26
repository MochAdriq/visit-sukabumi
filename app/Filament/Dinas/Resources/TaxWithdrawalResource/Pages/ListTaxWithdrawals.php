<?php

namespace App\Filament\Dinas\Resources\TaxWithdrawalResource\Pages;

use App\Filament\Dinas\Resources\TaxWithdrawalResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxWithdrawals extends ListRecords
{
    protected static string $resource = TaxWithdrawalResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Penyetoran ke Kasda'),
        ];
    }
}
