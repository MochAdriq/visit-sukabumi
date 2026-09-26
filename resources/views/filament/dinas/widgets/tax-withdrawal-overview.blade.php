<x-filament-widgets::widget>
    <style>
        .tax-overview-wrap {
            border-radius: 18px;
            overflow: hidden;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            margin-bottom: 24px;
        }

        /* Hero Banner */
        .tax-hero-banner {
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #ffffff;
            padding: 24px 28px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-bottom: none;
            border-radius: 18px 18px 0 0;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        .tax-hero-kicker {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: #94a3b8;
            margin-bottom: 4px;
        }

        .tax-hero-amount {
            font-size: 32px;
            font-weight: 900;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: #38bdf8;
            letter-spacing: -0.5px;
            line-height: 1.15;
        }

        .tax-hero-sub {
            font-size: 13px;
            color: #cbd5e1;
            margin-top: 6px;
        }

        .tax-hero-cta {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #2563eb;
            color: #ffffff;
            font-size: 13px;
            font-weight: 700;
            padding: 12px 22px;
            border-radius: 12px;
            text-decoration: none;
            transition: all 0.2s ease;
            box-shadow: 0 4px 14px rgba(37, 99, 235, 0.35);
        }
        .tax-hero-cta:hover {
            background: #1d4ed8;
            transform: translateY(-1px);
            color: #ffffff;
        }

        /* Metric Grid */
        .tax-metric-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 1px;
            background: #e2e8f0;
            border: 1px solid #e2e8f0;
            border-radius: 0 0 18px 18px;
            overflow: hidden;
        }

        .tax-metric-card {
            background: #ffffff;
            padding: 18px 22px;
            font-size: 12px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .tax-metric-title {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 6px;
        }

        .tax-metric-value {
            font-size: 20px;
            font-weight: 900;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
            color: #0f172a;
            letter-spacing: -0.3px;
            line-height: 1.2;
        }

        .tax-metric-desc {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        /* Dark Mode Adjustments */
        .dark .tax-metric-grid {
            background: rgba(255, 255, 255, 0.08);
            border-color: rgba(255, 255, 255, 0.08);
        }

        .dark .tax-metric-card {
            background: #18181b;
        }

        .dark .tax-metric-title {
            color: #a1a1aa;
        }

        .dark .tax-metric-value {
            color: #f4f4f5;
        }

        .dark .tax-metric-desc {
            color: #a1a1aa;
        }
    </style>

    <div class="tax-overview-wrap">
        {{-- Top Hero Section: Saldo Escrow Siap Setor & CTA --}}
        <div class="tax-hero-banner">
            <div>
                <div class="tax-hero-kicker">Saldo Pajak Daerah Siap Setor (Escrow)</div>
                <div class="tax-hero-amount">
                    Rp {{ number_format($availableEscrow, 0, ',', '.') }}
                </div>
                <div class="tax-hero-sub">
                    Akumulasi PBJT 10% dari <strong>{{ number_format($escrowTxCount, 0, ',', '.') }} transaksi</strong> tiket wisata & hotel yang aman di rekening penampung.
                </div>
            </div>

            <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 8px;">
                @if($availableEscrow > 0)
                    <div style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #4ade80;">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        DANA TERSEDIA UNTUK PENYETORAN KASDA
                    </div>
                    <a href="{{ $createUrl }}" class="tax-hero-cta">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                        Ajukan Penyetoran ke Kasda
                    </a>
                @else
                    <div style="display: inline-flex; align-items: center; gap: 6px; font-weight: 700; font-size: 11px; letter-spacing: 0.05em; text-transform: uppercase; color: #94a3b8;">
                        <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        SELURUH DANA TELAH DISETORKAN KE KASDA (NIHIL)
                    </div>
                    <a href="{{ $createUrl }}" class="tax-hero-cta" style="background: #334155; box-shadow: none;">
                        <svg style="width: 16px; height: 16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                        Buka Formulir Penyetoran
                    </a>
                @endif
            </div>
        </div>

        {{-- Bottom Metric Grid: Realisasi, RKUD BJB, & Antrean Status --}}
        <div class="tax-metric-grid">
            {{-- Card 1: Total Sudah Masuk Kasda (PAD Sah) --}}
            <div class="tax-metric-card">
                <div>
                    <div class="tax-metric-title">
                        <svg style="width: 14px; height: 14px; color: #16a34a;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Realisasi Sah Masuk Kasda
                    </div>
                    <div class="tax-metric-value" style="color: #16a34a;">
                        Rp {{ number_format($totalDeposited, 0, ',', '.') }}
                    </div>
                </div>
                <div class="tax-metric-desc">
                    Akumulasi dari <strong>{{ $transferredCount }} kali</strong> pemindahbukuan resmi ke Kasda Bank BJB.
                </div>
            </div>

            {{-- Card 2: Rekening Kas Umum Daerah (RKUD) Tujuan --}}
            <div class="tax-metric-card">
                <div>
                    <div class="tax-metric-title">
                        <svg style="width: 14px; height: 14px; color: #2563eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        Rekening Tujuan Kasda (RKUD)
                    </div>
                    <div class="tax-metric-value" style="font-size: 15px; color: #2563eb;">
                        {{ $activeRkud?->bank_name ?? 'Bank BJB' }} — {{ $activeRkud?->account_number ?? '-' }}
                    </div>
                </div>
                <div class="tax-metric-desc">
                    A.n <strong>{{ $activeRkud?->account_holder_name ?? 'KAS DAERAH KABUPATEN SUKABUMI' }}</strong>
                </div>
            </div>

            {{-- Card 3: Status Antrean Pengajuan Penyetoran --}}
            <div class="tax-metric-card">
                <div>
                    <div class="tax-metric-title">
                        <svg style="width: 14px; height: 14px; color: #ca8a04;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Status Antrean Proses
                    </div>
                    <div class="tax-metric-value" style="font-size: 15px;">
                        @if($pendingCount > 0 || $approvedCount > 0)
                            <span style="color: #ca8a04;">{{ $pendingCount }} Menunggu</span> &middot; <span style="color: #2563eb;">{{ $approvedCount }} Disetujui</span>
                        @else
                            <span style="color: #64748b; font-size: 14px;">Tidak Ada Antrean</span>
                        @endif
                    </div>
                </div>
                <div class="tax-metric-desc">
                    @if($pendingAmount > 0)
                        Total antrean proses: Rp {{ number_format($pendingAmount + $approvedAmount, 0, ',', '.') }}
                    @else
                        Seluruh pengajuan telah diselesaikan ke Kasda.
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-filament-widgets::widget>
