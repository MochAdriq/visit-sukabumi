<x-filament-panels::page>
    <style>
        /* ── Dark Mode & Adaptive Styling for Kelola Dashboard ── */
        .dark .fi-header-heading {
            color: #f8fafc !important;
        }
        .km-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.04);
            transition: background-color 0.2s, border-color 0.2s;
        }
        .dark .km-card {
            background: #182234 !important;
            border-color: #293548 !important;
            box-shadow: 0 1px 3px rgba(0,0,0,0.3) !important;
        }
        .km-text-main {
            color: #0f172a;
        }
        .dark .km-text-main {
            color: #f8fafc !important;
        }
        .km-text-muted {
            color: #64748b;
        }
        .dark .km-text-muted {
            color: #94a3b8 !important;
        }
        .km-border-b {
            border-bottom: 1px solid #f1f5f9;
        }
        .dark .km-border-b {
            border-bottom-color: #243044 !important;
        }
        .km-row-border {
            border-bottom: 1px solid #f8fafc;
        }
        .dark .km-row-border {
            border-bottom-color: #243044 !important;
        }
        .km-btn-secondary {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            color: #0f172a;
            transition: all 0.15s ease-in-out;
        }
        .km-btn-secondary:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }
        .dark .km-btn-secondary {
            background: #1e293b !important;
            border-color: #334155 !important;
            color: #f1f5f9 !important;
        }
        .dark .km-btn-secondary:hover {
            background: #27354a !important;
            border-color: #475569 !important;
        }
        .km-btn-outline {
            background: #ffffff;
            border: 1px solid #cbd5e1;
            color: #1a6bbf;
            transition: all 0.15s ease-in-out;
        }
        .km-btn-outline:hover {
            background: #f8fafc;
            border-color: #94a3b8;
        }
        .dark .km-btn-outline {
            background: #182234 !important;
            border-color: #2563eb !important;
            color: #60a5fa !important;
        }
        .dark .km-btn-outline:hover {
            background: #1e293b !important;
        }
        .km-code-pill {
            background: #f1f5f9;
            color: #334155;
        }
        .dark .km-code-pill {
            background: #1e293b !important;
            color: #cbd5e1 !important;
        }
        .km-icon-box {
            background: #f1f5f9;
            color: #1a6bbf;
        }
        .dark .km-icon-box {
            background: #1e293b !important;
            color: #60a5fa !important;
        }
        .km-icon-green {
            background: #ecfdf5;
            color: #059669;
        }
        .dark .km-icon-green {
            background: #064e3b !important;
            color: #34d399 !important;
        }
        .km-icon-amber {
            background: #fffbeb;
            color: #d97706;
        }
        .dark .km-icon-amber {
            background: #451a03 !important;
            color: #fbbf24 !important;
        }
        .km-reply-box {
            background: #f8fafc;
            border-left: 3px solid #1a6bbf;
            color: #1e293b;
        }
        .dark .km-reply-box {
            background: #1e293b !important;
            border-left-color: #3b82f6 !important;
            color: #e2e8f0 !important;
        }
    </style>

    {{-- ── 1. HERO WORKSTATION HEADER ── --}}
    <div style="background: #0f294a; border: 1px solid #1e3a5f; border-radius: 12px; padding: 24px 28px; color: #ffffff; margin-bottom: 24px; position: relative; overflow: hidden;">
        {{-- Subtle Architectural SVG Watermark --}}
        <div style="position: absolute; right: -10px; bottom: -20px; opacity: 0.05; pointer-events: none; color: #ffffff;">
            <svg style="width: 200px; height: 200px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>

        <div style="display: flex; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 20px; position: relative; z-index: 1;">
            <div>
                <p style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; color: #93c5fd; margin: 0 0 6px 0;">
                    Portal Pengelola Pariwisata • {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                </p>
                <h1 style="font-size: 22px; font-weight: 800; color: #ffffff; margin: 0 0 6px 0; letter-spacing: -0.01em;">
                    {{ $this->primaryPlace?->name ?? 'Destinasi Pariwisata' }}
                </h1>
                <p style="font-size: 13px; color: #cbd5e1; margin: 0; max-width: 620px; line-height: 1.5;">
                    Pengelola: <strong style="color: #ffffff;">{{ auth()->user()->name }}</strong> 
                    @if($this->primaryPlace?->district)
                        • Wilayah {{ $this->primaryPlace->district }}
                    @endif
                    • Status: <span style="color: #86efac; font-weight: 700;">Terverifikasi Aktif</span>
                </p>
            </div>

            <div style="display: flex; flex-wrap: wrap; align-items: center; gap: 10px;">
                <a href="{{ route('filament.kelola.resources.hotel-rooms.create') }}"
                   style="display: inline-flex; align-items: center; gap: 6px; background: rgba(255, 255, 255, 0.12); color: #ffffff; font-size: 12px; font-weight: 700; padding: 8px 14px; border-radius: 8px; border: 1px solid rgba(255, 255, 255, 0.25); text-decoration: none; transition: background-color 0.15s;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Kamar
                </a>

                <a href="{{ route('filament.kelola.resources.mitra-bookings.index') }}"
                   style="display: inline-flex; align-items: center; gap: 6px; background: #ffffff; color: #0f294a; font-size: 12px; font-weight: 800; padding: 8px 16px; border-radius: 8px; text-decoration: none; box-shadow: 0 1px 3px rgba(0,0,0,0.1); transition: transform 0.15s;">
                    <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Buku Pesanan Tamu
                </a>
            </div>
        </div>
    </div>

    {{-- ── 2. METRIC CARDS (FINANCIAL & OPERATIONAL KPIS) ── --}}
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; margin-bottom: 24px;">
        {{-- Card 1: Total Pesanan --}}
        <div class="km-card" style="padding: 18px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span class="km-text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
                    Total Pemesanan
                </span>
                <div class="km-icon-box" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                    </svg>
                </div>
            </div>
            <div class="km-text-main" style="font-size: 26px; font-weight: 900; line-height: 1.1; margin-bottom: 4px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
                {{ $this->totalBookings }}
            </div>
            <p class="km-text-muted" style="font-size: 12px; margin: 0;">
                @if($this->pendingBookingsCount > 0)
                    <span style="color: #b45309; font-weight: 600;">{{ $this->pendingBookingsCount }} menunggu bayar</span>
                @else
                    Semua transaksi terkonfirmasi
                @endif
            </p>
        </div>

        {{-- Card 2: Pendapatan Bersih --}}
        <div class="km-card" style="padding: 18px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span class="km-text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
                    Pendapatan Bersih
                </span>
                <div class="km-icon-green" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
            <div style="font-size: 22px; font-weight: 900; color: #059669; line-height: 1.1; margin-bottom: 4px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
                Rp {{ number_format($this->paidRevenue, 0, ',', '.') }}
            </div>
            <p class="km-text-muted" style="font-size: 12px; margin: 0;">
                Hak mitra bersih (di luar PBJT 10%)
            </p>
        </div>

        {{-- Card 3: Check-In Hari Ini --}}
        <div class="km-card" style="padding: 18px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span class="km-text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
                    Kedatangan Hari Ini
                </span>
                <div class="km-icon-box" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 17px; height: 17px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div class="km-text-main" style="font-size: 26px; font-weight: 900; line-height: 1.1; margin-bottom: 4px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
                {{ $this->todayCheckIns }} <span class="km-text-muted" style="font-size: 14px; font-weight: 600;">Tamu</span>
            </div>
            <p class="km-text-muted" style="font-size: 12px; margin: 0;">
                Tanggal {{ \Carbon\Carbon::today()->format('d M Y') }}
            </p>
        </div>

        {{-- Card 4: Kepuasan Tamu --}}
        <div class="km-card" style="padding: 18px 20px;">
            <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 12px;">
                <span class="km-text-muted" style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em;">
                    Kepuasan Wisatawan
                </span>
                <div class="km-icon-amber" style="width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                    <svg style="width: 17px; height: 17px;" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                    </svg>
                </div>
            </div>
            <div class="km-text-main" style="font-size: 26px; font-weight: 900; line-height: 1.1; margin-bottom: 4px; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;">
                {{ $this->avgRating }} <span class="km-text-muted" style="font-size: 14px; font-weight: 600;">/ 5.0</span>
            </div>
            <p class="km-text-muted" style="font-size: 12px; margin: 0;">
                Berdasarkan {{ $this->totalReviews }} ulasan terverifikasi
            </p>
        </div>
    </div>

    {{-- ── 3. WORKSTATION 2-COLUMN SECTION ── --}}
    <div style="display: grid; grid-template-columns: 1fr 340px; gap: 24px; margin-bottom: 24px; align-items: start;">
        
        {{-- KOLOM KIRI: RESERVASI & TAMU MASUK --}}
        <div class="km-card" style="overflow: hidden;">
            <div class="km-border-b" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h2 class="km-text-main" style="font-size: 14px; font-weight: 800; margin: 0;">
                        Reservasi & Tamu Masuk
                    </h2>
                    <p class="km-text-muted" style="font-size: 12px; margin: 2px 0 0 0;">
                        Daftar transaksi menginap dan tiket terkini
                    </p>
                </div>
                <a href="{{ route('filament.kelola.resources.mitra-bookings.index') }}" 
                   style="font-size: 12px; font-weight: 700; color: #1a6bbf; text-decoration: none;">
                    Buka Semua Pesanan
                </a>
            </div>

            @if($this->recentBookings->count() > 0)
                <div>
                    @foreach($this->recentBookings as $booking)
                        <div class="km-row-border" style="padding: 16px 20px; display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 14px;">
                            {{-- Info Pemesan & Kode --}}
                            <div style="min-width: 220px; flex: 1;">
                                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 4px;">
                                    <span class="km-code-pill" style="font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; font-size: 12px; font-weight: 700; padding: 2px 6px; border-radius: 4px;">
                                        {{ $booking->booking_code }}
                                    </span>
                                    
                                    @if($booking->payment_status === 'paid')
                                        <span style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; padding: 2px 8px; border-radius: 4px;">
                                            Lunas
                                        </span>
                                    @else
                                        <span style="font-size: 10.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.05em; background: #fffbeb; color: #b45309; border: 1px solid #fde68a; padding: 2px 8px; border-radius: 4px;">
                                            Menunggu Pembayaran
                                        </span>
                                    @endif
                                </div>

                                <div class="km-text-main" style="font-size: 13.5px; font-weight: 800; margin-bottom: 2px;">
                                    {{ $booking->customer_name }}
                                </div>

                                <div class="km-text-muted" style="font-size: 12px; display: flex; flex-wrap: wrap; align-items: center; gap: 8px;">
                                    <span>{{ $booking->source_title }}</span>
                                    @if($booking->customer_phone)
                                        <span>•</span>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $booking->customer_phone) }}" target="_blank"
                                           style="color: #059669; text-decoration: none; font-weight: 600;">
                                            WA: {{ $booking->customer_phone }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            {{-- Info Waktu Check-In & Nilai --}}
                            <div style="text-align: right; min-width: 140px;">
                                <div class="km-text-main" style="font-size: 15px; font-weight: 900; font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace; margin-bottom: 2px;">
                                    Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                </div>
                                <div class="km-text-muted" style="font-size: 11.5px;">
                                    {{ $booking->quantity }} unit
                                    @if($booking->check_in_date)
                                        • Masuk {{ $booking->check_in_date->format('d M Y') }}
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="km-text-muted" style="padding: 40px 24px; text-align: center;">
                    <p class="km-text-main" style="font-size: 14px; font-weight: 700; margin: 0 0 4px 0;">Belum Ada Pesanan Tamu Masuk</p>
                    <p style="font-size: 12.5px; margin: 0; max-width: 400px; margin-inline: auto;">
                        Pastikan kamar dan tiket Anda berstatus aktif dengan harga yang tepat agar dapat dipesan langsung oleh wisatawan.
                    </p>
                </div>
            @endif
        </div>

        {{-- KOLOM KANAN: RINGKASAN PROPERTI & PENGATURAN CEPAT --}}
        <div>
            {{-- Properti Aktif --}}
            <div class="km-card" style="overflow: hidden; margin-bottom: 16px;">
                @if($this->primaryPlace)
                    <div style="height: 140px; background: #e2e8f0; position: relative;">
                        <img src="{{ $this->primaryPlace->cover_image_url }}" alt="{{ $this->primaryPlace->name }}" style="width: 100%; height: 100%; object-fit: cover;">
                        <div style="position: absolute; inset: 0; background: linear-gradient(180deg, rgba(0,0,0,0) 40%, rgba(0,0,0,0.75) 100%);"></div>
                        <div style="position: absolute; bottom: 12px; left: 14px; right: 14px; color: #ffffff;">
                            <p style="font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: #93c5fd; margin: 0 0 2px 0;">
                                {{ $this->primaryPlace->district ?? 'Kabupaten Sukabumi' }}
                            </p>
                            <h3 style="font-size: 14px; font-weight: 800; margin: 0; color: #ffffff;">
                                {{ $this->primaryPlace->name }}
                            </h3>
                        </div>
                    </div>

                    <div style="padding: 16px;">
                        <div class="km-text-muted" style="font-size: 12px; line-height: 1.5; margin-bottom: 14px;">
                            Jam Buka: <strong class="km-text-main">{{ $this->primaryPlace->open_hours ?? 'Belum diatur' }}</strong><br>
                            Kontak: <strong class="km-text-main">{{ $this->primaryPlace->phone ?? 'Belum diatur' }}</strong>
                        </div>

                        {{-- Navigasi Cepat Properti --}}
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            {{-- Tombol Edit Profil yang telah diperbaiki --}}
                            <a href="{{ route('filament.kelola.resources.my-places.edit', ['record' => $this->primaryPlace]) }}"
                               class="km-btn-secondary"
                               style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700;">
                                <span>Edit Profil & Jam Buka</span>
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('filament.kelola.resources.hotel-rooms.index') }}"
                               class="km-btn-secondary"
                               style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700;">
                                <span>Kamar & Tarif ({{ $this->activeRoomsCount }} Aktif)</span>
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('filament.kelola.resources.place-galleries.index') }}"
                               class="km-btn-secondary"
                               style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700;">
                                <span>Galeri Foto Destinasi</span>
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>

                            <a href="{{ route('place.show', $this->primaryPlace->slug) }}" target="_blank"
                               class="km-btn-outline"
                               style="display: flex; align-items: center; justify-content: space-between; padding: 10px 14px; border-radius: 8px; text-decoration: none; font-size: 12px; font-weight: 700;">
                                <span>Pratinjau Halaman Publik</span>
                                <svg style="width: 14px; height: 14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                @else
                    <div class="km-text-muted" style="padding: 24px; text-align: center; font-size: 13px;">
                        Belum ada tempat wisata yang terhubung.
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── 4. ULASAN WISATAWAN TERKINI ── --}}
    @if($this->recentReviews->count() > 0)
        <div class="km-card" style="overflow: hidden;">
            <div class="km-border-b" style="padding: 16px 20px; display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <h2 class="km-text-main" style="font-size: 14px; font-weight: 800; margin: 0;">
                        Ulasan & Kepuasan Pengunjung
                    </h2>
                    <p class="km-text-muted" style="font-size: 12px; margin: 2px 0 0 0;">
                        Tanggapan langsung dari wisatawan yang telah berkunjung
                    </p>
                </div>
                <a href="{{ route('filament.kelola.resources.review-managements.index') }}" 
                   style="font-size: 12px; font-weight: 700; color: #1a6bbf; text-decoration: none;">
                    Kelola Semua Ulasan
                </a>
            </div>

            <div style="padding: 8px 0;">
                @foreach($this->recentReviews as $review)
                    <div class="km-row-border" style="padding: 16px 20px;">
                        <div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px;">
                            <div style="display: flex; align-items: center; gap: 8px;">
                                <strong class="km-text-main" style="font-size: 13px;">{{ $review->user->name }}</strong>
                                <span class="km-text-muted" style="font-size: 12px;">• {{ $review->place->name }}</span>
                                <span class="km-text-muted" style="font-size: 11.5px;">• {{ $review->created_at->diffForHumans() }}</span>
                            </div>
                            <div style="color: #f59e0b; font-size: 13px; letter-spacing: 2px;">
                                {{ str_repeat('★', (int) $review->rating) }}{{ str_repeat('☆', 5 - (int) $review->rating) }}
                            </div>
                        </div>

                        <p class="km-text-main" style="font-size: 13px; line-height: 1.5; margin: 0 0 8px 0; opacity: 0.9;">
                            "{{ $review->content }}"
                        </p>

                        @if($review->official_response)
                            <div class="km-reply-box" style="padding: 8px 12px; border-radius: 0 6px 6px 0; font-size: 12px;">
                                <strong style="color: #1a6bbf;">Tanggapan Resmi Anda:</strong> {{ $review->official_response }}
                            </div>
                        @else
                            <a href="{{ route('filament.kelola.resources.review-managements.index') }}" 
                               style="font-size: 11.5px; font-weight: 700; color: #1a6bbf; text-decoration: none;">
                                + Tulis Balasan Resmi Pengelola
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</x-filament-panels::page>
