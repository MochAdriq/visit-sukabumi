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
                Forms\Components\Section::make('Informasi Banner')
                    ->description('Kelola detail banner iklan, penempatan posisi, dan tautan tujuannya.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Iklan / Banner')
                            ->placeholder('Contoh: Jelajah Sukabumi Interaktif')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Select::make('position')
                            ->label('Posisi Penempatan')
                            ->options([
                                'top_navbar'      => 'Bar Promo di Atas Navbar (Top Ribbon)',
                                'homepage_middle' => 'Banner Utama Beranda (Tengah)',
                                'place_sidebar'   => 'Sidebar Detail Halaman Tempat',
                                'footer_banner'   => 'Banner Sponsor di Atas Footer (Pre-Footer)',
                            ])
                            ->default('homepage_middle')
                            ->required(),

                        Forms\Components\CheckboxList::make('target_pages')
                            ->label('Tampilkan di Halaman Mana Saja')
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
                            ->helperText('Pilih halaman yang diizinkan untuk menampilkan banner ini. Jika pilih "Semua Halaman Publik", banner akan muncul di seluruh halaman terkait posisi tersebut.')
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('url')
                            ->label('Tautan Target (URL)')
                            ->placeholder('Contoh: /jelajahsukabumi atau https://...')
                            ->helperText('Bisa menggunakan path internal seperti /jelajahsukabumi atau URL eksternal lengkap.')
                            ->maxLength(255),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Prioritas')
                            ->numeric()
                            ->default(0)
                            ->helperText('Semakin kecil angka (0, 1, 2...), semakin awal banner ditampilkan.'),

                        Forms\Components\FileUpload::make('image_path')
                            ->label('Gambar / GIF Banner')
                            ->image()
                            ->directory('ads')
                            ->helperText('Dukung format JPG, PNG, WebP, dan GIF animasi. Rekomendasi rasio landscape memanjang (misal 970x250).')
                            ->required()
                            ->columnSpanFull(),

                        Forms\Components\Toggle::make('open_in_new_tab')
                            ->label('Buka di Tab Baru (_blank)')
                            ->helperText('Aktifkan jika tautan mengarah ke web eksternal.')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif')
                            ->helperText('Hanya banner aktif yang akan ditampilkan kepada pengunjung.')
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
                    ->label('Judul Banner')
                    ->searchable()
                    ->sortable()
                    ->weight('bold'),

                Tables\Columns\TextColumn::make('position')
                    ->label('Posisi')
                    ->badge()
                    ->formatStateUsing(fn ($state) => match($state) {
                        'top_navbar'      => 'Atas Navbar',
                        'homepage_middle' => 'Beranda Tengah',
                        'place_sidebar'   => 'Sidebar Tempat',
                        'footer_banner'   => 'Atas Footer',
                        default           => $state ?? 'Beranda Tengah',
                    })
                    ->color(fn ($state) => match($state) {
                        'top_navbar'      => 'warning',
                        'homepage_middle' => 'success',
                        'place_sidebar'   => 'info',
                        'footer_banner'   => 'primary',
                        default           => 'gray',
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

                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Terakhir Diubah')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('position')
                    ->label('Posisi')
                    ->options([
                        'homepage_middle' => 'Beranda Tengah',
                        'place_sidebar'   => 'Sidebar Tempat',
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
