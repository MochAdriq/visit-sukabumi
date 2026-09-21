<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BookingResource\Pages;
use App\Models\Booking;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class BookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = '2. Pembukuan & Pengawasan';
    protected static ?string $navigationLabel = 'Data Pesanan Wisatawan';
    protected static ?string $modelLabel = 'Pemesanan';
    protected static ?string $pluralModelLabel = 'Data Pesanan Wisatawan (Bookings)';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Transaksi')
                    ->schema([
                        Forms\Components\TextInput::make('booking_code')
                            ->label('Kode Booking')
                            ->disabled(),
                        Forms\Components\Select::make('payment_status')
                            ->label('Status Pembayaran')
                            ->options([
                                'pending' => 'Pending (Menunggu Bayar)',
                                'paid' => 'Paid (Lunas)',
                                'cancelled' => 'Cancelled (Dibatalkan)',
                                'refunded' => 'Refunded (Dikembalikan)',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('customer_name')
                            ->label('Nama Pemesan')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_email')
                            ->label('Email')
                            ->disabled(),
                        Forms\Components\TextInput::make('customer_phone')
                            ->label('No. WhatsApp')
                            ->disabled(),
                        Forms\Components\TextInput::make('source_title')
                            ->label('Event / Hotel')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Rincian Finansial & Pajak PBJT')
                    ->schema([
                        Forms\Components\TextInput::make('base_price')
                            ->label('Harga Dasar')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('quantity')
                            ->label('Jumlah')
                            ->numeric()
                            ->disabled(),
                        Forms\Components\TextInput::make('subtotal_amount')
                            ->label('Subtotal Vendor')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax_rate_percent')
                            ->label('Tarif PBJT')
                            ->numeric()
                            ->suffix('%')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax_amount')
                            ->label('Pajak PBJT (Kasda)')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Total Bayar Customer')
                            ->numeric()
                            ->prefix('Rp')
                            ->disabled(),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->searchable()
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->copyable(),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Pemesan')
                    ->searchable()
                    ->description(fn(Booking $record): string => $record->customer_phone ?? ''),

                Tables\Columns\BadgeColumn::make('booking_type')
                    ->label('Sektor')
                    ->colors([
                        'primary' => 'hotel',
                        'warning' => 'event',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('source_title')
                    ->label('Nama Item')
                    ->limit(24)
                    ->searchable(),

                Tables\Columns\TextColumn::make('subtotal_amount')
                    ->label('Subtotal')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),

                Tables\Columns\TextColumn::make('tax_amount')
                    ->label('Pajak (PBJT)')
                    ->money('IDR', locale: 'id_ID')
                    ->description(fn(Booking $record): string => "Tarif {$record->tax_rate_percent}%")
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Tagihan')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('bold')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'paid',
                        'danger' => 'cancelled',
                        'secondary' => 'refunded',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('booking_type')
                    ->options([
                        'event' => 'Event',
                        'hotel' => 'Hotel',
                    ]),
                Tables\Filters\SelectFilter::make('payment_status')
                    ->options([
                        'pending' => 'Pending',
                        'paid' => 'Paid',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBookings::route('/'),
        ];
    }
}
