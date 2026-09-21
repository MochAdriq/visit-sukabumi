<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RkudAccountResource\Pages;
use App\Models\RkudAccount;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RkudAccountResource extends Resource
{
    protected static ?string $model = RkudAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-library';
    protected static ?string $navigationGroup = '3. Kebijakan & Rekening';
    protected static ?string $navigationLabel = 'Rekening Kas Daerah (RKUD)';
    protected static ?string $modelLabel = 'Rekening Kas Daerah';
    protected static ?string $pluralModelLabel = 'Rekening Kas Daerah (RKUD)';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('bank_name')
                    ->label('Nama Bank Resmi')
                    ->required()
                    ->placeholder('e.g. Bank BJB'),

                Forms\Components\TextInput::make('account_number')
                    ->label('Nomor Rekening RKUD')
                    ->required()
                    ->placeholder('e.g. 0012345678901'),

                Forms\Components\TextInput::make('account_holder_name')
                    ->label('Nama Pemilik Rekening')
                    ->required()
                    ->placeholder('e.g. KAS DAERAH KABUPATEN SUKABUMI'),

                Forms\Components\TextInput::make('agency_name')
                    ->label('Instansi Pengelola')
                    ->default('Badan Pendapatan Daerah (Bapenda)')
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Rekening Utama / Aktif')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('bank_name')
                    ->label('Bank')
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('account_number')
                    ->label('Nomor Rekening')
                    ->fontFamily('mono')
                    ->copyable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('account_holder_name')
                    ->label('Nama Rekening')
                    ->searchable(),

                Tables\Columns\TextColumn::make('agency_name')
                    ->label('Instansi'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRkudAccounts::route('/'),
        ];
    }
}
