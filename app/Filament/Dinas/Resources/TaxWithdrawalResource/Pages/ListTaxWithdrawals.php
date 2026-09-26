<?php

namespace App\Filament\Dinas\Resources\TaxWithdrawalResource\Pages;

use App\Filament\Dinas\Resources\TaxWithdrawalResource;
use App\Filament\Dinas\Widgets\TaxWithdrawalOverviewWidget;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTaxWithdrawals extends ListRecords
{
    protected static string $resource = TaxWithdrawalResource::class;

    protected static ?string $title = 'Penyetoran Kas Daerah (RKUD)';

    public function getSubheading(): ?string
    {
        return 'Monitoring dan realisasi pemindahbukuan saldo Pajak Barang dan Jasa Tertentu (PBJT 10%) dari rekening penampung (escrow) ke Rekening Kas Umum Daerah Pemkab Sukabumi.';
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Ajukan Penyetoran Baru ke Kasda'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            TaxWithdrawalOverviewWidget::class,
        ];
    }
}
