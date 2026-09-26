<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\PlaceMonitoringResource\Pages;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceMonitoringResource extends Resource
{
    protected static ?string $model = Place::class;

    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationGroup = '2. Monitoring Pariwisata';
    protected static ?string $navigationLabel = 'Direktori Destinasi';
    protected static ?string $modelLabel = 'Destinasi Wisata';
    protected static ?string $pluralModelLabel = 'Monitoring Destinasi Wisata';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tempat Wisata')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->label('Nama Destinasi')
                            ->disabled(),
                        Forms\Components\TextInput::make('category.name')
                            ->label('Kategori')
                            ->disabled(),
                        Forms\Components\TextInput::make('district')
                            ->label('Kecamatan')
                            ->disabled(),
                        Forms\Components\TextInput::make('address')
                            ->label('Alamat Lengkap')
                            ->disabled(),
                        Forms\Components\TextInput::make('phone')
                            ->label('Kontak / WhatsApp')
                            ->disabled(),
                        Forms\Components\TextInput::make('owner.name')
                            ->label('Mitra Pengelola Terdaftar')
                            ->disabled()
                            ->default('Pemerintah Daerah / Publik'),
                    ])->columns(2),

                Forms\Components\Section::make('Komersial & Tiket')
                    ->schema([
                        Forms\Components\TextInput::make('price')
                            ->label('Harga Tiket Masuk')
                            ->prefix('Rp')
                            ->disabled(),
                        Forms\Components\TextInput::make('open_hours')
                            ->label('Jam Operasional')
                            ->disabled(),
                        Forms\Components\Toggle::make('has_ticket')
                            ->label('Menjual Tiket Masuk Online')
                            ->disabled(),
                        Forms\Components\Toggle::make('has_accommodation')
                            ->label('Menyediakan Fasilitas Menginap')
                            ->disabled(),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('primaryImage.image_path')
                    ->label('Foto')
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=Wisata&background=0284c7&color=fff'),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Destinasi')
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->color('primary')
                    ->sortable(),

                Tables\Columns\TextColumn::make('district')
                    ->label('Kecamatan')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('price')
                    ->label('Harga Tiket')
                    ->money('IDR', locale: 'id_ID')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'success' => 'published',
                        'warning' => 'pending',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'published' => 'TERVERIFIKASI',
                        'pending' => 'MENUNGGU VERIFIKASI',
                        'rejected' => 'DITOLAK',
                        default => strtoupper($state),
                    }),

                Tables\Columns\IconColumn::make('is_claimed')
                    ->label('Ada Mitra')
                    ->boolean(),
            ])
            ->defaultSort('name', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->relationship('category', 'name')
                    ->label('Filter Kategori'),

                Tables\Filters\SelectFilter::make('district')
                    ->options(fn() => Place::whereNotNull('district')->distinct()->pluck('district', 'district')->toArray())
                    ->label('Filter Kecamatan'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail Destinasi'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaceMonitorings::route('/'),
        ];
    }
}
