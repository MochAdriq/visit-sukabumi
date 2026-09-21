<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxSettingResource\Pages;
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
    protected static ?string $navigationGroup = '3. Kebijakan & Rekening';
    protected static ?string $navigationLabel = 'Tarif Pajak Daerah (PBJT)';
    protected static ?string $modelLabel = 'Tarif Pajak (PBJT)';
    protected static ?string $pluralModelLabel = 'Pengaturan Tarif Pajak (PBJT)';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('Nama Pajak Daerah')
                    ->required()
                    ->placeholder('e.g. PBJT Jasa Perhotelan'),

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
                    ->label('Dasar Hukum / Peraturan Daerah')
                    ->placeholder('e.g. Sesuai UU HKPD No. 1 Tahun 2022')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Pajak')
                    ->weight('bold')
                    ->searchable(),

                Tables\Columns\BadgeColumn::make('category')
                    ->label('Kategori')
                    ->colors([
                        'primary' => 'hotel',
                        'warning' => 'event',
                        'success' => 'attraction',
                    ])
                    ->formatStateUsing(fn(string $state): string => strtoupper($state)),

                Tables\Columns\TextColumn::make('rate_percent')
                    ->label('Tarif Pajak')
                    ->formatStateUsing(fn($state) => "{$state}%")
                    ->weight('bold')
                    ->color('primary'),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Status Aktif'),

                Tables\Columns\TextColumn::make('description')
                    ->label('Dasar Hukum')
                    ->limit(40),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxSettings::route('/'),
        ];
    }
}
