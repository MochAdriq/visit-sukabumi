<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\TaxSettingResource\Pages;
use App\Models\TaxSetting;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaxSettingResource extends Resource
{
    protected static ?string $model = TaxSetting::class;

    protected static ?string $navigationIcon = 'heroicon-o-scale';
    protected static ?string $navigationGroup = '3. Kebijakan & Rekening Kasda';
    protected static ?string $navigationLabel = 'Tarif Pajak Daerah (PBJT)';
    protected static ?string $modelLabel = 'Tarif Pajak (PBJT)';
    protected static ?string $pluralModelLabel = 'Tarif Pajak Daerah (PBJT)';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pajak Daerah')
                    ->required()
                    ->placeholder('Contoh: PBJT Jasa Perhotelan'),

                Forms\Components\Select::make('category')
                    ->label('Kategori Sektor')
                    ->options([
                        'hotel' => 'Perhotelan & Akomodasi',
                        'event' => 'Kesenian, Musik & Hiburan',
                        'attraction' => 'Wisata & Rekreasi',
                    ])
                    ->required(),

                Forms\Components\TextInput::make('rate_percent')
                    ->label('Besaran Tarif (%)')
                    ->numeric()
                    ->suffix('%')
                    ->default(10.00)
                    ->required(),

                Forms\Components\Toggle::make('is_active')
                    ->label('Status Aktif')
                    ->default(true),

                Forms\Components\Textarea::make('description')
                    ->label('Dasar Hukum / Peraturan Daerah (Perda)')
                    ->placeholder('Contoh: Sesuai UU HKPD No. 1 Tahun 2022 dan Perda Kab. Sukabumi')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Jenis Pajak')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Sektor')
                    ->colors([
                        'primary' => 'hotel',
                        'danger' => 'event',
                        'success' => 'attraction',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'hotel' => 'PERHOTELAN',
                        'event' => 'HIBURAN / EVENT',
                        'attraction' => 'WISATA & REKREASI',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('rate_percent')
                    ->label('Tarif Pajak')
                    ->formatStateUsing(fn($state) => "{$state}%")
                    ->weight('black')
                    ->color('success'),

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
            'index' => Pages\ListTaxSettings::route('/'),
            'create' => Pages\CreateTaxSetting::route('/create'),
            'edit' => Pages\EditTaxSetting::route('/{record}/edit'),
        ];
    }
}
