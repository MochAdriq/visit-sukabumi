<?php

namespace App\Filament\Dinas\Resources;

use App\Filament\Dinas\Resources\TaxWithdrawalResource\Pages;
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
    protected static ?string $navigationGroup = '1. Pendapatan Daerah (PAD)';
    protected static ?string $navigationLabel = 'Penyetoran Kasda (RKUD)';
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
                                    <style>
                                        .rkud-info-card { border-radius: 12px; padding: 14px 18px; font-size: 12px; background: #f8fafc; border: 1px solid #e2e8f0; }
                                        .rkud-label { color: #64748b; font-size: 11px; text-transform: uppercase; font-weight: 600; display: block; margin-bottom: 3px; letter-spacing: 0.05em; }
                                        .rkud-val { color: #0f172a; font-size: 13px; font-weight: 700; }
                                        .rkud-val-mono { color: #0f172a; font-size: 14px; font-family: monospace; font-weight: 700; }
                                        
                                        .dark .rkud-info-card { background: #18181b; border-color: rgba(255,255,255,0.1); }
                                        .dark .rkud-label { color: #a1a1aa; }
                                        .dark .rkud-val { color: #f4f4f5; }
                                        .dark .rkud-val-mono { color: #38bdf8; }
                                    </style>
                                    <div class='rkud-info-card'>
                                        <div style='display:grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap:14px;'>
                                            <div>
                                                <span class='rkud-label'>Bank Operasional</span>
                                                <strong class='rkud-val'>{$account->bank_name}</strong>
                                            </div>
                                            <div>
                                                <span class='rkud-label'>Nomor Rekening Kasda</span>
                                                <strong class='rkud-val-mono'>{$account->account_number}</strong>
                                            </div>
                                            <div>
                                                <span class='rkud-label'>Nama Pemegang Rekening</span>
                                                <strong class='rkud-val'>{$account->account_holder_name}</strong>
                                            </div>
                                            <div>
                                                <span class='rkud-label'>Instansi Pembina</span>
                                                <strong class='rkud-val'>{$account->agency_name}</strong>
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
                                        <tr class='escrow-row'>
                                            <td class='escrow-cell escrow-code'>#{$bookingCode}</td>
                                            <td class='escrow-cell escrow-vendor'>{$vendor}</td>
                                            <td class='escrow-cell escrow-sector'>{$sector}</td>
                                            <td class='escrow-cell escrow-date'>{$date}</td>
                                            <td class='escrow-cell escrow-tax'>{$taxAmount}</td>
                                        </tr>
                                    ";
                                }

                                $totalRowsNotice = $escrowTxCount > 5 
                                    ? "<div class='escrow-notice'>Menampilkan 5 dari total <strong>{$escrowTxCount} transaksi</strong> escrow yang tercakup dalam batch ini.</div>" 
                                    : "";

                                return new HtmlString("
                                    <style>
                                        .escrow-audit-wrap { overflow-x: auto; border: 1px solid #e2e8f0; border-radius: 12px; background: #ffffff; }
                                        .escrow-audit-table { width: 100%; border-collapse: collapse; text-align: left; }
                                        .escrow-audit-table thead tr { background: #f8fafc; border-bottom: 1px solid #e2e8f0; font-size: 11px; text-transform: uppercase; color: #64748b; letter-spacing: 0.05em; font-weight: 700; }
                                        .escrow-audit-table th { padding: 10px 14px; }
                                        .escrow-cell { padding: 10px 14px; font-size: 12px; }
                                        .escrow-row { border-bottom: 1px solid #f1f5f9; }
                                        .escrow-row:last-child { border-bottom: none; }
                                        .escrow-code { font-family: monospace; font-weight: 700; color: #0f172a; }
                                        .escrow-vendor { color: #334155; font-weight: 500; }
                                        .escrow-sector { font-size: 11px; font-weight: 700; color: #475569; }
                                        .escrow-date { color: #64748b; }
                                        .escrow-tax { font-family: monospace; font-weight: 800; color: #15803d; text-align: right; }
                                        .escrow-notice { font-size: 11px; color: #64748b; padding-top: 10px; text-align: right; }

                                        /* Dark Mode Support for Filament */
                                        .dark .escrow-audit-wrap { border-color: rgba(255,255,255,0.1); background: #18181b; }
                                        .dark .escrow-audit-table thead tr { background: #27272a; border-bottom: 1px solid rgba(255,255,255,0.1); color: #a1a1aa; }
                                        .dark .escrow-row { border-bottom: 1px solid rgba(255,255,255,0.06); }
                                        .dark .escrow-row:hover { background: rgba(255,255,255,0.03); }
                                        .dark .escrow-code { color: #f4f4f5; }
                                        .dark .escrow-vendor { color: #e4e4e7; }
                                        .dark .escrow-sector { color: #a1a1aa; }
                                        .dark .escrow-date { color: #a1a1aa; }
                                        .dark .escrow-tax { color: #4ade80; }
                                        .dark .escrow-notice { color: #a1a1aa; }
                                    </style>
                                    <div class='escrow-audit-wrap'>
                                        <table class='escrow-audit-table'>
                                            <thead>
                                                <tr>
                                                    <th>Kode Transaksi</th>
                                                    <th>Wajib Pungut / Mitra</th>
                                                    <th>Sektor</th>
                                                    <th>Waktu Masuk</th>
                                                    <th style='text-align: right;'>Pajak PBJT (10%)</th>
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
                                <style>
                                    .sop-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; font-size: 12px; }
                                    .sop-box { padding: 12px 14px; border-radius: 8px; background: #f8fafc; border: 1px solid #e2e8f0; }
                                    .sop-box-1 { border-left: 4px solid #3b82f6; }
                                    .sop-box-2 { border-left: 4px solid #eab308; }
                                    .sop-box-3 { border-left: 4px solid #6366f1; }
                                    .sop-box-4 { border-left: 4px solid #22c55e; }
                                    
                                    .sop-title { font-weight: 700; display: block; margin-bottom: 4px; }
                                    .sop-box-1 .sop-title { color: #1e40af; }
                                    .sop-box-2 .sop-title { color: #854d0e; }
                                    .sop-box-3 .sop-title { color: #3730a3; }
                                    .sop-box-4 .sop-title { color: #15803d; }
                                    .sop-desc { color: #475569; margin: 0; line-height: 1.45; }

                                    /* Dark Mode Support */
                                    .dark .sop-box { background: #18181b; border-color: rgba(255,255,255,0.08); }
                                    .dark .sop-box-1 { border-left: 4px solid #60a5fa; }
                                    .dark .sop-box-2 { border-left: 4px solid #facc15; }
                                    .dark .sop-box-3 { border-left: 4px solid #818cf8; }
                                    .dark .sop-box-4 { border-left: 4px solid #4ade80; }
                                    .dark .sop-box-1 .sop-title { color: #93c5fd; }
                                    .dark .sop-box-2 .sop-title { color: #fde047; }
                                    .dark .sop-box-3 .sop-title { color: #a5b4fc; }
                                    .dark .sop-box-4 .sop-title { color: #86efac; }
                                    .dark .sop-desc { color: #d4d4d8; }
                                </style>
                                <div class='sop-grid'>
                                    <div class='sop-box sop-box-1'>
                                        <strong class='sop-title'>Langkah 1: Pengajuan (Draft)</strong>
                                        <p class='sop-desc'>Operator dinas mengajukan nominal penarikan sesuai saldo yang tersedia di rekening penampung escrow.</p>
                                    </div>
                                    <div class='sop-box sop-box-2'>
                                        <strong class='sop-title'>Langkah 2: Otorisasi Pimpinan</strong>
                                        <p class='sop-desc'>Bendahara Penerimaan / Kepala Dinas meninjau dan memberikan persetujuan (approval) penyetoran.</p>
                                    </div>
                                    <div class='sop-box sop-box-3'>
                                        <strong class='sop-title'>Langkah 3: Pemindahbukuan</strong>
                                        <p class='sop-desc'>Pemindahbukuan dana dari rekening penampung ke Bank BJB Rekening Kas Umum Daerah (RKUD).</p>
                                    </div>
                                    <div class='sop-box sop-box-4'>
                                        <strong class='sop-title'>Langkah 4: Bukti Setor & STS</strong>
                                        <p class='sop-desc'>Upload bukti transfer bank dan cetak Berita Acara Rekonsiliasi resmi yang dilengkapi QR Code validasi.</p>
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
                    ->label('Pemohon (Maker)')
                    ->description(fn(TaxWithdrawal $record) => 'Diajukan: ' . ($record->created_at ? $record->created_at->translatedFormat('d M Y, H:i') : '-'))
                    ->searchable(),

                Tables\Columns\TextColumn::make('approver.name')
                    ->label('Penyetuju (Checker)')
                    ->placeholder('Menunggu ACC')
                    ->description(fn(TaxWithdrawal $record) => $record->status === 'pending' && $record->requested_by === auth()->id() 
                        ? 'Menunggu verifikasi pihak lain' 
                        : ($record->approved_by ? 'Disetujui: ' . $record->updated_at->translatedFormat('d M Y, H:i') : null))
                    ->searchable(),

                Tables\Columns\TextColumn::make('transferred_at')
                    ->label('Waktu Transfer')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Diajukan')
                    ->dateTime('d M Y, H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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

                // Aksi Approve (Anti Self-Approval / Dual Control)
                Tables\Actions\Action::make('approve')
                    ->label('Setujui')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->modalHeading('Setujui Penyetoran Kas Daerah')
                    ->modalDescription('Apakah Anda yakin menyetujui pengajuan penyetoran ini? Dana siap ditransfer ke Bank BJB Kasda.')
                    ->visible(fn(TaxWithdrawal $record) => 
                        $record->status === 'pending' && (auth()->user()?->role === 'admin' || auth()->id() !== $record->requested_by)
                    )
                    ->action(function (TaxWithdrawal $record) {
                        if (auth()->id() === $record->requested_by && auth()->user()?->role !== 'admin') {
                            Notification::make()
                                ->title('Pemisahan Tugas Wajib (Dual Control)')
                                ->body('Anda adalah pembuat pengajuan ini. Sesuai prinsip pengendalian internal, persetujuan harus dilakukan oleh pejabat/petugas yang berbeda.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => 'approved',
                            'approved_by' => auth()->id(),
                        ]);

                        Notification::make()
                            ->title('Penyetoran Disetujui')
                            ->body("Pengajuan {$record->withdrawal_code} telah disetujui.")
                            ->success()
                            ->send();
                    }),

                // Aksi Tolak (Reject)
                Tables\Actions\Action::make('reject')
                    ->label('Tolak')
                    ->icon('heroicon-o-x-circle')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->modalHeading('Tolak Pengajuan Penyetoran')
                    ->modalDescription('Apakah Anda yakin ingin menolak pengajuan ini? Mutasi saldo pajak akan dikembalikan ke status escrow.')
                    ->form([
                        Forms\Components\Textarea::make('notes')
                            ->label('Alasan Penolakan')
                            ->placeholder('Tuliskan alasan penolakan agar dapat dievaluasi oleh pemohon...')
                            ->required(),
                    ])
                    ->visible(fn(TaxWithdrawal $record) => 
                        $record->status === 'pending' && (auth()->user()?->role === 'admin' || auth()->id() !== $record->requested_by)
                    )
                    ->action(function (TaxWithdrawal $record, array $data) {
                        if (auth()->id() === $record->requested_by && auth()->user()?->role !== 'admin') {
                            Notification::make()
                                ->title('Pemisahan Tugas Wajib (Dual Control)')
                                ->body('Anda tidak dapat menolak/menyetujui pengajuan yang Anda buat sendiri.')
                                ->danger()
                                ->send();
                            return;
                        }

                        $record->update([
                            'status' => 'rejected',
                            'notes' => $data['notes'] ?? 'Ditolak oleh atasan/pemeriksa.',
                        ]);

                        // Kembalikan mutasi saldo di TaxLedger menjadi held_in_escrow
                        TaxLedger::where('tax_withdrawal_id', $record->id)
                            ->update([
                                'status' => 'held_in_escrow',
                                'tax_withdrawal_id' => null,
                            ]);

                        Notification::make()
                            ->title('Pengajuan Ditolak')
                            ->body("Pengajuan {$record->withdrawal_code} ditolak. Saldo pajak dikembalikan ke escrow.")
                            ->warning()
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
