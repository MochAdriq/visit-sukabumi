<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-video-camera';
    protected static ?string $navigationGroup = 'Konten Publikasi';
    protected static ?string $modelLabel = 'Video Galeri';
    protected static ?string $pluralModelLabel = 'Galeri Video';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Video & Sumber YouTube')
                    ->description('Masukkan judul dan link YouTube. Sistem otomatis mengekstrak ID video dan menghasilkan thumbnail.')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->label('Judul Video')
                            ->placeholder('Contoh: Keindahan Eksotis Geopark Ciletuh UNESCO')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('youtube_url')
                            ->label('Tautan Video YouTube / Shorts')
                            ->placeholder('https://www.youtube.com/watch?v=... atau https://youtu.be/...')
                            ->helperText('Mendukung format youtube.com, youtu.be, shorts, maupun embed.')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),

                        Forms\Components\Select::make('category')
                            ->label('Kategori')
                            ->options([
                                'Wisata Alam'   => 'Wisata Alam & Geopark',
                                'Budaya & Event'=> 'Budaya & Event',
                                'Kuliner'       => 'Kuliner Khas Sukabumi',
                                'Dokumentasi'   => 'Dokumentasi Resmi & Profil',
                            ])
                            ->default('Wisata Alam')
                            ->required(),

                        Forms\Components\TextInput::make('duration')
                            ->label('Durasi Video (Opsional)')
                            ->placeholder('Contoh: 04:20 atau 15 Menit')
                            ->maxLength(32),

                        Forms\Components\Textarea::make('description')
                            ->label('Deskripsi / Sinopsis Singkat')
                            ->placeholder('Jelaskan secara singkat isi dan daya tarik video ini...')
                            ->rows(3)
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Pengaturan Penayangan & Visibilitas')
                    ->schema([
                        Forms\Components\Toggle::make('is_featured')
                            ->label('Tampilkan di Beranda (Featured Video)')
                            ->helperText('Jika diaktifkan, video ini diprioritaskan tampil di section Beranda.')
                            ->default(false),

                        Forms\Components\Toggle::make('is_active')
                            ->label('Status Aktif / Ditayangkan')
                            ->helperText('Nonaktifkan jika video ingin disembunyikan dari publik.')
                            ->default(true),

                        Forms\Components\TextInput::make('sort_order')
                            ->label('Urutan Tampil (Sort Order)')
                            ->numeric()
                            ->default(0)
                            ->helperText('Angka lebih kecil tampil lebih awal (prioritas tinggi).'),
                    ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail_url')
                    ->label('Thumbnail')
                    ->square()
                    ->height(45)
                    ->width(75),

                Tables\Columns\TextColumn::make('title')
                    ->label('Judul Video')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->wrap(),

                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Wisata Alam'   => 'success',
                        'Budaya & Event'=> 'warning',
                        'Kuliner'       => 'danger',
                        default         => 'info',
                    })
                    ->sortable(),

                Tables\Columns\TextColumn::make('duration')
                    ->label('Durasi')
                    ->placeholder('-'),

                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Featured')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Dibuat')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('sort_order', 'asc')
            ->filters([
                Tables\Filters\SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Wisata Alam'   => 'Wisata Alam & Geopark',
                        'Budaya & Event'=> 'Budaya & Event',
                        'Kuliner'       => 'Kuliner',
                        'Dokumentasi'   => 'Dokumentasi Resmi',
                    ]),

                Tables\Filters\TernaryFilter::make('is_featured')
                    ->label('Featured Beranda'),

                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif'),
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
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'edit'   => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
