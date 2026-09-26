<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\RkudAccountResource\Pages;
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
    protected static ?string $navigationGroup = '3. Kebijakan & Rekening Kasda';
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
                    ->placeholder('Contoh: Bank BJB'),

                Forms\Components\TextInput::make('account_number')
                    ->label('Nomor Rekening RKUD')
                    ->required()
                    ->placeholder('Contoh: 0012345678901'),

                Forms\Components\TextInput::make('account_holder_name')
                    ->label('Nama Pemilik Rekening')
                    ->required()
                    ->placeholder('Contoh: KAS DAERAH KABUPATEN SUKABUMI'),

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
                    ->copyable(),

                Tables\Columns\TextColumn::make('account_holder_name')
                    ->label('Nama Rekening'),

                Tables\Columns\TextColumn::make('agency_name')
                    ->label('Instansi Pengelola')
                    ->badge(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRkudAccounts::route('/'),
            'create' => Pages\CreateRkudAccount::route('/create'),
            'edit' => Pages\EditRkudAccount::route('/{record}/edit'),
        ];
    }
}
