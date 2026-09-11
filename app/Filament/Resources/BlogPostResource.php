<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BlogPostResource\Pages;
use App\Models\BlogPost;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

class BlogPostResource extends Resource
{
    protected static ?string $model = BlogPost::class;
    protected static ?string $navigationIcon = 'heroicon-o-document-text';
    protected static ?string $navigationGroup = 'Konten Publikasi';
    protected static ?string $modelLabel = 'Artikel Blog';
    protected static ?string $pluralModelLabel = 'Artikel Blog';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Konten Utama')
                    ->schema([
                        Forms\Components\TextInput::make('title')
                            ->required()
                            ->maxLength(255)
                            ->label('Judul Artikel')
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn ($state, callable $set) =>
                                $set('slug', Str::slug($state))
                            ),
                        Forms\Components\TextInput::make('slug')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->label('Slug (URL)'),
                        Forms\Components\RichEditor::make('content')
                            ->required()
                            ->label('Isi Artikel')
                            ->fileAttachmentsDisk('public')
                            ->fileAttachmentsVisibility('public')
                            ->fileAttachmentsDirectory('blog_attachments')
                            ->columnSpanFull(),
                    ]),
            ])->columnSpan(['lg' => 2]),

            Forms\Components\Group::make()->schema([
                Forms\Components\Section::make('Meta & Status')
                    ->schema([
                        Forms\Components\Select::make('status')
                            ->options([
                                'draft' => 'Draft',
                                'published' => 'Published',
                            ])
                            ->required()
                            ->default('draft')
                            ->label('Status Publikasi')
                            ->live()
                            ->afterStateUpdated(function ($state, callable $set, callable $get) {
                                if ($state === 'published' && ! $get('published_at')) {
                                    $set('published_at', now()->format('Y-m-d H:i:s'));
                                }
                            }),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Tanggal & Waktu Terbit')
                            ->nullable()
                            ->helperText('Otomatis terisi saat status Published, atau bisa diatur manual.'),
                        Forms\Components\Select::make('category')
                            ->options([
                                'Panduan Wisata' => 'Panduan Wisata',
                                'Berita' => 'Berita',
                                'Tips & Trik' => 'Tips & Trik',
                                'Kuliner' => 'Kuliner',
                            ])
                            ->required()
                            ->default('Panduan Wisata')
                            ->label('Kategori'),
                        Forms\Components\Select::make('author_id')
                            ->relationship(
                                name: 'author',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn (Builder $query, ?BlogPost $record) => 
                                    $query->where('role', 'admin')
                                          ->when($record?->author_id, fn ($q, $authorId) => $q->orWhere('id', $authorId))
                            )
                            ->default(fn () => auth()->id())
                            ->searchable()
                            ->preload()
                            ->label('Akun Penulis (Admin)')
                            ->helperText('Hanya akun dengan peran Admin yang dapat dipilih sebagai penulis resmi.'),
                        Forms\Components\TextInput::make('author_name')
                            ->label('Nama Penulis Kustom (Opsional)')
                            ->placeholder('Contoh: Tim Redaksi Visit Sukabumi')
                            ->maxLength(255)
                            ->helperText('Jika diisi, nama ini yang akan tampil di website menggantikan nama akun.'),
                        Forms\Components\FileUpload::make('image_path')
                            ->image()
                            ->imageEditor()
                            ->directory('blog')
                            ->label('Thumbnail Artikel'),
                    ]),
            ])
                ->columnSpan(['lg' => 1])
                ->extraAttributes(['class' => 'lg:sticky lg:top-20 lg:self-start']),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Thumbnail')
                    ->square(),
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->weight('bold')
                    ->limit(50),
                Tables\Columns\TextColumn::make('category')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'draft',
                        'success' => 'published',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('author_display')
                    ->label('Penulis')
                    ->getStateUsing(fn (BlogPost $record) => $record->author_display_name)
                    ->searchable(query: function ($query, $search) {
                        return $query->where('author_name', 'like', "%{$search}%")
                            ->orWhereHas('author', fn ($q) => $q->where('name', 'like', "%{$search}%"));
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('published_at')
                    ->label('Tanggal Terbit')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'draft' => 'Draft',
                        'published' => 'Published',
                    ]),
                Tables\Filters\SelectFilter::make('category')
                    ->options([
                        'Panduan Wisata' => 'Panduan Wisata',
                        'Berita' => 'Berita',
                        'Tips & Trik' => 'Tips & Trik',
                        'Kuliner' => 'Kuliner',
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBlogPosts::route('/'),
            'create' => Pages\CreateBlogPost::route('/create'),
            'edit' => Pages\EditBlogPost::route('/{record}/edit'),
        ];
    }
}
