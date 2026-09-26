<?php

namespace App\Filament\Kelola\Resources;

use App\Filament\Kelola\Resources\ReviewManagementResource\Pages;
use App\Models\Review;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class ReviewManagementResource extends Resource
{
    protected static ?string $model = Review::class;
    protected static ?string $navigationIcon = 'heroicon-o-chat-bubble-left-right';
    protected static ?string $navigationGroup = '5. Ulasan & Reputasi';
    protected static ?string $navigationLabel = 'Ulasan Wisatawan';
    protected static ?string $modelLabel = 'Ulasan';
    protected static ?string $pluralModelLabel = 'Ulasan Wisatawan';
    protected static ?int $navigationSort = 1;

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()?->hasPlaceAccess() ?? false;
    }

    /**
     * Hanya tampilkan ulasan untuk destinasi yang dimiliki pengelola ini.
     */
    public static function getEloquentQuery(): Builder
    {
        $user = Auth::user();

        if ($user && $user->role === 'admin') {
            return parent::getEloquentQuery()->with(['user', 'place']);
        }

        $placeIds = $user ? $user->ownedPlaces()->pluck('id') : collect();

        return parent::getEloquentQuery()
            ->whereIn('place_id', $placeIds)
            ->with(['user', 'place']);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Wisatawan')
                    ->weight('bold')
                    ->searchable(),
                Tables\Columns\TextColumn::make('place.name')
                    ->label('Destinasi')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rating')
                    ->label('Rating')
                    ->formatStateUsing(fn ($state) => str_repeat('★', (int) $state) . str_repeat('☆', 5 - (int) $state))
                    ->color('warning')
                    ->weight('bold'),
                Tables\Columns\TextColumn::make('content')
                    ->label('Isi Ulasan')
                    ->limit(80)
                    ->wrap(),
                Tables\Columns\BadgeColumn::make('official_response')
                    ->label('Status Balasan')
                    ->getStateUsing(fn ($record) => $record->official_response ? 'Sudah dibalas' : 'Belum dibalas')
                    ->colors([
                        'success' => 'Sudah dibalas',
                        'gray'    => 'Belum dibalas',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('belum_dibalas')
                    ->label('Belum Dibalas')
                    ->query(fn (Builder $query) => $query->whereNull('official_response')),
                Tables\Filters\SelectFilter::make('rating')
                    ->label('Filter Rating')
                    ->options([
                        '5' => '5 Bintang (Sempurna)',
                        '4' => '4 Bintang (Sangat Baik)',
                        '3' => '3 Bintang (Cukup)',
                        '2' => '2 Bintang (Kurang)',
                        '1' => '1 Bintang (Buruk)',
                    ]),
            ])
            ->actions([
                Action::make('balas')
                    ->label('Balas Ulasan')
                    ->icon('heroicon-o-chat-bubble-oval-left')
                    ->color('primary')
                    ->form([
                        Forms\Components\Textarea::make('official_response')
                            ->label('Respons Resmi Pengelola')
                            ->placeholder('Tulis tanggapan Anda kepada wisatawan...')
                            ->required()
                            ->rows(4)
                            ->default(fn (Review $record) => $record->official_response),
                    ])
                    ->action(function (Review $record, array $data) {
                        $record->update([
                            'official_response'    => $data['official_response'],
                            'official_responded_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Respons berhasil disimpan!')
                            ->body('Tanggapan Anda akan tampil di halaman destinasi.')
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListReviewManagement::route('/'),
        ];
    }
}
