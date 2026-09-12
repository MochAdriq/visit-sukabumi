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
    protected static ?string $navigationLabel = 'Destinasi Saya';
    protected static ?string $modelLabel = 'Destinasi';
    protected static ?string $pluralModelLabel = 'Destinasi';
    protected static ?int $navigationSort = 2;

    /**
     * Hanya tampilkan destinasi yang dimiliki oleh pengelola yang sedang login.
     */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('owner_id', Auth::id());
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Jam Operasional')
                ->description('Atur jam buka dan tutup destinasi Anda.')
                ->schema([
                    Forms\Components\TextInput::make('open_hours')
                        ->label('Jam Operasional')
                        ->placeholder('Contoh: Senin–Minggu, 07.00–17.00 WIB')
                        ->maxLength(255),
                ]),

            Forms\Components\Section::make('Harga & Tiket')
                ->columns(2)
                ->description('Perbarui informasi harga terkini.')
                ->schema([
                    Forms\Components\Toggle::make('has_general_price')
                        ->label('Tampilkan Harga Umum')
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('price')
                        ->label('Harga Dasar / Tiket Masuk (Rp)')
                        ->numeric()
                        ->prefix('Rp'),
                    Forms\Components\TextInput::make('max_price')
                        ->label('Harga Maksimum (Rp)')
                        ->numeric()
                        ->prefix('Rp')
                        ->helperText('Isi jika ada rentang harga'),
                    Forms\Components\TextInput::make('ticket_price')
                        ->label('Harga Tiket Resmi (Rp)')
                        ->numeric()
                        ->prefix('Rp'),
                ]),

            Forms\Components\Section::make('Kontak & Media Sosial')
                ->columns(2)
                ->description('Informasi kontak yang akan ditampilkan kepada pengunjung.')
                ->schema([
                    Forms\Components\TextInput::make('phone')
                        ->label('Nomor Telepon / WhatsApp')
                        ->tel()
                        ->placeholder('+62 812 3456 7890'),
                    Forms\Components\TextInput::make('website')
                        ->label('Website Resmi')
                        ->url()
                        ->placeholder('https://'),
                    Forms\Components\TextInput::make('youtube_url')
                        ->label('Video YouTube')
                        ->url()
                        ->placeholder('https://youtube.com/...'),
                ]),

            Forms\Components\Section::make('Fasilitas')
                ->description('Centang fasilitas yang tersedia di destinasi Anda.')
                ->schema([
                    Forms\Components\CheckboxList::make('facilities')
                        ->label('Fasilitas Tersedia')
                        ->options([
                            'toilet'      => 'Toilet Umum',
                            'musholla'    => 'Musholla / Masjid',
                            'parkir_motor'=> 'Parkir Motor',
                            'parkir_mobil'=> 'Parkir Mobil',
                            'parkir_bus'  => 'Parkir Bus',
                            'wifi'        => 'WiFi',
                            'warung'      => 'Warung / Kantin',
                            'gazebo'      => 'Gazebo / Shelter',
                            'loker'       => 'Loker Penitipan',
                            'aksesibel'   => 'Ramah Disabilitas',
                        ])
                        ->columns(2),
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
                    ->searchable()
                    ->fontFamily('sans'),
                Tables\Columns\TextColumn::make('reviews_avg_rating')
                    ->label('Rating')
                    ->getStateUsing(fn ($record) => round($record->reviews()->avg('rating') ?? 0, 1) . ' / 5'),
                Tables\Columns\TextColumn::make('reviews_count')
                    ->label('Total Ulasan')
                    ->getStateUsing(fn ($record) => $record->reviews()->count()),
                Tables\Columns\IconColumn::make('is_claimed')
                    ->label('Status')
                    ->boolean()
                    ->trueIcon('heroicon-o-shield-check')
                    ->trueColor('success'),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->label('Edit'),
            ])
            ->paginated(false);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListMyPlaces::route('/'),
            'edit'  => Pages\EditMyPlace::route('/{record}/edit'),
        ];
    }
}
