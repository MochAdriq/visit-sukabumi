<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\MyEventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class MyEventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = '2. Event & Tiket Acara';
    protected static ?string $navigationLabel = 'Event & Acara Saya';
    protected static ?string $modelLabel = 'Event & Acara';
    protected static ?string $pluralModelLabel = 'Event & Acara Saya';
    protected static ?int $navigationSort = 1;

    public static function canCreate(): bool
    {
        return true;
    }

    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery()->withCount('tickets');
        }

        return parent::getEloquentQuery()
            ->where('user_id', $user?->id)
            ->withCount('tickets');
    }

    public static function resolveRecordRouteBinding(int | string $key): ?Model
    {
        return static::getEloquentQuery()
            ->where('id', $key)
            ->orWhere('slug', $key)
            ->first();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar Acara')
                    ->description('Lengkapi identitas, jadwal pelaksanaan, dan lokasi event.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul / Nama Acara')
                            ->placeholder('Contoh: Festival Geopark Ciletuh 2026')
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Forms\Set $set, ?string $state) {
                                if ($state) {
                                    $set('slug', Str::slug($state));
                                }
                            }),

                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->label('URL Slug')
                            ->helperText('Otomatis dibuat dari nama acara. Digunakan untuk tautan publik.'),

                        Forms\Components\DateTimePicker::make('start_date')
                            ->required()
                            ->native(false)
                            ->label('Waktu Mulai Acara'),

                        Forms\Components\DateTimePicker::make('end_date')
                            ->nullable()
                            ->native(false)
                            ->after('start_date')
                            ->label('Waktu Selesai Acara (Opsional)'),

                        Forms\Components\TextInput::make('location_name')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Pantai Palabuhanratu, Sukabumi')
                            ->label('Nama Lokasi / Venue Acara'),

                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Publikasikan Acara di Portal')
                            ->helperText('Jika aktif, acara akan tampil di katalog event publik Visit Sukabumi.'),
                    ]),

                Forms\Components\Section::make('Media & Deskripsi')
                    ->columns(2)
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('events')
                            ->imageEditor()
                            ->required()
                            ->columnSpanFull()
                            ->label('Banner / Poster Resmi Acara')
                            ->helperText('Gunakan gambar landscape berkualitas tinggi untuk banner halaman event.'),

                        Forms\Components\TextInput::make('youtube_url')
                            ->maxLength(255)
                            ->label('Link Video Teaser YouTube (Opsional)')
                            ->placeholder('https://www.youtube.com/watch?v=... atau https://youtu.be/...'),

                        Forms\Components\TextInput::make('video_title')
                            ->maxLength(255)
                            ->label('Judul Video Teaser')
                            ->placeholder('Default: Teaser & Highlight Acara'),

                        Forms\Components\RichEditor::make('description')
                            ->required()
                            ->columnSpanFull()
                            ->label('Deskripsi Lengkap Acara')
                            ->placeholder('Jelaskan daya tarik acara, pengisi acara, dan informasi penting lainnya...'),
                    ]),

                Forms\Components\Section::make('Kategori Tiket & Kuota Penjualan')
                    ->description('Atur jenis tiket yang dapat dibeli oleh wisatawan secara online.')
                    ->schema([
                        Forms\Components\Repeater::make('tickets')
                            ->relationship('tickets')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nama Kategori Tiket')
                                    ->placeholder('Contoh: Tiket Reguler, Tiket VIP Front Row'),

                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Harga Tiket Satuan')
                                    ->helperText('Pajak & Biaya Layanan (10%) dihitung otomatis oleh sistem.'),

                                Forms\Components\TextInput::make('quota')
                                    ->required()
                                    ->numeric()
                                    ->label('Total Kuota Tiket')
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function (Forms\Set $set, Forms\Get $get, ?int $state) {
                                        if (!$get('available_quota') && $state) {
                                            $set('available_quota', $state);
                                        }
                                    }),

                                Forms\Components\TextInput::make('available_quota')
                                    ->numeric()
                                    ->label('Sisa Kuota Tersedia')
                                    ->helperText('Otomatis berkurang saat tiket dibeli oleh pengunjung.'),

                                Forms\Components\Toggle::make('is_active')
                                    ->default(true)
                                    ->label('Buka Penjualan Tiket'),

                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull()
                                    ->rows(2)
                                    ->nullable()
                                    ->label('Fasilitas & Keterangan Tiket')
                                    ->placeholder('Contoh: Termasuk welcome drink, akses baris depan panggung, dan merchandise resmi.'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('+ Tambah Kategori Tiket')
                            ->reorderable(false)
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Rundown / Itinerary Acara')
                    ->description('Jadwal dan susunan kegiatan acara agar pengunjung mengetahui rundown.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Repeater::make('itineraries')
                            ->relationship('itineraries')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->label('Nama Sesi / Agenda')
                                    ->placeholder('Contoh: Penampilan Musik Etnik Pembuka'),

                                Forms\Components\TextInput::make('duration_text')
                                    ->nullable()
                                    ->label('Waktu / Durasi')
                                    ->placeholder('Contoh: 09:00 - 10:30 WIB'),

                                Forms\Components\FileUpload::make('image_path')
                                    ->image()
                                    ->directory('itineraries')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->label('Foto Sesi (Opsional)'),

                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull()
                                    ->rows(2)
                                    ->nullable()
                                    ->label('Keterangan Singkat Sesi'),
                            ])
                            ->orderColumn('order_num')
                            ->reorderable('order_num')
                            ->addActionLabel('+ Tambah Sesi Rundown')
                            ->columns(2)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('')
                    ->square()
                    ->size(50),

                Tables\Columns\TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->label('Nama Acara'),

                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Waktu Acara'),

                Tables\Columns\TextColumn::make('location_name')
                    ->searchable()
                    ->label('Lokasi'),

                Tables\Columns\TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->badge()
                    ->color('info')
                    ->label('Kategori Tiket'),

                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Status Aktif'),
            ])
            ->defaultSort('start_date', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Publikasi')
                    ->trueLabel('Aktif Dipublikasikan')
                    ->falseLabel('Nonaktif / Draf'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view_page')
                    ->label('Lihat Halaman')
                    ->icon('heroicon-o-arrow-top-right-on-square')
                    ->url(fn (Event $record) => url('/event/' . $record->slug))
                    ->openUrlInNewTab(),
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
            'index'  => Pages\ListMyEvents::route('/'),
            'create' => Pages\CreateMyEvent::route('/create'),
            'edit'   => Pages\EditMyEvent::route('/{record}/edit'),
        ];
    }
}
