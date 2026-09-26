<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\TaxWithdrawalResource\Pages;
use App\Models\RkudAccount;
use App\Models\TaxLedger;
use App\Models\TaxWithdrawal;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class TaxWithdrawalResource extends Resource
{
    protected static ?string $model = TaxWithdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = '1. Pendapatan Daerah (PAD)';
    protected static ?string $navigationLabel = 'Penyetoran Kasda (RKUD)';
    protected static ?string $modelLabel = 'Penyetoran Pajak';
    protected static ?string $pluralModelLabel = 'Penyetoran Kas Daerah';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $availableEscrow = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');

        return $form
            ->schema([
                Forms\Components\Section::make('Informasi Rekening Kas Daerah (RKUD)')
                    ->schema([
                        Forms\Components\Placeholder::make('escrow_info')
                            ->label('Saldo Pajak Siap Setor (Escrow)')
                            ->content(fn() => 'Rp ' . number_format($availableEscrow, 0, ',', '.') . ' (Dana siap ditransfer ke RKUD BJB)'),

                        Forms\Components\Select::make('rkud_account_id')
                            ->label('Rekening Kas Daerah Tujuan')
                            ->relationship('rkudAccount', 'bank_name')
                            ->getOptionLabelFromRecordUsing(fn(RkudAccount $record) => "{$record->bank_name} - {$record->account_number} (A.n {$record->account_holder_name})")
                            ->default(fn() => RkudAccount::where('is_active', true)->first()?->id)
                            ->required(),

                        Forms\Components\TextInput::make('total_amount')
                            ->label('Nominal Penarikan Pajak')
                            ->numeric()
                            ->prefix('Rp')
                            ->default($availableEscrow > 0 ? $availableEscrow : null)
                            ->helperText("Maksimal saldo escrow saat ini: Rp " . number_format($availableEscrow, 0, ',', '.'))
                            ->required(),

                        Forms\Components\Textarea::make('notes')
                            ->label('Keperluan / Catatan Dinas')
                            ->placeholder('Contoh: Penyetoran PAD Pajak Wisata Masa Pajak Berjalan ke Kasda')
                            ->default('Penyetoran Penerimaan Asli Daerah (PAD) Sektor Pariwisata ke RKUD Kabupaten Sukabumi')
                            ->columnSpanFull(),
                    ])->columns(2),

                Forms\Components\Section::make('Verifikasi Transfer Bank (Diisi Saat Penyaluran Selesai)')
                    ->schema([
                        Forms\Components\FileUpload::make('transfer_proof_path')
                            ->label('Bukti Transfer Bank BJB')
                            ->image()
                            ->directory('transfer-proofs')
                            ->visibility('public')
                            ->imagePreviewHeight('250'),

                        Forms\Components\DateTimePicker::make('transferred_at')
                            ->label('Tanggal & Waktu Transfer Selesai'),
                    ])
                    ->visible(fn(?TaxWithdrawal $record) => $record !== null)
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('withdrawal_code')
                    ->label('Kode Setoran')
                    ->fontFamily('mono')
                    ->weight('bold')
                    ->searchable()
                    ->copyable(),

                Tables\Columns\TextColumn::make('rkudAccount.bank_name')
                    ->label('Rekening RKUD')
                    ->description(fn(TaxWithdrawal $record) => $record->rkudAccount?->account_number ?? '-'),

                Tables\Columns\TextColumn::make('total_amount')
                    ->label('Nominal Disetor')
                    ->money('IDR', locale: 'id_ID')
                    ->weight('black')
                    ->color('success')
                    ->sortable(),

                Tables\Columns\BadgeColumn::make('status')
                    ->label('Status')
                    ->colors([
                        'warning' => 'pending',
                        'info' => 'approved',
                        'success' => 'transferred',
                        'danger' => 'rejected',
                    ])
                    ->formatStateUsing(fn(string $state): string => match ($state) {
                        'pending' => 'MENUNGGU PERSETUJUAN',
                        'approved' => 'DISETUJUI (SIAP TRANSFER)',
                        'transferred' => 'SUDAH MASUK KASDA',
                        'rejected' => 'DITOLAK',
                        default => strtoupper($state),
                    }),

                Tables\Columns\TextColumn::make('requester.name')
                    ->label('Pemohon')
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('transferred_at')
                    ->label('Waktu Transfer')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Aksi Cetak Bukti Setor / STS
                Tables\Actions\Action::make('print')
                    ->label('Cetak STS')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn(TaxWithdrawal $record) => route('dinas.tax_withdrawal.print', $record->withdrawal_code))
                    ->openUrlInNewTab(),

                // Aksi Approve
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Penyetoran Kas Daerah')
                    ->modalDescription('Apakah Anda yakin menyetujui pengajuan penyetoran ini? Dana siap ditransfer ke Bank BJB Kasda.')
                    ->visible(fn(TaxWithdrawal $record) => $record->status === 'pending')
                    ->action(function (TaxWithdrawal $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                            'approved_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Penyetoran Disetujui')
                            ->body("Pengajuan {$record->withdrawal_code} telah disetujui.")
                            ->success()
                            ->send();
                    }),

                // Aksi Upload Bukti Transfer (Transferred)
                Tables\Actions\Action::make('mark_transferred')
                    ->label('Upload Bukti Transfer')
                    ->icon('heroicon-o-document-check')
                    ->color('primary')
                    ->form([
                        Forms\Components\FileUpload::make('transfer_proof_path')
                            ->label('Foto / Scan Bukti Transfer Bank BJB')
                            ->image()
                            ->directory('transfer-proofs')
                            ->visibility('public')
                            ->required(),
                        Forms\Components\DateTimePicker::make('transferred_at')
                            ->label('Waktu Realisasi Transfer')
                            ->default(now())
                            ->required(),
                    ])
                    ->visible(fn(TaxWithdrawal $record) => $record->status === 'approved')
                    ->action(function (TaxWithdrawal $record, array $data) {
                        $record->update([
                            'status' => 'transferred',
                            'transfer_proof_path' => $data['transfer_proof_path'],
                            'transferred_at' => $data['transferred_at'],
                        ]);

                        // Ubah status mutasi pajak menjadi 'withdrawn'
                        TaxLedger::where('tax_withdrawal_id', $record->id)
                            ->update(['status' => 'withdrawn']);

                        Notification::make()
                            ->title('Setoran Masuk Kasda')
                            ->body("Bukti transfer Bank BJB berhasil dicatat. Status: SUDAH MASUK KASDA.")
                            ->success()
                            ->send();
                    }),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTaxWithdrawals::route('/'),
            'create' => Pages\CreateTaxWithdrawal::route('/create'),
        ];
    }
}
