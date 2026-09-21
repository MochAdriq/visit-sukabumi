<?php

namespace App\Filament\Dinas\Widgets;

use App\Models\TaxLedger;
use Filament\Widgets\ChartWidget;

class TaxSectorChartWidget extends ChartWidget
{
    protected static ?string $heading = 'Perbandingan Kontribusi Pajak Pariwisata (Hotel vs Event)';
    protected static ?int $sort = 3;
    protected int | string | array $columnSpan = 'full';

    public function getDescription(): ?string
    {
        return 'Grafik proporsi penerimaan Pajak Barang dan Jasa Tertentu (PBJT) yang disumbang oleh sektor akomodasi hotel dan event hiburan di Kabupaten Sukabumi.';
    }

    protected function getData(): array
    {
        $hotelTax = (float) TaxLedger::where('sector', 'hotel')->sum('tax_amount');
        $eventTax = (float) TaxLedger::where('sector', 'event')->sum('tax_amount');

        return [
            'datasets' => [
                [
                    'label' => 'Total Penerimaan Pajak (Rp)',
                    'data' => [$hotelTax, $eventTax],
                    'backgroundColor' => [
                        '#163766', // Deep Blue Hotel
                        '#f59e0b', // Amber Event
                    ],
                ],
            ],
            'labels' => [
                'PBJT Perhotelan & Akomodasi (Rp ' . number_format($hotelTax, 0, ',', '.') . ')',
                'PBJT Kesenian, Musik & Event (Rp ' . number_format($eventTax, 0, ',', '.') . ')',
            ],
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
