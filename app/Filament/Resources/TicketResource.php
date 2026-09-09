<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Models\Ticket;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationGroup = 'Event & Trip';
    protected static ?string $modelLabel = 'Tiket';
    protected static ?string $pluralModelLabel = 'Tiket';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Tiket')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('place_id')
                            ->relationship('place', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Destinasi'),
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->label('Nama Tiket')
                            ->placeholder('Contoh: Tiket Masuk Reguler'),
                        Forms\Components\Select::make('type')
                            ->options([
                                'reguler'      => 'Tiket Reguler',
                                'open_trip'    => 'Open Trip',
                                'guided_tour'  => 'Guided Tour',
                            ])
                            ->required()
                            ->default('reguler')
                            ->label('Tipe Tiket'),
                        Forms\Components\TextInput::make('price')
                            ->required()
                            ->numeric()
                            ->prefix('Rp')
                            ->default(0)
                            ->label('Harga'),
                        Forms\Components\DateTimePicker::make('date')
                            ->label('Tanggal (Khusus Open Trip / Guided Tour)')
                            ->nullable(),
                        Forms\Components\TextInput::make('quota')
                            ->numeric()
                            ->label('Kuota Peserta')
                            ->nullable()
                            ->placeholder('Kosongkan jika tidak terbatas'),
                        Forms\Components\Toggle::make('is_active')
                            ->label('Aktif Dijual')
                            ->default(true),
                        Forms\Components\Textarea::make('description')
                            ->columnSpanFull()
                            ->rows(3)
                            ->label('Keterangan Tambahan'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('place.name')
                    ->sortable()
                    ->searchable()
                    ->label('Destinasi'),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->label('Nama Tiket'),
                Tables\Columns\TextColumn::make('type')
                    ->badge()
                    ->color(fn(string $state) => match($state) {
                        'reguler'     => 'gray',
                        'open_trip'   => 'primary',
                        'guided_tour' => 'success',
                        default       => 'gray',
                    })
                    ->formatStateUsing(fn(string $state) => match($state) {
                        'reguler'     => 'Reguler',
                        'open_trip'   => 'Open Trip',
                        'guided_tour' => 'Guided Tour',
                        default       => $state,
                    })
                    ->label('Tipe'),
                Tables\Columns\TextColumn::make('price')
                    ->money('IDR')
                    ->sortable()
                    ->label('Harga'),
                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->sortable()
                    ->label('Tanggal'),
                Tables\Columns\TextColumn::make('quota')
                    ->numeric()
                    ->sortable()
                    ->label('Kuota')
                    ->default('—'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
                Tables\Filters\SelectFilter::make('type')
                    ->options([
                        'reguler'     => 'Tiket Reguler',
                        'open_trip'   => 'Open Trip',
                        'guided_tour' => 'Guided Tour',
                    ])
                    ->label('Tipe Tiket'),
                Tables\Filters\SelectFilter::make('place')
                    ->relationship('place', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter Destinasi'),
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

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit'   => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
