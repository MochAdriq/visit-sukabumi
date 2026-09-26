<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\PlaceGalleryResource\Pages;
use App\Models\Place;
use App\Models\PlaceImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class PlaceGalleryResource extends Resource
{
    protected static ?string $model = PlaceImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = '3. Profil Tempat Wisata';
    protected static ?string $navigationLabel = 'Galeri Foto Wisata';
    protected static ?string $modelLabel = 'Foto Galeri';
    protected static ?string $pluralModelLabel = 'Galeri Foto';
    protected static ?int $navigationSort = 2;

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
                Forms\Components\Section::make('Unggah Foto Destinasi')
                    ->schema([
                        Forms\Components\Select::make('place_id')
                            ->label('Destinasi Wisata')
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
                            ->required(),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('File Foto')
                            ->image()
                            ->directory('places')
                            ->imageEditor()
                            ->required()
                            ->helperText('Format JPG, JPEG, PNG, atau WEBP beresolusi tajam.'),

                        Forms\Components\Toggle::make('is_primary')
                            ->label('Jadikan Foto Utama (Cover)')
                            ->helperText('Foto utama akan tampil sebagai gambar sampul destinasi di kartu pencarian dan halaman depan.')
                            ->default(false),

                        Forms\Components\TextInput::make('copyright_name')
                            ->label('Kredit Foto / Fotografer')
                            ->placeholder('Contoh: Dok. Pengelola, Nama Fotografer'),

                        Forms\Components\TextInput::make('copyright_link')
                            ->label('Tautan Sumber / Portofolio')
                            ->url()
                            ->placeholder('https://instagram.com/...'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->square()
                    ->disk('public'),

                Tables\Columns\TextColumn::make('place.name')
                    ->label('Destinasi')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_primary')
                    ->label('Foto Utama (Cover)'),

                Tables\Columns\TextColumn::make('copyright_name')
                    ->label('Kredit Foto')
                    ->placeholder('-'),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Waktu Unggah')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_primary')
                    ->label('Tipe Foto')
                    ->trueLabel('Foto Utama')
                    ->falseLabel('Foto Galeri'),
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
            'index' => Pages\ListPlaceGalleries::route('/'),
            'create' => Pages\CreatePlaceGallery::route('/create'),
            'edit' => Pages\EditPlaceGallery::route('/{record}/edit'),
        ];
    }
}
