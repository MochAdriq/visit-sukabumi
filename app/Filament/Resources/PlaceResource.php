<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Destinasi';
    protected static ?string $pluralModelLabel = 'Destinasi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            // ── INFORMASI DASAR ──────────────────────────────────────
            Forms\Components\Section::make('Informasi Dasar')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
                        ->preload()
                        ->label('Kategori'),
                    Forms\Components\Select::make('status')
                        ->options([
                            'published' => 'Published',
                            'draft'     => 'Draft',
                        ])
                        ->required()
                        ->default('draft')
                        ->label('Status'),
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(255)
                        ->label('Nama Destinasi')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn($state, callable $set) =>
                            $set('slug', \Illuminate\Support\Str::slug($state))
                        ),
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->label('Slug (URL)')
                        ->helperText('Otomatis terisi dari nama, bisa diedit manual'),
                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull()
                        ->rows(5)
                        ->label('Deskripsi'),
                    Forms\Components\Textarea::make('address')
                        ->columnSpanFull()
                        ->rows(2)
                        ->label('Alamat Lengkap'),
                    Forms\Components\TextInput::make('district')
                        ->columnSpanFull()
                        ->maxLength(100)
                        ->label('Kecamatan')
                        ->placeholder('Contoh: Pelabuhan Ratu'),
                ]),

            // ── KOORDINAT PETA ───────────────────────────────────────
            Forms\Components\Section::make('Koordinat Peta')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->step('any')
                        ->nullable()
                        ->label('Latitude')
                        ->placeholder('-6.9175'),
                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->step('any')
                        ->nullable()
                        ->label('Longitude')
                        ->placeholder('106.9236'),
                ]),

            // ── DETAIL KUNJUNGAN ─────────────────────────────────────
            Forms\Components\Section::make('Detail Kunjungan')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Harga Tiket Umum')
                        ->placeholder('0 = Gratis')
                        ->visible(fn(Forms\Get $get): bool => (bool) $get('has_general_price')),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20)
                        ->label('Nomor WhatsApp / Kontak')
                        ->placeholder('08xxxxxxxxxx'),
                    Forms\Components\TextInput::make('open_hours')
                        ->maxLength(100)
                        ->label('Jam Operasional')
                        ->placeholder('Senin–Minggu, 07.00–17.00'),
                    Forms\Components\TextInput::make('duration')
                        ->maxLength(50)
                        ->label('Durasi Kunjungan')
                        ->placeholder('1–3 jam'),
                    Forms\Components\TextInput::make('website')
                        ->url()
                        ->maxLength(255)
                        ->label('Website Resmi')
                        ->placeholder('https://'),
                    Forms\Components\TextInput::make('ticket_info')
                        ->maxLength(255)
                        ->label('Info Tiket Tambahan')
                        ->placeholder('Termasuk parkir dan pemandu'),
                    Forms\Components\TagsInput::make('facilities')
                        ->columnSpanFull()
                        ->label('Fasilitas Utama')
                        ->placeholder('Ketik fasilitas lalu tekan Enter (contoh: WiFi, Kolam Renang)'),
                    Forms\Components\Textarea::make('nearby_places')
                        ->columnSpanFull()
                        ->rows(2)
                        ->maxLength(255)
                        ->label('Dekat Dengan (Nearby Places)')
                        ->placeholder('Contoh: 5 Menit ke Alun-Alun, Dekat Pantai Karang Hawu'),
                ]),

            // ── GALERI FOTO ──────────────────────────────────────────
            Forms\Components\Section::make('Galeri Foto')
                ->description('Upload beberapa foto destinasi. Centang "Foto Utama" untuk foto yang tampil di listing.')
                ->collapsed()
                ->schema([
                    Forms\Components\Repeater::make('placeImages')
                        ->relationship()
                        ->schema([
                            Forms\Components\FileUpload::make('image_path')
                                ->image()
                                ->required()
                                ->imageEditor()
                                ->directory('places')
                                ->label('Foto'),
                            Forms\Components\Toggle::make('is_primary')
                                ->label('Foto Utama')
                                ->default(false),
                            Forms\Components\TextInput::make('copyright_name')
                                ->label('Nama Copyright (Opsional)')
                                ->maxLength(255),
                            Forms\Components\TextInput::make('copyright_link')
                                ->label('Link Sumber (Opsional)')
                                ->url()
                                ->maxLength(255),
                        ])
                        ->columns(2)
                        ->addActionLabel('+ Tambah Foto')
                        ->columnSpanFull(),
                ]),

            // ── TAG & AKTIVITAS ───────────────────────────────────────
            Forms\Components\Section::make('Tag & Aktivitas')
                ->description('Assign tag yang relevan. Tag menentukan di menu navbar mana destinasi ini tampil (Aktivitas / Wisata).')
                ->icon('heroicon-o-tag')
                ->collapsed()
                ->schema([
                    Forms\Components\Select::make('tags')
                        ->multiple()
                        ->relationship('tags', 'name')
                        ->preload()
                        ->searchable()
                        ->columnSpanFull()
                        ->label('Tag')
                        ->helperText('Satu destinasi bisa punya banyak tag sekaligus')
                        ->getOptionLabelFromRecordUsing(fn (Tag $record) =>
                            '[' . ($record->type === 'activity' ? 'Aktivitas' : 'Wisata') . '] ' . $record->name
                        ),
                ]),

            // ════════════════════════════════════════════════════════
            // ── FITUR AKTIF (TOGGLE MASTER) ──────────────────────────
            // ════════════════════════════════════════════════════════
            Forms\Components\Section::make('Aktifkan Fitur Khusus')
                ->description('Aktifkan fitur yang relevan untuk destinasi ini. Field tambahan akan muncul secara otomatis.')
                ->icon('heroicon-o-sparkles')
                ->columns(3)
                ->schema([
                    Forms\Components\Toggle::make('has_general_price')
                        ->label('Harga Tiket Umum')
                        ->helperText('Aktifkan jika ada harga tiket')
                        ->live()
                        ->default(false),
                    Forms\Components\Toggle::make('has_ticket')
                        ->label('Tiket Online')
                        ->helperText('Aktifkan jika ada pemesanan tiket')
                        ->live()
                        ->default(false),
                    Forms\Components\Toggle::make('has_accommodation')
                        ->label('Penginapan / Hotel')
                        ->helperText('Aktifkan jika ini tempat menginap')
                        ->live()
                        ->default(false),
                    Forms\Components\Toggle::make('has_restaurant')
                        ->label('Restoran / Kuliner')
                        ->helperText('Aktifkan jika ini tempat makan')
                        ->live()
                        ->default(false),
                    Forms\Components\Toggle::make('has_tour_package')
                        ->label('Paket Tur & Guide')
                        ->helperText('Aktifkan jika ada paket wisata')
                        ->live()
                        ->default(false),
                    Forms\Components\Toggle::make('has_accessibility_warning')
                        ->label('Peringatan Akses')
                        ->helperText('Aktifkan jika ada info akses khusus')
                        ->live()
                        ->default(false),
                ]),

            // ── SEKSI TIKET ──────────────────────────────────────────
            Forms\Components\Section::make('Informasi Tiket Online')
                ->icon('heroicon-o-ticket')
                ->columns(2)
                ->visible(fn(Forms\Get $get): bool => (bool) $get('has_ticket'))
                ->schema([
                    Forms\Components\TextInput::make('ticket_price')
                        ->numeric()
                        ->prefix('Rp')
                        ->required()
                        ->label('Harga Tiket per Orang')
                        ->placeholder('50000'),
                    Forms\Components\TextInput::make('ticket_booking_url')
                        ->url()
                        ->label('URL / WhatsApp Pemesanan')
                        ->placeholder('https://wa.me/628... atau https://tiket.com/...'),
                    Forms\Components\Textarea::make('ticket_terms')
                        ->columnSpanFull()
                        ->rows(3)
                        ->label('Syarat & Ketentuan Tiket')
                        ->placeholder('Contoh: Tiket tidak dapat dikembalikan. Check-in 30 menit sebelum jadwal.'),
                ]),

            // ── SEKSI PENGINAPAN ─────────────────────────────────────
            Forms\Components\Section::make('Informasi Penginapan / Hotel')
                ->icon('heroicon-o-home-modern')
                ->columns(2)
                ->visible(fn(Forms\Get $get): bool => (bool) $get('has_accommodation'))
                ->schema([
                    Forms\Components\Select::make('hotel_star')
                        ->options([
                            1 => '⭐ Bintang 1',
                            2 => '⭐⭐ Bintang 2',
                            3 => '⭐⭐⭐ Bintang 3',
                            4 => '⭐⭐⭐⭐ Bintang 4',
                            5 => '⭐⭐⭐⭐⭐ Bintang 5',
                        ])
                        ->label('Klasifikasi Bintang'),
                    Forms\Components\TextInput::make('hotel_booking_url')
                        ->url()
                        ->label('Link Booking (Agoda/Traveloka/dll)')
                        ->placeholder('https://agoda.com/...'),
                    Forms\Components\TagsInput::make('hotel_facilities')
                        ->columnSpanFull()
                        ->label('Fasilitas Penginapan')
                        ->placeholder('Contoh: Kolam Renang, Sarapan Gratis, AC, WiFi, Parkir'),
                ]),

            // ── SEKSI RESTORAN ───────────────────────────────────────
            Forms\Components\Section::make('Informasi Restoran / Kuliner')
                ->icon('heroicon-o-cake')
                ->columns(2)
                ->visible(fn(Forms\Get $get): bool => (bool) $get('has_restaurant'))
                ->schema([
                    Forms\Components\Toggle::make('restaurant_is_halal')
                        ->label('Bersertifikat Halal')
                        ->columnSpanFull()
                        ->default(false),
                    Forms\Components\TextInput::make('restaurant_menu_url')
                        ->url()
                        ->label('Link Menu (Gambar/PDF)')
                        ->placeholder('https://drive.google.com/... atau link foto menu'),
                    Forms\Components\TextInput::make('restaurant_reservation_url')
                        ->label('Link / WhatsApp Reservasi Meja')
                        ->placeholder('https://wa.me/628... atau nomor telepon reservasi'),
                ]),

            // ── SEKSI PAKET TUR ──────────────────────────────────────
            Forms\Components\Section::make('Paket Tur & Pemandu Wisata')
                ->icon('heroicon-o-users')
                ->columns(2)
                ->visible(fn(Forms\Get $get): bool => (bool) $get('has_tour_package'))
                ->schema([
                    Forms\Components\TextInput::make('tour_meeting_point')
                        ->columnSpanFull()
                        ->label('Titik Kumpul (Meeting Point)')
                        ->placeholder('Contoh: Parkiran Geopark Ciletuh, pukul 08.00 WIB'),
                    Forms\Components\TextInput::make('tour_guide_contact')
                        ->label('Kontak Pemandu Wisata')
                        ->placeholder('08xxxxxxxxxx atau nama guide'),
                    Forms\Components\Repeater::make('tour_packages')
                        ->label('Daftar Paket')
                        ->columnSpanFull()
                        ->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->label('Nama Paket')
                                ->placeholder('Contoh: Paket Rafting 2H1M'),
                            Forms\Components\TextInput::make('price')
                                ->numeric()
                                ->required()
                                ->prefix('Rp')
                                ->label('Harga'),
                            Forms\Components\TextInput::make('quota')
                                ->numeric()
                                ->label('Kuota (kosongkan = tidak terbatas)')
                                ->placeholder('10'),
                            Forms\Components\Textarea::make('description')
                                ->rows(2)
                                ->label('Deskripsi Paket'),
                        ])
                        ->columns(2)
                        ->addActionLabel('+ Tambah Paket'),
                ]),

            // ── SEKSI AKSESIBILITAS ──────────────────────────────────
            Forms\Components\Section::make('Peringatan & Info Aksesibilitas')
                ->icon('heroicon-o-exclamation-triangle')
                ->columns(2)
                ->visible(fn(Forms\Get $get): bool => (bool) $get('has_accessibility_warning'))
                ->schema([
                    Forms\Components\Select::make('accessibility_type')
                        ->options([
                            'vehicle_only'       => '🚗 Hanya Bisa Kendaraan Roda 4',
                            'motorcycle_only'    => '🏍️ Hanya Bisa Motor / 4WD',
                            'hiking'             => '🥾 Harus Jalan Kaki / Mendaki',
                            'wheelchair_friendly'=> '♿ Ramah Kursi Roda',
                            'boat_required'      => '⛵ Perlu Naik Perahu',
                        ])
                        ->label('Tipe Akses'),
                    Forms\Components\Textarea::make('accessibility_note')
                        ->rows(3)
                        ->label('Detail Keterangan Akses')
                        ->placeholder('Contoh: Jalan berbatu sepanjang 2 km dari parkiran. Disarankan menggunakan sepatu gunung.'),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primaryImage.image_path')
                    ->label('')
                    ->square()
                    ->size(50)
                    ->disk('public'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->badge()
                    ->color('primary')
                    ->label('Kategori'),
                Tables\Columns\TextColumn::make('district')
                    ->searchable()
                    ->label('Kecamatan'),
                Tables\Columns\IconColumn::make('has_ticket')
                    ->boolean()
                    ->label('Tiket'),
                Tables\Columns\IconColumn::make('has_accommodation')
                    ->boolean()
                    ->label('Hotel'),
                Tables\Columns\IconColumn::make('has_restaurant')
                    ->boolean()
                    ->label('Kuliner'),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'published' => 'success',
                        'draft'     => 'warning',
                        default     => 'gray',
                    })
                    ->label('Status'),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options(['published' => 'Published', 'draft' => 'Draft']),
                Tables\Filters\SelectFilter::make('category')
                    ->relationship('category', 'name')
                    ->preload(),
                Tables\Filters\TernaryFilter::make('has_ticket')->label('Punya Tiket'),
                Tables\Filters\TernaryFilter::make('has_accommodation')->label('Penginapan'),
                Tables\Filters\TernaryFilter::make('has_restaurant')->label('Restoran'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Place $record) => url('/place/' . $record->slug))
                    ->openUrlInNewTab(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlaces::route('/'),
            'create' => Pages\CreatePlace::route('/create'),
            'edit'   => Pages\EditPlace::route('/{record}/edit'),
        ];
    }
}
