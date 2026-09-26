<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\MyPlaceResource\Pages;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class MyPlaceResource extends Resource
{
    protected static ?string $model = Place::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = '3. Profil Tempat Wisata';
    protected static ?string $navigationLabel = 'Destinasi Saya';
    protected static ?string $modelLabel = 'Destinasi';
    protected static ?string $pluralModelLabel = 'Destinasi';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return false;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery();
        }

        return parent::getEloquentQuery()->where('owner_id', $user?->id);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Profil Utama Destinasi')
                ->description('Informasi naratif tempat wisata yang dilihat oleh wisatawan.')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->label('Nama Destinasi')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\TextInput::make('district')
                        ->label('Kecamatan')
                        ->placeholder('Contoh: Cikole, Palabuhanratu, Ciemas')
                        ->maxLength(100),

                    Forms\Components\Textarea::make('address')
                        ->label('Alamat Lengkap')
                        ->placeholder('Nama jalan, nomor, desa/kelurahan, patokan lokasi...')
                        ->rows(2)
                        ->columnSpanFull(),

                    Forms\Components\RichEditor::make('description')
                        ->label('Deskripsi Lengkap & Daya Tarik')
                        ->placeholder('Ceritakan keunikan, daya tarik alam/budaya, dan pengalaman yang didapatkan wisatawan...')
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Jam Operasional & Kunjungan')
                ->description('Atur jadwal buka dan tutup destinasi Anda.')
                ->schema([
                    Forms\Components\TextInput::make('open_hours')
                        ->label('Jam Operasional')
                        ->placeholder('Contoh: Setiap Hari, 08.00–17.00 WIB')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('Harga & Tiket Masuk')
                ->columns(2)
                ->description('Perbarui informasi harga tiket masuk terkini.')
                ->schema([
                    Forms\Components\Toggle::make('has_general_price')
                        ->label('Tampilkan Informasi Harga')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('price')
                        ->label('Harga Tiket Dasar (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->placeholder('0 jika gratis'),

                    Forms\Components\TextInput::make('max_price')
                        ->label('Harga Tiket Maksimum (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->helperText('Kosongkan jika bukan rentang harga'),

                    Forms\Components\Toggle::make('has_ticket')
                        ->label('Buka Penjualan Tiket Online')
                        ->helperText('Jika diaktifkan, wisatawan dapat membeli tiket langsung melalui platform Visit Sukabumi.')
                        ->columnSpanFull(),

                    Forms\Components\TextInput::make('ticket_price')
                        ->label('Tarif Tiket Resmi Online (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->visible(fn (Forms\Get $get): bool => (bool) $get('has_ticket')),

                    Forms\Components\Textarea::make('ticket_terms')
                        ->label('Syarat & Ketentuan Tiket')
                        ->placeholder('Ketentuan usia anak, jam masuk terakhir, penukaran tiket...')
                        ->visible(fn (Forms\Get $get): bool => (bool) $get('has_ticket'))
                        ->columnSpanFull(),
                ]),

            Forms\Components\Section::make('Kontak Resmi & Media')
                ->columns(3)
                ->description('Saluran komunikasi pengelola untuk pertanyaan wisatawan.')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor WhatsApp / Telepon')
                        ->tel()
                        ->placeholder('+62 812-xxxx-xxxx'),

                    Forms\Components\TextInput::make('website')
                        ->label('Website Resmi')
                        ->url()
                        ->placeholder('https://...'),

                    Forms\Components\TextInput::make('youtube_url')
                        ->label('Tautan Video YouTube')
                        ->url()
                        ->placeholder('https://youtube.com/watch?v=...'),
                ]),

            Forms\Components\Section::make('Fasilitas Tempat Wisata')
                ->description('Centang fasilitas yang tersedia di lokasi.')
                ->schema([
                    Forms\Components\CheckboxList::make('facilities')
                        ->label('Fasilitas Tersedia')
                        ->options([
                            'toilet' => 'Toilet Umum',
                            'musholla' => 'Musholla / Masjid',
                            'parkir_motor' => 'Area Parkir Motor',
                            'parkir_mobil' => 'Area Parkir Mobil',
                            'parkir_bus' => 'Area Parkir Bus Wisata',
                            'wifi' => 'Akses Internet / Wi-Fi',
                            'warung' => 'Kantin / Restoran / Kuliner',
                            'gazebo' => 'Gazebo / Saung Istirahat',
                            'loker' => 'Loker Penitipan Barang',
                            'aksesibel' => 'Fasilitas Ramah Disabilitas',
                            'atm' => 'Mesin ATM / Gerai Pembayaran',
                            'souvenir' => 'Pusat Oleh-Oleh & Cinderamata',
                        ])
                        ->columns(3),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('cover_image_url')
                    ->label('Foto')
                    ->circular()
                    ->getStateUsing(fn ($record) => $record->cover_image_url),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Destinasi')
                    ->weight('bold')
                    ->searchable()
                    ->description(fn (Place $record): string => $record->district ?? 'Kab. Sukabumi'),

                Tables\Columns\TextColumn::make('open_hours')
                    ->label('Jam Buka')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Masuk')
                    ->money('IDR', locale: 'id_ID')
                    ->placeholder('Gratis'),

                Tables\Columns\TextColumn::make('reviews_avg_rating')
                    ->label('Rating')
                    ->getStateUsing(fn ($record) => round($record->reviews()->avg('rating') ?? 0, 1) . ' / 5')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('reviews_count')
                    ->label('Ulasan')
                    ->getStateUsing(fn ($record) => $record->reviews()->count() . ' Ulasan'),

                Tables\Columns\IconColumn::make('is_claimed')
                    ->label('Terverifikasi')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->trueColor('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit Profil'),
                Tables\Actions\Action::make('view_public')
                    ->label('Lihat Publik')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Place $record): string => route('place.show', $record->slug))
                    ->openUrlInNewTab(),
            ])
            ->paginated(false);
    }

    public static function getRecordRouteKeyName(): ?string
    {
        return 'slug';
    }

    public static function resolveRecordRouteBinding(int | string $key): ?\Illuminate\Database\Eloquent\Model
    {
        return static::getEloquentQuery()
            ->where(function ($query) use ($key) {
                $query->where('slug', $key);
                if (is_numeric($key)) {
                    $query->orWhere('id', (int) $key);
                }
            })
            ->first();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyPlaces::route('/'),
            'edit' => Pages\EditMyPlace::route('/{record}/edit'),
        ];
    }
}
