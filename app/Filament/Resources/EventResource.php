<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EventResource\Pages;
use App\Models\Event;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class EventResource extends Resource
{
    protected static ?string $model = Event::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';
    protected static ?string $navigationGroup = 'Event & Trip';
    protected static ?string $modelLabel = 'Event';
    protected static ?string $pluralModelLabel = 'Event & Trip';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Dasar Event')
                    ->columns(2)
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul Event')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(Forms\Set $set, ?string $state) => $set('slug', \Illuminate\Support\Str::slug($state))),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->label('Slug (URL)'),
                        Forms\Components\DateTimePicker::make('start_date')
                            ->required()
                            ->label('Tanggal Mulai'),
                        Forms\Components\DateTimePicker::make('end_date')
                            ->nullable()
                            ->label('Tanggal Selesai')
                            ->after('start_date'),
                        Forms\Components\TextInput::make('location_name')
                            ->nullable()
                            ->maxLength(255)
                            ->columnSpanFull()
                            ->label('Nama Lokasi'),
                        Forms\Components\Toggle::make('is_active')
                            ->default(true)
                            ->label('Aktif / Dipublikasikan'),
                    ]),

                Forms\Components\Section::make('Penyelenggara Acara / Perjalanan (Organizer)')
                    ->description('Tentukan apakah trip/event ini diselenggarakan resmi oleh tim Visit Sukabumi atau oleh mitra eksternal.')
                    ->columns(2)
                    ->schema([
                        Forms\Components\Radio::make('organizer_type')
                            ->label('Tipe Penyelenggara')
                            ->options([
                                'internal' => 'Tim Internal Visit Sukabumi (Official Trip & Event)',
                                'mitra' => 'Mitra / Event Organizer Eksternal',
                            ])
                            ->default('internal')
                            ->inline()
                            ->live()
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('organizer_name')
                            ->label('Label Penyelenggara')
                            ->placeholder('Contoh: Visit Sukabumi Official')
                            ->default('Visit Sukabumi Official')
                            ->helperText('Nama yang tampil di halaman publik sebagai penyelenggara acara.'),

                        Forms\Components\Select::make('user_id')
                            ->label('Email Akun Pengelola (Mitra / EO)')
                            ->visible(fn(Forms\Get $get) => $get('organizer_type') === 'mitra')
                            ->required(fn(Forms\Get $get) => $get('organizer_type') === 'mitra')
                            ->relationship('user', 'email')
                            ->getOptionLabelFromRecordUsing(fn($record) => "{$record->name} ({$record->email})")
                            ->searchable(['name', 'email'])
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->label('Nama Pengelola / EO'),
                                Forms\Components\TextInput::make('email')
                                    ->required()
                                    ->email()
                                    ->unique('users', 'email')
                                    ->label('Email Akun'),
                                Forms\Components\TextInput::make('phone')
                                    ->tel()
                                    ->label('No. WhatsApp (Opsional)'),
                                Forms\Components\Hidden::make('password')
                                    ->default(fn() => bcrypt(\Illuminate\Support\Str::random(16))),
                            ])
                            ->createOptionModalHeading('Daftarkan Akun Pengelola Baru')
                            ->helperText('Ketika pengguna dengan email ini login, event ini otomatis dapat dikelola di portal /kelola miliknya.'),
                    ]),

                Forms\Components\Section::make('Kategori Tiket & Kuota Acara')
                    ->description('Atur jenis tiket dan tarif yang dapat dipesan wisatawan secara online.')
                    ->schema([
                        Forms\Components\Repeater::make('tickets')
                            ->relationship('tickets')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->label('Nama Kategori Tiket')
                                    ->placeholder('Contoh: Tiket Reguler, VIP Front Row'),

                                Forms\Components\TextInput::make('price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('Rp')
                                    ->label('Harga Tiket Satuan'),

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
                                    ->label('Sisa Kuota Tersedia'),

                                Forms\Components\Toggle::make('is_active')
                                    ->default(true)
                                    ->label('Buka Penjualan'),

                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull()
                                    ->rows(2)
                                    ->nullable()
                                    ->label('Fasilitas / Keterangan Tiket'),
                            ])
                            ->columns(2)
                            ->defaultItems(1)
                            ->addActionLabel('+ Tambah Kategori Tiket')
                            ->columnSpanFull(),
                    ]),

                Forms\Components\Section::make('Gambar & Deskripsi')
                    ->schema([
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->directory('events')
                            ->imageEditor()
                            ->nullable()
                            ->label('Gambar Utama Event'),
                        Forms\Components\TextInput::make('youtube_url')
                            ->maxLength(255)
                            ->label('Link Video YouTube (Opsional)')
                            ->placeholder('Contoh: https://www.youtube.com/watch?v=E4WlUXrJgy4 atau https://youtu.be/...')
                            ->helperText('Tempel URL YouTube lengkap, pendek, ataupun shorts. Video player embed akan otomatis ditampilkan di halaman detail event.'),
                        Forms\Components\TextInput::make('video_title')
                            ->maxLength(255)
                            ->label('Judul Video (Opsional)')
                            ->placeholder('Default: Video Dokumentasi & Teaser')
                            ->helperText('Judul kustom yang tampil di atas video (contoh: "Aftermovie & Highlight Acara"). Jika dikosongkan, akan otomatis menggunakan default "Video Dokumentasi & Teaser".'),
                        Forms\Components\RichEditor::make('description')
                            ->nullable()
                            ->label('Deskripsi Event'),
                    ]),

                Forms\Components\Section::make('Detail Event (Tripadvisor Style)')
                    ->description('Isi bagian-bagian ini agar tampil di halaman detail event sebagai accordion interaktif.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\RichEditor::make('whats_included')
                            ->label("Apa yang Termasuk (What's included)")
                            ->columnSpanFull()
                            ->nullable(),
                        Forms\Components\RichEditor::make('what_to_expect')
                            ->label('Apa yang Akan Didapat (What to expect)')
                            ->columnSpanFull()
                            ->nullable(),
                        Forms\Components\RichEditor::make('meeting_and_pickup')
                            ->label('Titik Kumpul & Penjemputan (Meeting and pickup)')
                            ->columnSpanFull()
                            ->nullable(),
                        Forms\Components\RichEditor::make('cancellation_policy')
                            ->label('Kebijakan Pembatalan (Cancellation policy)')
                            ->columnSpanFull()
                            ->nullable(),
                    ]),

                Forms\Components\Section::make('Itinerary Perjalanan')
                    ->description('Tambahkan titik-titik perjalanan. Sertakan koordinat agar muncul di peta interaktif.')
                    ->collapsed()
                    ->schema([
                        Forms\Components\Repeater::make('itineraries')
                            ->relationship()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->label('Nama Lokasi / Aktivitas')
                                    ->placeholder('Contoh: Puncak Darma'),
                                Forms\Components\TextInput::make('duration_text')
                                    ->placeholder('Contoh: Stop: 2 hours — Admission included')
                                    ->nullable()
                                    ->label('Keterangan Durasi'),
                                Forms\Components\TextInput::make('latitude')
                                    ->numeric()
                                    ->nullable()
                                    ->placeholder('-6.9175')
                                    ->label('Latitude'),
                                Forms\Components\TextInput::make('longitude')
                                    ->numeric()
                                    ->nullable()
                                    ->placeholder('106.9236')
                                    ->label('Longitude'),
                                Forms\Components\FileUpload::make('image_path')
                                    ->image()
                                    ->directory('itineraries')
                                    ->nullable()
                                    ->columnSpanFull()
                                    ->label('Foto Titik Ini'),
                                Forms\Components\Textarea::make('description')
                                    ->columnSpanFull()
                                    ->nullable()
                                    ->rows(2)
                                    ->label('Deskripsi Singkat'),
                            ])
                            ->orderColumn('order_num')
                            ->reorderable('order_num')
                            ->addActionLabel('+ Tambah Titik Itinerary')
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
                    ->label('Judul Event'),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->label('Tanggal Mulai'),
                Tables\Columns\TextColumn::make('location_name')
                    ->searchable()
                    ->label('Lokasi'),
                Tables\Columns\TextColumn::make('organizer_name')
                    ->label('Penyelenggara')
                    ->formatStateUsing(fn(Event $record) => $record->organizer_name ?: ($record->isInternalOrganizer() ? 'Official Internal' : ($record->user?->name ?? 'Mitra')))
                    ->description(fn(Event $record) => $record->isInternalOrganizer() ? 'Visit Sukabumi' : ($record->user?->email ?? '-'))
                    ->searchable(),
                Tables\Columns\TextColumn::make('tickets_count')
                    ->counts('tickets')
                    ->badge()
                    ->color('info')
                    ->label('Tiket'),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->label('Aktif'),
                Tables\Columns\TextColumn::make('itineraries_count')
                    ->counts('itineraries')
                    ->badge()
                    ->color('primary')
                    ->label('Itinerary'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_date', 'asc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\Action::make('view')
                    ->label('Lihat')
                    ->icon('heroicon-o-eye')
                    ->url(fn(Event $record) => url('/event/' . $record->slug))
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
            'index'  => Pages\ListEvents::route('/'),
            'create' => Pages\CreateEvent::route('/create'),
            'edit'   => Pages\EditEvent::route('/{record}/edit'),
        ];
    }
}
