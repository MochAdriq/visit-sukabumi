<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceImageResource\Pages;
use App\Models\PlaceImage;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceImageResource extends Resource
{
    protected static ?string $model = PlaceImage::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Galeri Foto';
    protected static ?string $pluralModelLabel = 'Galeri Foto';
    protected static ?int $navigationSort = 3;

    // Sembunyikan dari sidebar — sudah terintegrasi di dalam PlaceResource
    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('place_id')
                    ->relationship('place', 'name')
                    ->required()
                    ->searchable()
                    ->preload()
                    ->label('Destinasi'),
                Forms\Components\FileUpload::make('image_path')
                    ->image()
                    ->required()
                    ->imageEditor()
                    ->directory('places')
                    ->label('Foto'),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Foto Utama')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('place.name')
                    ->sortable()
                    ->label('Destinasi'),
                Tables\Columns\ImageColumn::make('image_path')
                    ->disk('public'),
                Tables\Columns\IconColumn::make('is_primary')
                    ->boolean()
                    ->label('Foto Utama'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListPlaceImages::route('/'),
            'create' => Pages\CreatePlaceImage::route('/create'),
            'edit'   => Pages\EditPlaceImage::route('/{record}/edit'),
        ];
    }
}
