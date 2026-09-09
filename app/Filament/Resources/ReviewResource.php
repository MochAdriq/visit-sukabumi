<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ReviewResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ReviewResource extends Resource
{
    protected static ?string $model = Review::class;

    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-ellipsis';
    protected static ?string $navigationGroup = 'Interaksi Pengguna';
    protected static ?string $modelLabel = 'Ulasan';
    protected static ?string $pluralModelLabel = 'Ulasan';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Ulasan')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->relationship('user', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Pengguna'),
                        Forms\Components\Select::make('place_id')
                            ->relationship('place', 'name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->label('Destinasi'),
                        Forms\Components\Select::make('rating')
                            ->options([
                                1 => '⭐ 1 — Sangat Buruk',
                                2 => '⭐⭐ 2 — Buruk',
                                3 => '⭐⭐⭐ 3 — Cukup',
                                4 => '⭐⭐⭐⭐ 4 — Bagus',
                                5 => '⭐⭐⭐⭐⭐ 5 — Luar Biasa',
                            ])
                            ->required()
                            ->label('Rating'),
                        Forms\Components\Select::make('visit_type')
                            ->options([
                                'solo'     => 'Solo / Sendiri',
                                'couple'   => 'Pasangan',
                                'family'   => 'Keluarga',
                                'friends'  => 'Bersama Teman',
                                'business' => 'Bisnis / Rombongan',
                            ])
                            ->nullable()
                            ->label('Tipe Kunjungan'),
                        Forms\Components\Textarea::make('content')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull()
                            ->label('Isi Ulasan'),
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('reviews')
                            ->nullable()
                            ->columnSpanFull()
                            ->label('Foto Lampiran'),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->searchable()
                    ->sortable()
                    ->label('Pengguna'),
                Tables\Columns\TextColumn::make('place.name')
                    ->searchable()
                    ->sortable()
                    ->label('Destinasi'),
                Tables\Columns\TextColumn::make('rating')
                    ->badge()
                    ->color(fn(int $state): string => match (true) {
                        $state >= 4 => 'success',
                        $state === 3 => 'warning',
                        default     => 'danger',
                    })
                    ->formatStateUsing(fn(int $state) => str_repeat('⭐', $state))
                    ->sortable()
                    ->label('Rating'),
                Tables\Columns\TextColumn::make('content')
                    ->limit(60)
                    ->tooltip(fn($record) => $record->content)
                    ->label('Isi Ulasan'),
                Tables\Columns\TextColumn::make('visit_type')
                    ->badge()
                    ->color('gray')
                    ->label('Tipe'),
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->since()
                    ->label('Diposting'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('rating')
                    ->options([
                        1 => '⭐ 1',
                        2 => '⭐⭐ 2',
                        3 => '⭐⭐⭐ 3',
                        4 => '⭐⭐⭐⭐ 4',
                        5 => '⭐⭐⭐⭐⭐ 5',
                    ])
                    ->label('Filter Rating'),
                Tables\Filters\SelectFilter::make('place')
                    ->relationship('place', 'name')
                    ->searchable()
                    ->preload()
                    ->label('Filter Destinasi'),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
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
            'index'  => Pages\ListReviews::route('/'),
            'create' => Pages\CreateReview::route('/create'),
            'edit'   => Pages\EditReview::route('/{record}/edit'),
        ];
    }
}
