<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PlaceClaimResource\Pages;
use App\Models\PlaceClaim;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Storage;

class PlaceClaimResource extends Resource
{
    protected static ?string $model = PlaceClaim::class;
    protected static ?string $navigationIcon = 'heroicon-o-shield-check';
    protected static ?string $navigationLabel = 'Pengajuan Klaim';
    protected static ?string $modelLabel = 'Pengajuan Klaim';
    protected static ?string $pluralModelLabel = 'Pengajuan Klaim';
    protected static ?int $navigationSort = 10;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('Detail Pemohon')
                ->columns(2)
                ->schema([
                    Forms\Components\TextInput::make('user.name')
                        ->label('Nama Pemohon')
                        ->disabled(),
                    Forms\Components\TextInput::make('user.email')
                        ->label('Email')
                        ->disabled(),
                    Forms\Components\TextInput::make('applicant_phone')
                        ->label('Nomor WA Pemohon')
                        ->disabled(),
                    Forms\Components\TextInput::make('place.name')
                        ->label('Destinasi yang Diklaim')
                        ->disabled(),
                ]),

            Forms\Components\Section::make('Dokumen Pengajuan')
                ->columns(2)
                ->schema([
                    Forms\Components\ViewField::make('ktp_path')
                        ->label('Foto KTP')
                        ->view('filament.components.document-preview'),
                    Forms\Components\ViewField::make('surat_path')
                        ->label('Surat Pengelola / NIB')
                        ->view('filament.components.document-preview'),
                ]),

            Forms\Components\Section::make('Keputusan Admin')
                ->schema([
                    Forms\Components\Select::make('status')
                        ->label('Status')
                        ->options([
                            'pending'  => 'Menunggu',
                            'approved' => 'Disetujui',
                            'rejected' => 'Ditolak',
                        ])
                        ->required(),
                    Forms\Components\Textarea::make('admin_notes')
                        ->label('Catatan Admin (alasan penolakan jika ditolak)')
                        ->rows(3),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Pemohon')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('place.name')
                    ->label('Destinasi')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('applicant_phone')
                    ->label('No. WA')
                    ->copyable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'success' => 'approved',
                        'danger'  => 'rejected',
                    ])
                    ->formatStateUsing(fn ($state) => match ($state) {
                        'pending'  => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                        default    => $state,
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal Pengajuan')
                    ->dateTime('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('reviewed_at')
                    ->label('Ditinjau')
                    ->dateTime('d M Y')
                    ->placeholder('Belum ditinjau'),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending'  => 'Menunggu',
                        'approved' => 'Disetujui',
                        'rejected' => 'Ditolak',
                    ]),
            ])
            ->actions([
                // Tombol Setujui
                Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Pengajuan Klaim?')
                    ->modalDescription(fn (PlaceClaim $record) => "Destinasi \"{$record->place->name}\" akan dihubungkan ke akun {$record->user->name}. Tindakan ini akan memberikan akses Panel Mitra ke pengelola.")
                    ->visible(fn (PlaceClaim $record) => $record->status === 'pending')
                    ->action(function (PlaceClaim $record) {
                        $record->update([
                            'status'      => 'approved',
                            'reviewed_at' => now(),
                        ]);

                        // Tandai tempat sebagai sudah diklaim & set owner
                        $record->place->update([
                            'is_claimed' => true,
                            'owner_id'   => $record->user_id,
                        ]);

                        Notification::make()
                            ->title('Klaim disetujui!')
                            ->body("Akses Panel Mitra telah diberikan kepada {$record->user->name}.")
                            ->success()
                            ->send();
                    }),

                // Tombol Tolak dengan alasan
                Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->visible(fn (PlaceClaim $record) => $record->status === 'pending')
                    ->form([
                        Forms\Components\Textarea::make('admin_notes')
                            ->label('Alasan Penolakan')
                            ->placeholder('Contoh: Foto KTP tidak jelas, Surat pengelola tidak valid, dll.')
                            ->required()
                            ->rows(3),
                    ])
                    ->action(function (PlaceClaim $record, array $data) {
                        $record->update([
                            'status'      => 'rejected',
                            'admin_notes' => $data['admin_notes'],
                            'reviewed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Klaim ditolak')
                            ->body("Pemohon akan melihat alasan penolakan di halaman profil mereka.")
                            ->warning()
                            ->send();
                    }),

                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPlaceClaims::route('/'),
            'view'  => Pages\ViewPlaceClaim::route('/{record}'),
        ];
    }
}
