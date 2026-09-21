<x-filament-widgets::widget>
    <div style="background: linear-gradient(135deg, #163766 0%, #1c457f 50%, #0d2342 100%); color: #ffffff; border-radius: 20px; padding: 26px 30px; box-shadow: 0 10px 30px -5px rgba(13, 35, 66, 0.5); position: relative; overflow: hidden; border: 1px solid rgba(255, 255, 255, 0.15);">
        
        {{-- Decorative SVG Watermark Background --}}
        <div style="position: absolute; right: -15px; bottom: -20px; opacity: 0.08; pointer-events: none; color: #ffffff;">
            <svg style="width: 260px; height: 260px;" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/>
            </svg>
        </div>

        {{-- Top Bar: Identitas & Status --}}
        <div style="display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 16px; border-bottom: 1px solid rgba(255, 255, 255, 0.15); padding-bottom: 20px; margin-bottom: 20px;">
            <div style="flex: 1; min-width: 280px;">
                {{-- Badges --}}
                <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 8px; margin-bottom: 10px;">
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 800; background: #f8be2c; color: #163766; box-shadow: 0 2px 8px rgba(248, 190, 44, 0.3);">
                        <svg style="width: 13px; height: 13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                        Portal Resmi Bapenda & Disparbud
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 600; background: rgba(255, 255, 255, 0.12); color: #e0f2fe; border: 1px solid rgba(255, 255, 255, 0.2);">
                        <svg style="width: 8px; height: 8px; color: #4ade80;" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
                        Rekening Penampung (Escrow) Aktif
                    </span>
                    <span style="display: inline-flex; align-items: center; gap: 6px; padding: 4px 12px; border-radius: 9999px; font-size: 11.5px; font-weight: 600; background: rgba(255, 255, 255, 0.12); color: #e0f2fe; border: 1px solid rgba(255, 255, 255, 0.2);">
                        <svg style="width: 13px; height: 13px; color: #93c5fd;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                        RKUD: {{ $activeRkud?->bank_name ?? 'Bank BJB' }} ({{ $activeRkud?->account_number ?? '0012345678901' }})
                    </span>
                </div>

                {{-- Judul Utama --}}
                <h1 style="font-size: 24px; font-weight: 800; color: #ffffff; line-height: 1.25; margin: 8px 0 6px 0; letter-spacing: -0.02em;">
                    Pengelolaan & Pengawasan Pajak Daerah (PBJT)
                </h1>
                <p style="font-size: 13px; color: #bfdbfe; line-height: 1.5; max-width: 640px; margin: 0;">
                    Sistem pemantauan otomatis penerimaan Pajak Barang dan Jasa Tertentu (PBJT) dari tiket acara kesenian dan reservasi hotel di Kabupaten Sukabumi.
                </p>
            </div>

            {{-- Kotak Ringkasan Saldo di Kanan --}}
            <div style="background: rgba(255, 255, 255, 0.1); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px); border: 1px solid rgba(255, 255, 255, 0.22); border-radius: 16px; padding: 14px 18px; text-align: right; min-width: 220px;">
                <div style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; color: #93c5fd; margin-bottom: 2px;">
                    Saldo Pajak di Penampung
                </div>
                <div style="font-size: 26px; font-weight: 900; color: #f8be2c; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; line-height: 1.2;">
                    Rp {{ number_format($availableEscrow, 0, ',', '.') }}
                </div>
                <div style="font-size: 11px; color: #86efac; display: flex; align-items: center; justify-content: flex-end; gap: 4px; margin-top: 4px; font-weight: 500;">
                    <svg style="width: 12px; height: 12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Aman & Siap Disetorkan ke Kasda
                </div>
            </div>
        </div>

        {{-- 3 Langkah Alur Kerja --}}
        <div>
            <div style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: #93c5fd; margin-bottom: 12px; display: flex; align-items: center; gap: 6px;">
                <svg style="width: 14px; height: 14px; color: #f8be2c;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Panduan Alur Kerja Penatausahaan Pajak (3 Langkah Sederhana)
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 12px;">
                {{-- Langkah 1 --}}
                <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.16); border-radius: 14px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <div style="width: 26px; height: 26px; border-radius: 8px; background: rgba(59, 130, 246, 0.35); color: #93c5fd; font-weight: 900; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 1px solid rgba(147, 197, 253, 0.4);">
                            1
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #ffffff;">Pemungutan Otomatis</div>
                    </div>
                    <p style="font-size: 11.5px; color: #bfdbfe; line-height: 1.5; margin: 0;">
                        Setiap wisatawan membayar tiket atau hotel, potongan pajak 10% PBJT langsung disisihkan otomatis ke rekening penampung (escrow).
                    </p>
                </div>

                {{-- Langkah 2 --}}
                <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.16); border-radius: 14px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <div style="width: 26px; height: 26px; border-radius: 8px; background: rgba(245, 158, 11, 0.35); color: #fde68a; font-weight: 900; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 1px solid rgba(253, 230, 138, 0.4);">
                            2
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #ffffff;">Penyetoran ke Kasda</div>
                    </div>
                    <p style="font-size: 11.5px; color: #bfdbfe; line-height: 1.5; margin: 0;">
                        Bendahara dinas mengajukan transfer saldo penampung ke Rekening Kas Umum Daerah (RKUD) Bank bjb cukup dengan 1 klik tombol.
                    </p>
                </div>

                {{-- Langkah 3 --}}
                <div style="background: rgba(255, 255, 255, 0.08); border: 1px solid rgba(255, 255, 255, 0.16); border-radius: 14px; padding: 14px 16px;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 6px;">
                        <div style="width: 26px; height: 26px; border-radius: 8px; background: rgba(16, 185, 129, 0.35); color: #a7f3d0; font-weight: 900; display: flex; align-items: center; justify-content: center; font-size: 12px; border: 1px solid rgba(167, 243, 208, 0.4);">
                            3
                        </div>
                        <div style="font-size: 13.5px; font-weight: 700; color: #ffffff;">Cetak Berita Acara & SPJ</div>
                    </div>
                    <p style="font-size: 11.5px; color: #bfdbfe; line-height: 1.5; margin: 0;">
                        Sistem otomatis menerbitkan Berita Acara Rekonsiliasi resmi Pemkab Sukabumi siap cetak untuk dokumen pertanggungjawaban (SPJ/BPK).
                    </p>
                </div>
            </div>
        </div>

        {{-- Tombol Aksi Cepat (Quick Actions) --}}
        <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px; padding-top: 18px; border-top: 1px solid rgba(255, 255, 255, 0.15); margin-top: 18px;">
            <span style="font-size: 11px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.06em; color: #93c5fd; margin-right: 4px;">
                Aksi Cepat:
            </span>

            {{-- Tombol Setor ke Kasda --}}
            <a href="{{ route('filament.dinas.resources.tax-withdrawals.create') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; background: #f8be2c; color: #163766; font-weight: 800; font-size: 12.5px; padding: 9px 18px; border-radius: 12px; text-decoration: none; box-shadow: 0 4px 14px rgba(248, 190, 44, 0.4); border: none; cursor: pointer; transition: transform 0.15s, background-color 0.15s;">
                <svg style="width: 15px; height: 15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Setor Pajak ke Kasda (Bank bjb)
            </a>

            {{-- Tombol Mutasi Pajak --}}
            <a href="{{ route('filament.dinas.resources.tax-ledgers.index') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.12); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 16px; border-radius: 12px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.25); cursor: pointer;">
                <svg style="width: 14px; height: 14px; color: #93c5fd;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/></svg>
                Buku Mutasi Pajak
            </a>

            {{-- Tombol Seluruh Pesanan --}}
            <a href="{{ route('filament.dinas.resources.bookings.index') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.12); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 16px; border-radius: 12px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.25); cursor: pointer;">
                <svg style="width: 14px; height: 14px; color: #93c5fd;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                Data Pesanan Wisatawan
            </a>

            {{-- Tombol Rekening Kasda --}}
            <a href="{{ route('filament.dinas.resources.rkud-accounts.index') }}" 
               style="display: inline-flex; align-items: center; gap: 8px; background: rgba(255, 255, 255, 0.12); color: #ffffff; font-weight: 600; font-size: 12.5px; padding: 8px 16px; border-radius: 12px; text-decoration: none; border: 1px solid rgba(255, 255, 255, 0.25); cursor: pointer;">
                <svg style="width: 14px; height: 14px; color: #93c5fd;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"/></svg>
                Rekening Kasda (RKUD)
            </a>
        </div>
    </div>
</x-filament-widgets::widget>
