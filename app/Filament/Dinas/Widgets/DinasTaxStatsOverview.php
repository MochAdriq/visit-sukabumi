<?php

namespace App\Filament\Dinas\Widgets;

use App\Models\Booking;
use App\Models\TaxLedger;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DinasTaxStatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;

    protected function getStats(): array
    {
        $totalTaxCollected = (float) TaxLedger::sum('tax_amount');
        $taxInEscrow = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');
        $taxWithdrawn = (float) TaxLedger::where('status', 'withdrawn')->sum('tax_amount');
        $totalTransactions = TaxLedger::count();

        $hotelTax = (float) TaxLedger::where('sector', 'hotel')->sum('tax_amount');
        $eventTax = (float) TaxLedger::where('sector', 'event')->sum('tax_amount');

        return [
            Stat::make('Total Pajak Terkumpul (PBJT)', 'Rp ' . number_format($totalTaxCollected, 0, ',', '.'))
                ->description("Seluruh penerimaan PAD dari pariwisata")
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),

            Stat::make('Saldo Siap Disetor ke Kasda', 'Rp ' . number_format($taxInEscrow, 0, ',', '.'))
                ->description("Dana aman di penampung, siap ditransfer ke BJB")
                ->descriptionIcon('heroicon-m-shield-check')
                ->color('warning'),

            Stat::make('Sudah Masuk Kas Daerah (RKUD)', 'Rp ' . number_format($taxWithdrawn, 0, ',', '.'))
                ->description("Sah diterima di Kasda Pemkab Sukabumi")
                ->descriptionIcon('heroicon-m-building-library')
                ->color('primary'),

            Stat::make('Total Transaksi Berpajak', $totalTransactions . ' Transaksi')
                ->description("Hotel: Rp " . number_format($hotelTax, 0, ',', '.') . " | Event: Rp " . number_format($eventTax, 0, ',', '.'))
                ->descriptionIcon('heroicon-m-receipt-percent')
                ->color('info'),
        ];
    }
}
