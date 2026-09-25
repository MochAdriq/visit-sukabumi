<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AdvertisementResource\Pages;
use App\Filament\Resources\AdvertisementResource\RelationManagers;
use App\Models\Advertisement;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AdvertisementResource extends Resource
{
    protected static ?string $model = Advertisement::class;

    protected static ?string $navigationIcon = 'heroicon-o-megaphone';
    protected static ?string $navigationGroup = 'Marketing';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Format & Informasi Banner')
                    ->description('Tentukan format orientasi banner (Landscape atau Portrait). Sistem akan otomatis merandom penayangannya di slot yang sesuai.')
                    ->schema([
                        Forms\Components\Radio::make('format')
                            ->label('Format Orientasi Banner')
                            ->options([
                                'landscape' => 'Landscape (Horizontal)',
                                'portrait'  => 'Portrait (Vertikal)',
                            ])
                            ->descriptions([
                                'landscape' => 'Otomatis di-random untuk slot horizontal: Beranda Tengah, Artikel Blog, dan Pre-Footer.',
                                'portrait'  => 'Otomatis di-random untuk slot vertikal: Sidebar Kanan Halaman Detail Tempat Wisata.',
                            ])
                            ->default('landscape')
                            ->inline()
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('title')
                            ->label('Judul Iklan / Nama Sponsor')
                            ->placeholder('Contoh: Promo Glamping Ciletuh Weekend')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\TextInput::make('url')
                            ->label('Tautan Target (URL)')
                            ->placeholder('Contoh: /jelajahsukabumi atau https://...')
                            ->helperText('Bisa menggunakan path internal (/jelajahsukabumi) atau link eksternal lengkap.')
                            ->maxLength(255),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('File Banner (Gambar / GIF Animasi)')
                            ->image()
                            ->directory('ads')
                            ->helperText('Dukung format JPG, PNG, WebP, dan GIF animasi. Gambar tidak akan di-crop/dipotong paksa, proporsi asli gambar akan dipertahankan.')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\CheckboxList::make('target_pages')
                            ->label('Target Halaman Tampil')
                            ->options([
                                'all'          => 'Semua Halaman Publik',
                                'home'         => 'Hanya di Beranda (Home)',
                                'places'       => 'Daftar Destinasi (/wisata, /aktivitas, /penginapan)',
                                'place_detail' => 'Halaman Detail Tempat (/place/{slug})',
                                'events'       => 'Event & Festival (/event)',
                                'blog'         => 'Blog & Panduan Wisata (/blog, /panduan-wisata)',
                            ])
                            ->default(['all'])
                            ->columns(2)
                            ->helperText('Pilih halaman yang diizinkan untuk menampilkan banner ini. Default: Semua Halaman Publik.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Prioritas')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka (0, 1, 2...), semakin awal banner diprioritaskan saat di-random.'),

                        Forms\Components\Toggle::make('open_in_new_tab')
                            ->label('Buka di Tab Baru (_blank)')
                            ->helperText('Aktifkan jika tautan mengarah ke web eksternal.')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Hanya banner aktif yang akan diikutsertakan dalam rotasi acak.')
                            ->required()
                            ->default(true),
                    ])->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Preview')
                    ->height(45),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul / Sponsor')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('format')
                    ->label('Format')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'portrait' => 'Portrait (Vertikal)',
                        default    => 'Landscape (Horizontal)',
                    })
                    ->color(fn ($state) => match($state) {
                        'portrait' => 'warning',
                        default    => 'success',
                    }),

                Tables\Columns\TextColumn::make('url')
                    ->label('URL Target')
                    ->limit(35)
                    ->searchable(),

                Tables\Columns\ToggleColumn::make('is_active')
                    ->label('Aktif')
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('format')
                    ->label('Format Orientasi')
                    ->options([
                        'landscape' => 'Landscape (Horizontal)',
                        'portrait'  => 'Portrait (Vertikal)',
                    ]),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAdvertisements::route('/'),
            'create' => Pages\CreateAdvertisement::route('/create'),
            'edit' => Pages\EditAdvertisement::route('/{record}/edit'),
        ];
    }
}
