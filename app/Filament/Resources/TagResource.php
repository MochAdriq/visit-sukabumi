<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Data Master';
    protected static ?string $modelLabel = 'Tag';
    protected static ?string $pluralModelLabel = 'Tag';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form->schema([

            Forms\Components\Section::make('Informasi Tag')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->maxLength(100)
                        ->label('Nama Tag')
                        ->live(onBlur: true)
                        ->afterStateUpdated(fn ($state, callable $set) =>
                            $set('slug', Str::slug($state))
                        ),

                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(100)
                        ->unique(ignoreRecord: true)
                        ->label('Slug (URL)')
                        ->helperText('Otomatis dari nama, bisa diedit manual'),

                    Forms\Components\Select::make('type')
                        ->required()
                        ->options([
                            'activity' => 'Apa yang Bisa Dilakukan (Aktivitas)',
                            'wisata'   => 'Wisata',
                        ])
                        ->label('Tipe Menu')
                        ->helperText('Menentukan di menu navbar mana tag ini muncul'),

                    Forms\Components\TextInput::make('sort_order')
                        ->numeric()
                        ->default(0)
                        ->label('Urutan Tampil')
                        ->helperText('Angka lebih kecil = tampil lebih awal'),

                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull()
                        ->rows(3)
                        ->label('Deskripsi')
                        ->helperText('Ditampilkan di halaman listing tag'),

                    Forms\Components\Textarea::make('icon_svg')
                        ->columnSpanFull()
                        ->rows(2)
                        ->label('Ikon SVG (path)')
                        ->helperText('Paste SVG path element dari Heroicons atau sumber lain (tanpa tag <svg> wrapper)'),
                ]),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('#')
                    ->sortable()
                    ->width(50),

                Tables\Columns\TextColumn::make('name')
                    ->label('Nama Tag')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\BadgeColumn::make('type')
                    ->label('Tipe')
                    ->colors([
                        'success' => 'activity',
                        'info'    => 'wisata',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'activity' => 'Aktivitas',
                        'wisata'   => 'Wisata',
                        default    => ucfirst($state),
                    }),

                Tables\Columns\TextColumn::make('places_count')
                    ->label('Jumlah Place')
                    ->counts('places')
                    ->sortable()
                    ->badge()
                    ->color('gray'),

                Tables\Columns\TextColumn::make('slug')
                    ->label('Slug')
                    ->copyable()
                    ->color('gray')
                    ->size('sm'),

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable(),
            ])
            ->defaultSort('type')
            ->filters([
                Tables\Filters\SelectFilter::make('type')
                    ->label('Tipe')
                    ->options([
                        'activity' => 'Aktivitas',
                        'wisata'   => 'Wisata',
                    ]),
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

    public static function getRelationManagers(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit'   => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}
