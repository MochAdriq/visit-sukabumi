<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\MitraBookingResource\Pages;
use App\Models\Booking;
use App\Models\HotelRoom;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MitraBookingResource extends Resource
{
    protected static ?string $model = Booking::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = '1. Reservasi & Tamu';
    protected static ?string $navigationLabel = 'Pesanan & Tamu';
    protected static ?string $modelLabel = 'Pesanan Tamu';
    protected static ?string $pluralModelLabel = 'Daftar Pesanan & Tamu';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        $user = Auth::user();
        if (!$user) return false;
        return $user->isAdmin() || $user->hasPlaceAccess() || $user->hasEventAccess();
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery()->latest('created_at');
        }

        $placeIds = $user ? $user->ownedPlaces()->pluck('id') : collect();
        $roomIds = HotelRoom::whereIn('place_id', $placeIds)->pluck('id');
        $myEventIds = $user ? $user->events()->pluck('id') : collect();
        $ticketIds = \App\Models\EventTicket::whereIn('event_id', $myEventIds)->pluck('id');

        return parent::getEloquentQuery()
            ->where(function (Builder $query) use ($placeIds, $roomIds, $ticketIds) {
                $query->where(function (Builder $q) use ($roomIds) {
                    $q->where('bookable_type', HotelRoom::class)
                      ->whereIn('bookable_id', $roomIds);
                })->orWhere(function (Builder $q) use ($placeIds) {
                    $q->where('bookable_type', Place::class)
                      ->whereIn('bookable_id', $placeIds);
                })->orWhere(function (Builder $q) use ($ticketIds) {
                    $q->where('bookable_type', \App\Models\EventTicket::class)
                      ->whereIn('bookable_id', $ticketIds);
                });
            })
            ->latest('created_at');
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('booking_code')
                    ->label('Kode Booking')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('booking_type')
                    ->label('Kategori')
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'hotel' => 'Kamar Hotel',
                        'event' => 'Tiket Event',
                        default => ucfirst($state ?? '-'),
                    }),

                Tables\Columns\TextColumn::make('customer_name')
                    ->label('Nama Pemesan')
                    ->weight('bold')
                    ->searchable()
                    ->description(fn (Booking $record): string => $record->customer_phone ?? '-'),

                Tables\Columns\TextColumn::make('source_title')
                    ->label('Item / Layanan')
                    ->wrap()
                    ->searchable(),

                Tables\Columns\TextColumn::make('check_in_date')
                    ->label('Tgl Check-in')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('check_out_date')
                    ->label('Tgl Check-out')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('quantity')
                    ->label('Jml')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Total Bayar')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\BadgeColumn::make('payment_status')
                    ->label('Status Bayar')
                    ->colors([
                        'success' => 'paid',
                        'warning' => 'pending',
                        'danger' => 'cancelled',
                        'secondary' => 'refunded',
                    ])
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu Pembayaran',
                        'cancelled' => 'Dibatalkan',
                        'refunded' => 'Dikembalikan',
                        default => ucfirst($state),
                    }),

                Tables\Columns\ImageColumn::make('payment_proof')
                    ->label('Bukti Transfer')
                    ->disk('public')
                    ->toggleable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Pesan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('booking_type')
                    ->label('Kategori Layanan')
                    ->options([
                        'hotel' => 'Kamar Hotel',
                        'event' => 'Tiket Event',
                    ]),

                Tables\Filters\SelectFilter::make('payment_status')
                    ->label('Status Pembayaran')
                    ->options([
                        'paid' => 'Lunas',
                        'pending' => 'Menunggu Pembayaran',
                        'cancelled' => 'Dibatalkan',
                        'refunded' => 'Dikembalikan',
                    ]),
            ])
            ->actions([
                Tables\Actions\Action::make('verifyPayment')
                    ->label('Verifikasi Lunas')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Verifikasi Pembayaran Tamu')
                    ->modalDescription(fn(Booking $record) => "Apakah Anda yakin ingin memverifikasi pembayaran pesanan ini ({$record->booking_code}) senilai Rp " . number_format($record->total_amount, 0, ',', '.') . " sebagai LUNAS?")
                    ->visible(fn(Booking $record) => $record->payment_status === 'pending')
                    ->action(function(Booking $record) {
                        $record->update([
                            'payment_status' => 'paid',
                            'paid_at' => now(),
                            'payment_method' => 'manual_transfer',
                            'payment_reference' => $record->payment_reference ?? ('MANUAL-' . strtoupper(\Illuminate\Support\Str::random(8))),
                        ]);
                        app(\App\Services\BookingPricingService::class)->recordTaxEscrow($record);
                        \Filament\Notifications\Notification::make()
                            ->title('Pembayaran Berhasil Diverifikasi')
                            ->body("Pesanan {$record->booking_code} kini berstatus Lunas.")
                            ->success()
                            ->send();
                    }),
                Tables\Actions\ViewAction::make()
                    ->label('Detail')
                    ->modalHeading('Rincian Pesanan Tamu'),
            ])
            ->bulkActions([]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Infolists\Components\Section::make('Informasi Tamu & Pesanan')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\TextEntry::make('booking_code')
                            ->label('Kode Pemesanan')
                            ->fontFamily('mono')
                            ->weight('bold'),

                        Infolists\Components\TextEntry::make('payment_status')
                            ->label('Status Pembayaran')
                            ->badge()
                            ->color(fn (string $state): string => match ($state) {
                                'paid' => 'success',
                                'pending' => 'warning',
                                'cancelled' => 'danger',
                                default => 'gray',
                            })
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'paid' => 'LUNAS',
                                'pending' => 'MENUNGGU PEMBAYARAN',
                                'cancelled' => 'DIBATALKAN',
                                default => strtoupper($state),
                            }),

                        Infolists\Components\TextEntry::make('customer_name')
                            ->label('Nama Tamu'),

                        Infolists\Components\TextEntry::make('customer_phone')
                            ->label('Nomor WhatsApp / HP'),

                        Infolists\Components\TextEntry::make('customer_email')
                            ->label('Email'),

                        Infolists\Components\TextEntry::make('source_title')
                            ->label('Kamar / Tiket Dipesan'),

                        Infolists\Components\TextEntry::make('check_in_date')
                            ->label('Tanggal Check-In')
                            ->date('l, d F Y')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('check_out_date')
                            ->label('Tanggal Check-Out')
                            ->date('l, d F Y')
                            ->placeholder('-'),

                        Infolists\Components\TextEntry::make('quantity')
                            ->label('Jumlah Kamar / Tiket'),

                        Infolists\Components\TextEntry::make('paid_at')
                            ->label('Waktu Pembayaran')
                            ->dateTime('d M Y, H:i WIB')
                            ->placeholder('Belum dibayar'),

                        Infolists\Components\TextEntry::make('notes')
                            ->label('Catatan Permintaan Khusus Tamu')
                            ->columnSpanFull()
                            ->placeholder('Tidak ada catatan khusus dari tamu.'),
                    ]),

                Infolists\Components\Section::make('Rincian Finansial & Pajak PBJT')
                    ->columns(3)
                    ->schema([
                        Infolists\Components\TextEntry::make('subtotal_amount')
                            ->label('Subtotal (Pendapatan Mitra)')
                            ->money('IDR', locale: 'id_ID'),

                        Infolists\Components\TextEntry::make('tax_amount')
                            ->label('Pajak Daerah PBJT (10%)')
                            ->money('IDR', locale: 'id_ID')
                            ->helperText('Disetorkan otomatis ke Kasda'),

                        Infolists\Components\TextEntry::make('total_amount')
                            ->label('Total Dibayar Tamu')
                            ->money('IDR', locale: 'id_ID')
                            ->weight('bold')
                            ->color('success'),
                    ]),

                Infolists\Components\Section::make('Bukti Pembayaran Manual')
                    ->columns(2)
                    ->schema([
                        Infolists\Components\ImageEntry::make('payment_proof')
                            ->label('Foto / Struk Bukti Transfer')
                            ->disk('public'),
                        Infolists\Components\TextEntry::make('payment_proof_uploaded_at')
                            ->label('Waktu Upload Bukti')
                            ->dateTime('d M Y, H:i WIB')
                            ->placeholder('Belum ada bukti diunggah'),
                        Infolists\Components\TextEntry::make('payment_note')
                            ->label('Catatan Pengirim')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMitraBookings::route('/'),
        ];
    }
}
