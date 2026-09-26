<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\HotelRoomResource\Pages;
use App\Models\HotelRoom;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class HotelRoomResource extends Resource
{
    protected static ?string $model = HotelRoom::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office-2';
    protected static ?string $navigationGroup = '3. Penginapan & Kamar';
    protected static ?string $navigationLabel = 'Kamar & Akomodasi';
    protected static ?string $modelLabel = 'Tipe Kamar';
    protected static ?string $pluralModelLabel = 'Kamar & Akomodasi';
    protected static ?int $navigationSort = 2;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasPlaceAccess() ?? false;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery()->with('place');
        }

        $placeIds = $user ? $user->ownedPlaces()->pluck('id') : collect();

        return parent::getEloquentQuery()->whereIn('place_id', $placeIds)->with('place');
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tipe Kamar')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('place_id')
                            ->label('Penginapan / Tempat Wisata')
                            ->options(function () {
                                $user = Auth::user();
                                $query = Place::query();
                                if ($user && $user->role !== 'admin') {
                                    $query->where('owner_id', $user->id);
                                }
                                return $query->pluck('name', 'id');
                            })
                            ->default(function () {
                                $user = Auth::user();
                                return $user ? $user->ownedPlaces()->first()?->id : null;
                            })
                            ->required()
                            ->searchable(),

                        Forms\Components\TextInput::make('name')
                            ->label('Nama Tipe Kamar')
                            ->placeholder('Contoh: Deluxe Ocean View, Standard Twin Room')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('price_per_night')
                            ->label('Harga per Malam (Rp)')
                            ->numeric()
                            ->prefix('Rp')
                            ->required()
                            ->minValue(0),

                        Forms\Components\TextInput::make('total_rooms')
                            ->label('Jumlah Unit Kamar Tersedia')
                            ->numeric()
                            ->default(1)
                            ->minValue(1)
                            ->required(),

                        Forms\Components\TextInput::make('max_guests')
                            ->label('Kapasitas Tamu Maksimal')
                            ->numeric()
                            ->default(2)
                            ->suffix('Orang')
                            ->minValue(1)
                            ->required(),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif / Tersedia untuk Dipesan')
                            ->default(true),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi Kamar')
                            ->placeholder('Jelaskan luas kamar, tipe kasur (King/Twin), pemandangan, dan kelebihan kamar ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Fasilitas Kamar')
                    ->schema([
                        Forms\Components\CheckboxList::make('facilities')
                            ->label('Fasilitas yang Termasuk')
                            ->options([
                                'ac' => 'Pendingin Udara (AC)',
                                'wifi' => 'Koneksi Wi-Fi Gratis',
                                'breakfast' => 'Sarapan Termasuk (Free Breakfast)',
                                'hot_water' => 'Pemanas Air (Water Heater)',
                                'tv' => 'Smart TV / TV Kabel',
                                'balcony' => 'Balkon / Teras Pribadi',
                                'bathtub' => 'Bak Mandi (Bathtub)',
                                'kettle' => 'Ketel Listrik (Kopi & Teh)',
                                'fridge' => 'Kulkas Mini',
                                'toiletries' => 'Peralatan Mandi Lengkap',
                                'hairdryer' => 'Pengering Rambut (Hair Dryer)',
                                'room_service' => 'Layanan Kamar 24 Jam',
                            ])
                            ->columns(3),
                    ]),

                Forms\Components\Section::make('Foto Kamar')
                    ->schema([
                        Forms\Components\FileUpload::make('images')
                            ->label('Foto Galeri Kamar')
                            ->multiple()
                            ->image()
                            ->directory('hotel_rooms')
                            ->maxFiles(8)
                            ->imageResizeMode('cover')
                            ->imageCropAspectRatio('16:9')
                            ->imageResizeTargetWidth('1280')
                            ->imageResizeTargetHeight('720')
                            ->helperText('Unggah hingga 8 foto kamar beresolusi baik.'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('images')
                    ->label('Foto')
                    ->circular()
                    ->stacked()
                    ->limit(2)
                    ->disk('public'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Tipe Kamar')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\TextColumn::make('place.name')
                    ->label('Penginapan')
                    ->searchable(),

                Tables\Columns\TextColumn::make('price_per_night')
                    ->label('Tarif / Malam')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('bold')
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('total_rooms')
                    ->label('Total Unit')
                    ->alignCenter(),

                Tables\Columns\TextColumn::make('max_guests')
                    ->label('Kapasitas')
                    ->formatStateUsing(fn ($state) => "{$state} Tamu")
                    ->alignCenter(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Tersedia'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Ketersediaan')
                    ->trueLabel('Tersedia')
                    ->falseLabel('Nonaktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListHotelRooms::route('/'),
            'create' => Pages\CreateHotelRoom::route('/create'),
            'edit' => Pages\EditHotelRoom::route('/{record}/edit'),
        ];
    }
}
