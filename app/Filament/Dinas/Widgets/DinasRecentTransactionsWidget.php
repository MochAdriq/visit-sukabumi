<?php

namespace App\Filament\Dinas\Widgets;

use App\Models\TaxLedger;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class DinasRecentTransactionsWidget extends BaseWidget
{
    protected static ?string $heading = 'Penerimaan Pajak Masuk Terbaru (Realtime Monitoring)';
    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                TaxLedger::query()->with('booking')->latest('created_at')->limit(6)
            )
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Transaksi')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking.booking_code')
                    ->label('Kode Tiket / Booking')
                    ->fontFamily('mono')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('booking.customer_name')
                    ->label('Wisatawan / Pembayar')
                    ->description(fn(TaxLedger $record) => $record->booking?->customer_phone ?? '-'),

                Tables\Columns\BadgeColumn::make('sector')
                    ->label('Sektor')
                    ->colors([
                        'primary' => 'hotel',
                        'warning' => 'event',
                    ])
                    ->formatStateUsing(fn(string $state) => $state === 'hotel' ? 'AKOMODASI HOTEL' : 'EVENT & HIBURAN'),

                Tables\Columns\TextColumn::make('booking.base_price')
                    ->label('Nilai Belanja')
                    ->money('IDR', locale: 'id_ID'),

                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Pajak Bersih (PBJT)')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('black')
                    ->color('success'),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status Kas Penampung')
                    ->colors([
                        'warning' => 'held_in_escrow',
                        'info' => 'ready_for_withdrawal',
                        'success' => 'withdrawn',
                        'danger' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state) => match($state) {
                        'held_in_escrow' => 'Aman di Penampung',
                        'ready_for_withdrawal' => 'Siap Setor ke BJB',
                        'withdrawn' => 'Sudah Masuk Kasda',
                        'refunded' => 'Dikembalikan',
                        default => $state,
                    }),
            ])
            ->paginated(false);
    }
}
