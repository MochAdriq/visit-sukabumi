<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceResource\Pages;
use App\Models\Place;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PlaceResource extends Resource
{
    protected static ?string $model = Place::class;
    protected static ?string $navigationIcon = 'heroicon-o-map-pin';
    protected static ?string $navigationLabel = 'Destinasi';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informasi Dasar')
                ->columns(2)
                ->schema([
                    Forms\Components\Select::make('category_id')
                        ->relationship('category', 'name')
                        ->required()
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
                ]),

            Forms\Components\Section::make('Koordinat Peta')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('latitude')
                        ->numeric()
                        ->label('Latitude')
                        ->placeholder('-6.9175'),
                    Forms\Components\TextInput::make('longitude')
                        ->numeric()
                        ->label('Longitude')
                        ->placeholder('106.9236'),
                ]),

            Forms\Components\Section::make('Detail Kunjungan')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('price')
                        ->numeric()
                        ->prefix('Rp')
                        ->label('Harga Tiket')
                        ->placeholder('0 = Gratis'),
                    Forms\Components\TextInput::make('phone')
                        ->tel()
                        ->maxLength(20)
                        ->label('Nomor WhatsApp')
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
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->label('Nama'),
                Tables\Columns\TextColumn::make('category.name')
                    ->sortable()
                    ->label('Kategori'),
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
                    ->relationship('category', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Place $record) => url('/place/'.$record->slug))
                    ->openUrlInNewTab(),
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
