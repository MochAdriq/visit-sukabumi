<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\EventMonitoringResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventMonitoringResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = '2. Monitoring Pariwisata';
    protected static ?string $navigationLabel = 'Kalender Event Daerah';
    protected static ?string $modelLabel = 'Event & Festival';
    protected static ?string $pluralModelLabel = 'Kalender Event Daerah';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Event Daerah')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Nama Acara / Festival')
                            ->disabled(),
                        Forms\Components\TextInput::make('location_name')
                            ->label('Lokasi Acara')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('start_date')
                            ->label('Waktu Mulai')
                            ->disabled(),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->label('Waktu Selesai')
                            ->disabled(),
                    ])->columns(2),

                Forms\Components\Section::make('Deskripsi & Penyelenggaraan')
                    ->schema([
                        Forms\Components\Textarea::make('description')
                            ->label('Rincian Acara')
                            ->disabled()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Poster')
                    ->circular()
                    ->defaultImageUrl(fn() => 'https://ui-avatars.com/api/?name=Event&background=16a34a&color=fff'),

                Tables\Columns\TextColumn::make('title')
                    ->label('Nama Event / Festival')
                    ->searchable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('location_name')
                    ->label('Lokasi')
                    ->searchable()
                    ->icon('heroicon-m-map-pin'),

                Tables\Columns\TextColumn::make('start_date')
                    ->label('Tanggal Mulai')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('end_date')
                    ->label('Tanggal Selesai')
                    ->dateTime('d M Y, H:i')
                    ->placeholder('-')
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Status Aktif')
                    ->boolean(),
            ])
            ->defaultSort('start_date', 'desc')
            ->actions([
                Tables\Actions\ViewAction::make()
                    ->label('Detail Event'),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEventMonitorings::route('/'),
        ];
    }
}
