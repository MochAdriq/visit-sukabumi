<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TaxWithdrawalResource\Pages;
use App\Models\RkudAccount;
use App\Models\TaxLedger;
use App\Models\TaxWithdrawal;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class TaxWithdrawalResource extends Resource
{
    protected static ?string $model = TaxWithdrawal::class;

    protected static ?string $navigationIcon = 'heroicon-o-arrow-up-tray';
    protected static ?string $navigationGroup = 'Keuangan & Pajak Daerah';
    protected static ?string $navigationLabel = 'Penyetoran Kas Daerah (RKUD)';
    protected static ?string $modelLabel = 'Penyetoran Pajak';
    protected static ?string $pluralModelLabel = 'Penyetoran Kas Daerah';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        $availableEscrow = (float) TaxLedger::where('status', 'held_in_escrow')->sum('tax_amount');
        $escrowTxCount = TaxLedger::where('status', 'held_in_escrow')->count();
        $recentLedgers = TaxLedger::with('booking')
            ->where('status', 'held_in_escrow')
            ->latest()
            ->take(5)
            ->get();

        return $form
            ->schema([
                // 1. STAT CARD BANNER / RINGKASAN SALDO ESCROW REAL-TIME
                Forms\Components\Section::make('Ringkasan Fiskal: Saldo Pajak Daerah Siap Setor (Escrow)')
                    ->description('Pajak Barang dan Jasa Tertentu (PBJT 10%) dari pemesanan tiket wisata & hotel yang tertampung di rekening escrow resmi, siap dipindahbukukan ke Kas Daerah.')
                    ->schema([
                        Forms\Components\Placeholder::make('escrow_summary')
                            ->hiddenLabel()
                            ->content(function () use ($availableEscrow, $escrowTxCount) {
                                $formattedAmount = 'Rp ' . number_format($availableEscrow, 0, ',', '.');
                                $statusBadge = $availableEscrow > 0
                                    ? '<div style="display:inline-flex; align-items:center; gap:6px; font-weight:700; font-size:11px; letter-spacing:0.05em; text-transform:uppercase; color:#4ade80;">
                                        <svg style="width:14px; height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        DANA TERSEDIA UNTUK PENYETORAN KASDA
                                       </div>'
                                    : '<div style="display:inline-flex; align-items:center; gap:6px; font-weight:700; font-size:11px; letter-spacing:0.05em; text-transform:uppercase; color:#94a3b8;">
                                        SELURUH DANA TELAH DISETORKAN KE KASDA (NIHIL)
                                       </div>';

                                return new HtmlString("
                                    <div style='background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); color: white; padding: 24px; border-radius: 18px; border: 1px solid rgba(255,255,255,0.08); box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1); margin-bottom: 8px;'>
                                        <div style='display:flex; justify-content:space-between; align-items:flex-start; flex-wrap:wrap; gap:16px;'>
                                            <div>
                                                <div style='text-transform:uppercase; letter-spacing:0.1em; font-size:11px; font-weight:700; color:#94a3b8; margin-bottom:6px;'>Saldo Escrow Tersedia Saat Ini</div>
                                                <div style='font-size:32px; font-weight:900; font-family:monospace; color:#38bdf8; letter-spacing:-0.5px;'>{$formattedAmount}</div>
                                                <div style='font-size:13px; color:#cbd5e1; margin-top:6px;'>Akumulasi dari <strong>{$escrowTxCount} transaksi</strong> pemesanan tiket wisata & kamar hotel.</div>
                                            </div>
                                            <div style='text-align:right;'>
                                                <div style='margin-bottom:8px;'>{$statusBadge}</div>
                                                <div style='font-size:11px; color:#94a3b8;'>Dasar Pungutan: <strong>PBJT 10% (Perda Kab. Sukabumi)</strong></div>
                                            </div>
                                        </div>
                                    </div>
                                ");
                            })
                            ->columnSpanFull(),
                    ]),

                // 2. REKENING KAS UMUM DAERAH (RKUD) TUJUAN
                Forms\Components\Section::make('1. Rekening Kas Umum Daerah (RKUD) Penerima')
                    ->description('Pilih rekening resmi Kas Daerah Kabupaten Sukabumi pada Bank Pembangunan Daerah Jawa Barat dan Banten (Bank BJB).')
                    ->icon('heroicon-o-building-library')
                    ->schema([
                        Forms\Components\Select::make('rkud_account_id')
                            ->label('Rekening Kasda Tujuan')
                            ->relationship('rkudAccount', 'bank_name')
                            ->getOptionLabelFromRecordUsing(fn(RkudAccount $record) => "{$record->bank_name} - {$record->account_number} (A.n {$record->account_holder_name}) - {$record->agency_name}")
                            ->default(fn() => RkudAccount::where('is_active', true)->first()?->id)
                            ->required()
                            ->native(false)
                            ->live()
                            ->helperText('Rekening ini telah terverifikasi resmi sebagai RKUD Kabupaten Sukabumi.'),

                        Forms\Components\Placeholder::make('rkud_detail_card')
                            ->label('Informasi Rekening Terpilih')
                            ->content(function ($get) {
                                $account = RkudAccount::find($get('rkud_account_id'));
                                if (!$account) return new HtmlString('<span class="text-sm text-gray-500">Pilih rekening RKUD di atas.</span>');

                                return new HtmlString("
                                    <div style='background:#f8fafc; border:1px solid #e2e8f0; border-radius:12px; padding:14px 18px; font-size:12px;'>
                                        <div style='display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:12px;'>
                                            <div>
                                                <span style='color:#64748b; font-size:11px; text-transform:uppercase; font-weight:600; display:block;'>Bank Operasional</span>
                                                <strong style='color:#0f172a; font-size:13px;'>{$account->bank_name}</strong>
                                            </div>
                                            <div>
                                                <span style='color:#64748b; font-size:11px; text-transform:uppercase; font-weight:600; display:block;'>Nomor Rekening Kasda</span>
                                                <strong style='color:#0f172a; font-size:14px; font-family:monospace;'>{$account->account_number}</strong>
                                            </div>
                                            <div>
                                                <span style='color:#64748b; font-size:11px; text-transform:uppercase; font-weight:600; display:block;'>Nama Pemegang Rekening</span>
                                                <strong style='color:#0f172a; font-size:13px;'>{$account->account_holder_name}</strong>
                                            </div>
                                            <div>
                                                <span style='color:#64748b; font-size:11px; text-transform:uppercase; font-weight:600; display:block;'>Instansi Pembina</span>
                                                <strong style='color:#0f172a; font-size:13px;'>{$account->agency_name}</strong>
                                            </div>
                                        </div>
                                    </div>
                                ");
                            }),
                    ])
                    ->columns(1),

                // 3. NOMINAL PENYETORAN & SURAT PENGANTAR
                Forms\Components\Section::make('2. Nominal Penyetoran & Berita Acara')
                    ->description('Tentukan besaran dana pajak yang akan ditransfer ke Kasda dan berikan catatan dinas pengantar.')
                    ->icon('heroicon-o-banknotes')
                    ->schema([
                        Forms\Components\TextInput::make('total_amount')
                            ->label('Nominal yang Disetor ke Kasda')
                            ->numeric()
                            ->prefix('Rp')
                            ->default($availableEscrow > 0 ? $availableEscrow : null)
                            ->required()
                            ->minValue(1000)
                            ->maxValue($availableEscrow > 0 ? $availableEscrow : 0)
                            ->suffixAction(
                                Forms\Components\Actions\Action::make('setFullBalance')
                                    ->icon('heroicon-m-sparkles')
                                    ->label('Setor Semua (100%)')
                                    ->tooltip('Otomatis isi dengan seluruh saldo escrow yang ada saat ini')
                                    ->action(function ($set) use ($availableEscrow) {
                                        $set('total_amount', $availableEscrow);
                                    })
                            )
                            ->helperText("Maksimal saldo escrow siap setor: Rp " . number_format($availableEscrow, 0, ',', '.'))
                            ->columnSpan(1),

                        Forms\Components\TextInput::make('period_info')
                            ->label('Masa Pajak / Periode Penyetoran')
                            ->default('Masa Pajak Bulan ' . Carbon::now()->translatedFormat('F Y'))
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpan(1),

                        Forms\Components\Textarea::make('notes')
                            ->label('Peruntukan / Dasar Surat / Catatan Dinas')
                            ->rows(3)
                            ->default('Penyetoran Penerimaan Asli Daerah (PAD) Pajak Barang dan Jasa Tertentu (PBJT) Sektor Pariwisata ke Rekening Kas Umum Daerah (RKUD) Kabupaten Sukabumi.')
                            ->placeholder('Tuliskan nomor nota dinas, surat pengantar, atau keterangan tambahan jika diperlukan...')
                            ->helperText('Catatan ini akan dicetak langsung pada lembar resmi Surat Tanda Setor (STS) dan Kuitansi Penyetoran Kasda.')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                // 4. PREVIEW BATCH TRANSAKSI PAJAK YANG AKAN DISETOR
                Forms\Components\Section::make('3. Audit Trail: Sampel Transaksi PBJT yang Masuk Penyetoran Ini')
                    ->description('Daftar transaksi pajak yang tertampung di sistem dan akan dialihkan statusnya menjadi siap setor.')
                    ->icon('heroicon-o-clipboard-document-list')
                    ->collapsible()
                    ->collapsed(false)
                    ->schema([
                        Forms\Components\Placeholder::make('recent_tx_preview')
                            ->hiddenLabel()
                            ->content(function () use ($recentLedgers, $escrowTxCount) {
                                if ($recentLedgers->isEmpty()) {
                                    return new HtmlString('<p style="font-size:13px; color:#64748b; padding:12px 0;">Tidak ada mutasi pajak tertahan saat ini.</p>');
                                }

                                $rows = '';
                                foreach ($recentLedgers as $l) {
                                    $bookingCode = $l->booking?->booking_code ?? '-';
                                    $taxAmount = 'Rp ' . number_format($l->tax_amount, 0, ',', '.');
                                    $vendor = htmlspecialchars($l->vendor_name ?? '-');
                                    $sector = strtoupper($l->sector ?? 'PBJT');
                                    $date = $l->created_at->format('d/m/Y H:i');

                                    $rows .= "
                                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                                            <td style='padding: 8px 12px; font-family: monospace; font-size: 12px; font-weight: 700; color: #0f172a;'>#{$bookingCode}</td>
                                            <td style='padding: 8px 12px; font-size: 12px; color: #334155;'>{$vendor}</td>
                                            <td style='padding: 8px 12px; font-size: 11px; font-weight: 700; color: #475569;'>{$sector}</td>
                                            <td style='padding: 8px 12px; font-size: 12px; color: #64748b;'>{$date}</td>
                                            <td style='padding: 8px 12px; font-size: 12px; font-weight: 800; color: #15803d; text-align: right; font-family: monospace;'>{$taxAmount}</td>
                                        </tr>
                                    ";
                                }

                                $totalRowsNotice = $escrowTxCount > 5 
                                    ? "<div style='font-size:11px; color:#64748b; padding-top:10px; text-align:right;'>Menampilkan 5 dari total <strong>{$escrowTxCount} transaksi</strong> escrow yang tercakup dalam batch ini.</div>" 
                                    : "";

                                return new HtmlString("
                                    <div style='overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px;'>
                                        <table style='width: 100%; border-collapse: collapse; text-align: left;'>
                                            <thead>
                                                <tr style='background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 11px; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em;'>
                                                    <th style='padding: 10px 12px;'>Kode Transaksi</th>
                                                    <th style='padding: 10px 12px;'>Wajib Pungut / Mitra</th>
                                                    <th style='padding: 10px 12px;'>Sektor</th>
                                                    <th style='padding: 10px 12px;'>Waktu Masuk</th>
                                                    <th style='padding: 10px 12px; text-align: right;'>Pajak PBJT (10%)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {$rows}
                                            </tbody>
                                        </table>
                                    </div>
                                    {$totalRowsNotice}
                                ");
                            })
                            ->columnSpanFull(),
                    ]),

                // 5. PANDUAN ALUR BIROKRASI (SOP DINAS)
                Forms\Components\Section::make('4. Alur & SOP Penatausahaan Penyetoran Kasda')
                    ->description('Tahapan standar operasional prosedur penyetoran pajak ke Kas Daerah Kabupaten Sukabumi.')
                    ->icon('heroicon-o-information-circle')
                    ->collapsible()
                    ->collapsed(true)
                    ->schema([
                        Forms\Components\Placeholder::make('sop_guide')
                            ->hiddenLabel()
                            ->content(new HtmlString("
                                <div style='display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; font-size: 12px;'>
                                    <div style='background: #f8fafc; border-left: 3px solid #3b82f6; padding: 12px; border-radius: 8px;'>
                                        <strong style='color: #1e3a8a; display: block; margin-bottom: 4px;'>Langkah 1: Pengajuan (Draft)</strong>
                                        <p style='color: #475569; margin: 0; line-height: 1.4;'>Operator dinas mengajukan nominal penarikan sesuai saldo yang tersedia di rekening penampung escrow.</p>
                                    </div>
                                    <div style='background: #f8fafc; border-left: 3px solid #eab308; padding: 12px; border-radius: 8px;'>
                                        <strong style='color: #854d0e; display: block; margin-bottom: 4px;'>Langkah 2: Otorisasi Pimpinan</strong>
                                        <p style='color: #475569; margin: 0; line-height: 1.4;'>Bendahara Penerimaan / Kepala Dinas meninjau dan memberikan persetujuan (approval) penyetoran.</p>
                                    </div>
                                    <div style='background: #f8fafc; border-left: 3px solid #6366f1; padding: 12px; border-radius: 8px;'>
                                        <strong style='color: #3730a3; display: block; margin-bottom: 4px;'>Langkah 3: Pemindahbukuan</strong>
                                        <p style='color: #475569; margin: 0; line-height: 1.4;'>Pemindahbukuan dana dari rekening penampung ke Bank BJB Rekening Kas Umum Daerah (RKUD).</p>
                                    </div>
                                    <div style='background: #f8fafc; border-left: 3px solid #22c55e; padding: 12px; border-radius: 8px;'>
                                        <strong style='color: #14532d; display: block; margin-bottom: 4px;'>Langkah 4: Bukti Setor & STS</strong>
                                        <p style='color: #475569; margin: 0; line-height: 1.4;'>Upload bukti transfer bank dan cetak Berita Acara Rekonsiliasi resmi yang dilengkapi QR Code validasi.</p>
                                    </div>
                                </div>
                            "))
                            ->columnSpanFull(),
                    ]),

                // SECTION KHUSUS EDIT / VIEW (Verifikasi Transfer Bank)

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
                    ->label('Kode Penarikan')
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
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->actions([
                // Aksi Persetujuan Penarikan
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Persetujuan Penarikan Pajak ke Kasda')
                    ->modalDescription('Apakah Anda yakin ingin menyetujui pengajuan penarikan dana pajak ini untuk diproses transfer ke Rekening Kas Umum Daerah?')
                    ->visible(fn(TaxWithdrawal $record) => $record->status === 'pending')
                    ->action(function (TaxWithdrawal $record) {
                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Pengajuan Disetujui')
                            ->body('Penarikan dana pajak telah disetujui. Silakan lakukan proses transfer ke RKUD.')
                            ->success()
                            ->send();
                    }),

                // Aksi Konfirmasi Transfer Selesai
                Tables\Actions\Action::make('confirm_transfer')
                    ->label('Konfirmasi Transfer')
                    ->icon('heroicon-o-arrow-up-right')
                    ->color('success')
                    ->form([
                        Forms\Components\DateTimePicker::make('transferred_at')
                            ->label('Waktu Transfer')
                            ->default(now())
                            ->required(),
                        Forms\Components\FileUpload::make('transfer_proof_path')
                            ->label('Lampiran Bukti Transfer Bank')
                            ->image()
                            ->directory('transfer-proofs')
                            ->visibility('public')
                            ->required(),
                    ])
                    ->visible(fn(TaxWithdrawal $record) => in_array($record->status, ['pending', 'approved']))
                    ->action(function (TaxWithdrawal $record, array $data) {
                        $record->update([
                            'status' => 'transferred',
                            'transferred_at' => $data['transferred_at'] ?? now(),
                            'transfer_proof_path' => $data['transfer_proof_path'] ?? null,
                            'approved_by' => $record->approved_by ?? auth()->id(),
                        ]);

                        // Mutasi saldo di TaxLedger menjadi withdrawn
                        TaxLedger::where('tax_withdrawal_id', $record->id)->update([
                            'status' => 'withdrawn',
                            'withdrawn_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Transfer Berhasil Dikonfirmasi')
                            ->body('Dana pajak resmi dicatat telah masuk ke Rekening Kas Daerah (RKUD) Bank BJB!')
                            ->success()
                            ->send();
                    }),

                // Aksi Cetak Berita Acara Rekonsiliasi (SPJ Kasda)
                Tables\Actions\Action::make('print_receipt')
                    ->label('Cetak SPJ')
                    ->icon('heroicon-o-printer')
                    ->color('gray')
                    ->url(fn(TaxWithdrawal $record) => route('dinas.tax_withdrawal.print', $record->withdrawal_code))
                    ->openUrlInNewTab(),

                Tables\Actions\ViewAction::make(),
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
