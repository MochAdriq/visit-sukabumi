<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\TaxLedgerResource\Pages;
use App\Models\TaxLedger;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaxLedgerResource extends Resource
{
    protected static ?string $model = TaxLedger::class;

    protected static ?string $navigationIcon = 'heroicon-o-banknotes';
    protected static ?string $navigationGroup = '1. Pendapatan Daerah (PAD)';
    protected static ?string $navigationLabel = 'Buku Mutasi Pajak';
    protected static ?string $modelLabel = 'Mutasi Kas Pajak';
    protected static ?string $pluralModelLabel = 'Buku Mutasi Pajak';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vendor_name')
                    ->label('Wajib Pajak (Vendor / Penyelenggara)')
                    ->disabled(),
                Forms\Components\TextInput::make('sector')
                    ->label('Sektor Pajak (PBJT)')
                    ->disabled(),
                Forms\Components\TextInput::make('tax_amount')
                    ->label('Nominal Pajak Masuk')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
                Forms\Components\TextInput::make('status')
                    ->label('Status Kas Penampung (Escrow)')
                    ->disabled(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal & Waktu')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('vendor_name')
                    ->label('Wajib Pajak (Destinasi/Vendor)')
                    ->searchable()
                    ->weight('medium')
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('sector')
                    ->label('Sektor')
                    ->colors([
                        'primary' => 'hotel',
                        'success' => 'restaurant',
                        'warning' => 'wisata_alam',
                        'info' => 'entertainment',
                        'danger' => 'event',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'hotel' => 'PERHOTELAN',
                        'restaurant' => 'RESTORAN',
                        'wisata_alam' => 'WISATA ALAM',
                        'entertainment' => 'HIBURAN',
                        'event' => 'FESTIVAL / EVENT',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('base_amount')
                    ->label('Dasar Pengenaan Pajak (DPP)')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tax_rate')
                    ->label('Tarif')
                    ->formatStateUsing(fn($state) => "{$state}%")
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Pajak PBJT')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status Escrow')
                    ->colors([
                        'warning' => 'held_in_escrow',
                        'info' => 'ready_for_withdrawal',
                        'success' => 'withdrawn',
                        'danger' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'held_in_escrow' => 'TERTAMPUNG DI ESCROW',
                        'ready_for_withdrawal' => 'SIAP SETOR KASDA',
                        'withdrawn' => 'SUDAH MASUK KASDA',
                        'refunded' => 'DIKEMBALIKAN (REFUND)',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('taxWithdrawal.withdrawal_code')
                    ->label('Kode Setoran')
                    ->fontFamily('mono')
                    ->color('primary')
                    ->default('-'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('sector')
                    ->label('Filter Sektor')
                    ->options([
                        'wisata_alam' => 'Wisata Alam',
                        'hotel' => 'Perhotelan',
                        'restaurant' => 'Restoran',
                        'event' => 'Event & Festival',
                    ]),

                Tables\Filters\SelectFilter::make('status')
                    ->label('Filter Status')
                    ->options([
                        'held_in_escrow' => 'Tertampung di Escrow',
                        'ready_for_withdrawal' => 'Siap Setor Kasda',
                        'withdrawn' => 'Sudah Masuk Kasda',
                        'refunded' => 'Dikembalikan (Refund)',
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxLedgers::route('/'),
        ];
    }
}
