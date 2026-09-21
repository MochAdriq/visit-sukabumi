<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxLedgerResource\Pages;
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
    protected static ?string $navigationGroup = '2. Pembukuan & Pengawasan';
    protected static ?string $navigationLabel = 'Buku Mutasi Pajak (Tax Ledgers)';
    protected static ?string $modelLabel = 'Mutasi Kas Pajak';
    protected static ?string $pluralModelLabel = 'Buku Mutasi Pajak (Tax Ledgers)';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('vendor_name')
                    ->label('Wajib Pajak (Vendor/Penyelenggara)')
                    ->disabled(),
                Forms\Components\TextInput::make('sector')
                    ->label('Sektor')
                    ->disabled(),
                Forms\Components\TextInput::make('tax_amount')
                    ->label('Nominal Pajak Masuk')
                    ->numeric()
                    ->prefix('Rp')
                    ->disabled(),
                Forms\Components\Select::make('status')
                    ->label('Status Kas Penampung (Escrow)')
                    ->options([
                        'held_in_escrow' => 'Tertampung di Escrow',
                        'ready_for_withdrawal' => 'Siap Ditarik ke RKUD',
                        'withdrawn' => 'Sudah Dicairkan ke Kasda',
                        'refunded' => 'Dikembalikan (Refund)',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('ID Mutasi')
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking.booking_code')
                    ->label('Kode Transaksi')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\BadgeColumn::make('sector')
                    ->label('Sektor PBJT')
                    ->colors([
                        'primary' => 'hotel',
                        'warning' => 'event',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('vendor_name')
                    ->label('Wajib Pajak (Hotel/EO)')
                    ->searchable()
                    ->weight('medium'),

                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Pajak PBJT (Kasda)')
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
                        'ready_for_withdrawal' => 'SIAP DITARIK KE RKUD',
                        'withdrawn' => 'SUDAH DISETOR KE KASDA',
                        'refunded' => 'DIKEMBALIKAN',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Masuk')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('sector')
                    ->options([
                        'hotel' => 'Perhotelan',
                        'event' => 'Kesenian & Hiburan (Event)',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'held_in_escrow' => 'Tertampung di Escrow',
                        'ready_for_withdrawal' => 'Siap Ditarik',
                        'withdrawn' => 'Sudah Disetor ke Kasda',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxLedgers::route('/'),
        ];
    }
}
