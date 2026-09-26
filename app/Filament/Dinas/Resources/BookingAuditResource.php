<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\BookingAuditResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingAuditResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';
    protected static ?string $navigationGroup = '1. Pendapatan Daerah (PAD)';
    protected static ?string $navigationLabel = 'Audit Transaksi Tiket';
    protected static ?string $modelLabel = 'Audit Transaksi Tiket';
    protected static ?string $pluralModelLabel = 'Audit Transaksi Tiket Wisatawan';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Rincian Transaksi Wisatawan')
                    ->schema([
                        Forms\Components\TextInput::make('booking_code')
                            ->label('Kode Booking')
                            ->disabled(),
                        Forms\Components\TextInput::make('payment_status')
                            ->label('Status Pembayaran')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Wisatawan')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('source_title')
                            ->label('Destinasi / Event Terkait')
                            ->disabled(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah Tiket')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Rincian Finansial & Pajak PBJT')
                    ->schema([
                        Forms\Components\TextInput::make('base_price')
                            ->label('Harga Tiket Masuk')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('subtotal')
                            ->label('Subtotal Dasar (DPP)')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax_rate_percent')
                            ->label('Tarif Pajak PBJT')
                            ->suffix('%')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax_amount')
                            ->label('Porsi Pajak Daerah Masuk')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Transaksi Dibayar')
                            ->prefix('Rp')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Wisatawan')
                    ->searchable()
                    ->description(fn(Booking $record) => $record->customer_phone ?? '-'),

                Tables\Columns\TextColumn::make('source_title')
                    ->label('Destinasi / Event')
                    ->searchable()
                    ->wrap(),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                        'secondary' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'paid' => 'LUNAS',
                        'pending' => 'MENUNGGU BAYAR',
                        'cancelled' => 'DIBATALKAN',
                        'refunded' => 'REFUND',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Pajak Daerah (PAD)')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('bold')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Tiket')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Bayar')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu Bayar',
                        'cancelled' => 'Dibatalkan',
                        'refunded' => 'Refund',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail Audit'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookingAudits::route('/'),
        ];
    }
}
