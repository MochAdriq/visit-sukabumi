@extends('layouts.app')

@section('title', 'Invoice Pemesanan ' . $booking->booking_code . ' — Visit Sukabumi')

@section('content')
<div class="min-h-screen bg-gray-50 py-10 px-4 sm:px-6 lg:px-8">
    <div class="max-w-3xl mx-auto">

        {{-- Breadcrumb & Back --}}
        <div class="mb-6 flex items-center justify-between">
            <a href="{{ $booking->booking_type === 'event' ? route('event.index') : route('place.index') }}" 
               class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-black transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Jelajah
            </a>
            <span class="text-xs font-bold text-gray-400 uppercase tracking-widest">Official Electronic Invoice</span>
        </div>

        {{-- Flash Messages --}}
        @if(session('success'))
            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-900 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm">
                <div class="text-emerald-500 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-sm font-medium leading-relaxed">
                    {{ session('success') }}
                </div>
            </div>
        @endif

        @if(session('info'))
            <div class="mb-6 bg-blue-50 border border-blue-200 text-blue-900 px-5 py-4 rounded-2xl flex items-start gap-3 shadow-sm">
                <div class="text-blue-500 mt-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div class="text-sm font-medium leading-relaxed">
                    {{ session('info') }}
                </div>
            </div>
        @endif

        {{-- Main Invoice Card --}}
        <div class="bg-white rounded-3xl border border-gray-200 shadow-xl overflow-hidden">
            
            {{-- Header --}}
            <div class="bg-[#163766] text-white p-6 sm:p-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <div class="flex items-center gap-2 mb-2">
                        <span class="text-xs font-bold bg-[#f8be2c] text-[#163766] px-2.5 py-0.5 rounded-full uppercase tracking-wider">
                            {{ $booking->booking_type === 'event' ? 'TIKET EVENT' : 'AKOMODASI HOTEL' }}
                        </span>
                        <span class="text-xs text-blue-200">{{ $booking->created_at->translatedFormat('d F Y, H:i') }} WIB</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-black font-['Viga',sans-serif] tracking-tight">Invoice Pemesanan</h1>
                    <p class="text-xs text-blue-200 font-mono mt-1">Kode: {{ $booking->booking_code }}</p>
                </div>

                {{-- Status Badge --}}
                <div>
                    @if($booking->payment_status === 'paid')
                        <div class="bg-emerald-500/20 border border-emerald-400 text-emerald-300 font-bold px-4 py-2 rounded-2xl text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            LUNAS (PAID)
                        </div>
                    @elseif($booking->payment_proof)
                        <div class="bg-blue-500/20 border border-blue-400 text-blue-200 font-bold px-4 py-2 rounded-2xl text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            MENUNGGU VERIFIKASI
                        </div>
                    @else
                        <div class="bg-amber-500/20 border border-amber-400 text-amber-300 font-bold px-4 py-2 rounded-2xl text-sm flex items-center gap-2">
                            <svg class="w-4 h-4 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 7v5l3 3"/></svg>
                            MENUNGGU PEMBAYARAN
                        </div>
                    @endif
                </div>
            </div>

            <div class="p-6 sm:p-8 space-y-8">
                
                {{-- Customer Details & Order Context --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-gray-50 p-5 rounded-2xl border border-gray-100">
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">Informasi Pemesan</span>
                        <h4 class="font-bold text-gray-900 text-base">{{ $booking->customer_name }}</h4>
                        <p class="text-xs text-gray-600">{{ $booking->customer_email }}</p>
                        <p class="text-xs text-gray-600">{{ $booking->customer_phone }}</p>
                    </div>
                    <div>
                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider block mb-1">
                            {{ $booking->booking_type === 'event' ? 'Detail Acara' : 'Detail Penginapan' }}
                        </span>
                        <h4 class="font-bold text-gray-900 text-base">{{ $booking->source_title }}</h4>
                        <p class="text-xs text-gray-600">Item: <strong class="text-gray-800">{{ $booking->bookable?->name ?? 'Tiket / Kamar' }}</strong></p>
                        @if($booking->booking_type === 'hotel')
                            <p class="text-xs text-gray-600 mt-1">
                                Check-in: <strong>{{ $booking->check_in_date?->translatedFormat('d M Y') }}</strong> &middot; 
                                Check-out: <strong>{{ $booking->check_out_date?->translatedFormat('d M Y') }}</strong>
                            </p>
                        @endif
                    </div>
                </div>

                {{-- Price Breakdown Table --}}
                <div>
                    <h3 class="text-base font-bold text-gray-900 mb-3 flex items-center justify-between">
                        <span>Rincian Biaya & Pemisahan Pajak Daerah</span>
                        <span class="text-xs font-normal text-gray-500">Transparansi Pajak UU HKPD</span>
                    </h3>

                    <div class="border border-gray-200 rounded-2xl overflow-hidden">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-gray-100 text-gray-600 text-xs uppercase font-bold border-b border-gray-200">
                                <tr>
                                    <th class="py-3 px-4">Deskripsi Item</th>
                                    <th class="py-3 px-4 text-center">Jumlah</th>
                                    <th class="py-3 px-4 text-right">Harga Satuan</th>
                                    <th class="py-3 px-4 text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <tr>
                                    <td class="py-4 px-4 font-medium text-gray-900">
                                        {{ $booking->source_title }} — {{ $booking->bookable?->name ?? 'Item' }}
                                        <span class="block text-xs text-gray-500 font-normal">Harga dasar produk yang diterima oleh vendor/penyelenggara</span>
                                    </td>
                                    <td class="py-4 px-4 text-center text-gray-600 font-medium">
                                        {{ $booking->quantity }} {{ $booking->booking_type === 'event' ? 'Tiket' : 'Unit/Malam' }}
                                    </td>
                                    <td class="py-4 px-4 text-right text-gray-600 font-mono">
                                        Rp {{ number_format($booking->base_price, 0, ',', '.') }}
                                    </td>
                                    <td class="py-4 px-4 text-right font-bold text-gray-900 font-mono">
                                        Rp {{ number_format($booking->subtotal_amount, 0, ',', '.') }}
                                    </td>
                                </tr>

                                {{-- Tax Breakdown Row (PBJT) --}}
                                <tr class="bg-amber-50/60">
                                    <td colspan="3" class="py-3.5 px-4 text-gray-800">
                                        <div class="flex items-center gap-2">
                                            <span class="inline-flex items-center justify-center w-5 h-5 rounded-full bg-amber-200 text-amber-800 text-xs font-bold">%</span>
                                            <span class="font-bold text-gray-900">
                                                Pajak Daerah (PBJT {{ $booking->tax_rate_percent }}%)
                                            </span>
                                            <span class="text-[11px] bg-amber-200/80 text-amber-900 px-2 py-0.5 rounded-full font-semibold">Kasda Bapenda</span>
                                        </div>
                                        <span class="block text-xs text-gray-500 mt-0.5 ml-7">
                                            Dialokasikan ke Rekening Kas Umum Daerah (RKUD) Kabupaten Sukabumi
                                        </span>
                                    </td>
                                    <td class="py-3.5 px-4 text-right font-bold text-amber-700 font-mono">
                                        Rp {{ number_format($booking->tax_amount, 0, ',', '.') }}
                                    </td>
                                </tr>

                                @if($booking->platform_fee > 0)
                                <tr>
                                    <td colspan="3" class="py-3 px-4 text-gray-600 text-xs">Biaya Administrasi / Payment Gateway</td>
                                    <td class="py-3 px-4 text-right text-gray-600 text-xs font-mono">
                                        Rp {{ number_format($booking->platform_fee, 0, ',', '.') }}
                                    </td>
                                </tr>
                                @endif

                                {{-- Total Row --}}
                                <tr class="bg-gray-900 text-white font-bold text-base">
                                    <td colspan="3" class="py-4 px-4">TOTAL TAGIHAN</td>
                                    <td class="py-4 px-4 text-right text-[#f8be2c] font-black text-lg font-mono">
                                        Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- Escrow Information Box --}}
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border border-blue-200 rounded-2xl p-5">
                    <div class="flex items-start gap-3.5">
                        <div class="bg-[#163766] text-white p-2 rounded-xl mt-0.5">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        </div>
                        <div class="text-xs text-gray-700 space-y-1">
                            <h4 class="font-bold text-gray-900 text-sm">Sistem Rekening Penampung Pajak (Tax Escrow)</h4>
                            <p class="leading-relaxed">
                                Sesuai regulasi pemerintah daerah, penerimaan pajak sebesar <strong>Rp {{ number_format($booking->tax_amount, 0, ',', '.') }}</strong> dipisahkan secara otomatis dan disimpan sementara di <em>Escrow Account</em> resmi hingga Dinas Pendapatan Daerah melakukan pencairan berkala ke RKUD Bank BJB.
                            </p>
                            @if($booking->taxLedger)
                                <div class="mt-2 pt-2 border-t border-blue-200/60 font-mono text-[11px] text-blue-900 flex items-center gap-2">
                                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                                    Mutasi Pajak Tercatat: ID #{{ $booking->taxLedger->id }} &middot; Status: <strong>{{ strtoupper($booking->taxLedger->status) }}</strong>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                @if($booking->payment_status !== 'paid')
                    {{-- ── MANUAL BANK TRANSFER PAYMENT SECTION ── --}}
                    <div class="border border-blue-100 bg-white rounded-3xl p-6 sm:p-7 space-y-6 shadow-sm">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-4 border-b border-gray-100">
                            <div>
                                <span class="text-xs font-bold uppercase tracking-wider text-blue-700">Metode Pembayaran Resmi</span>
                                <h3 class="text-lg font-black text-gray-900 font-['Viga',sans-serif]">Instruksi Transfer Bank Manual</h3>
                            </div>
                            <span class="text-xs text-gray-500 font-medium">Batas Waktu: 1x24 Jam</span>
                        </div>

                        {{-- Rekening Details Grid --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Info Bank & No Rekening --}}
                            <div class="bg-gray-50 p-4 rounded-2xl border border-gray-200/70 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Tujuan Transfer</span>
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-blue-100 text-blue-800">
                                        {{ config('services.payment.bank_name', 'Bank BJB') }}
                                    </span>
                                </div>
                                <div>
                                    <span class="text-xs text-gray-400 block mb-1">Nomor Rekening Resmi</span>
                                    <div class="flex items-center justify-between gap-2">
                                        <span id="rekeningNumber" class="text-lg font-black text-gray-900 font-mono tracking-wide">
                                            {{ config('services.payment.bank_account_no', '0012345678001') }}
                                        </span>
                                        <button type="button" 
                                                onclick="copyText('{{ config('services.payment.bank_account_no', '0012345678001') }}', 'btnCopyRek')"
                                                id="btnCopyRek"
                                                class="px-2.5 py-1 text-xs font-bold text-blue-700 hover:text-blue-800 bg-blue-50 hover:bg-blue-100 rounded-lg transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            Salin
                                        </button>
                                    </div>
                                    <span class="text-xs text-gray-600 block mt-1">
                                        a.n. <strong>{{ config('services.payment.bank_account_name', 'KAS RESMI VISIT SUKABUMI') }}</strong>
                                    </span>
                                </div>
                            </div>

                            {{-- Nominal Transfer --}}
                            <div class="bg-amber-50/50 p-4 rounded-2xl border border-amber-200/70 space-y-3">
                                <div class="flex items-center justify-between">
                                    <span class="text-xs font-bold text-amber-800 uppercase tracking-wider">Total Harus Ditransfer</span>
                                    <span class="text-[11px] font-bold text-amber-700">Tepat hingga nominal akhir</span>
                                </div>
                                <div>
                                    <span class="text-xs text-amber-700/80 block mb-1">Nominal Transfer</span>
                                    <div class="flex items-center justify-between gap-2">
                                        <span class="text-xl font-black text-amber-900 font-mono">
                                            Rp {{ number_format($booking->total_amount, 0, ',', '.') }}
                                        </span>
                                        <button type="button" 
                                                onclick="copyText('{{ (int)$booking->total_amount }}', 'btnCopyNominal')"
                                                id="btnCopyNominal"
                                                class="px-2.5 py-1 text-xs font-bold text-amber-800 hover:text-amber-900 bg-amber-100 hover:bg-amber-200 rounded-lg transition inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                            Salin
                                        </button>
                                    </div>
                                    <span class="text-xs text-amber-800/80 block mt-1">
                                        Berita Transfer: <strong class="font-mono">{{ $booking->booking_code }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>

                        {{-- Bukti Transfer & WhatsApp Section --}}
                        <div class="bg-gray-50 rounded-2xl p-5 border border-gray-200/80">
                            @if($booking->payment_proof)
                                <div class="space-y-3">
                                    <div class="flex flex-col sm:flex-row sm:items-start justify-between gap-4">
                                        <div>
                                            <div class="flex items-center gap-2 mb-1">
                                                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                                <h4 class="font-bold text-gray-900 text-sm">Bukti Pembayaran Terkirim</h4>
                                            </div>
                                            <p class="text-xs text-gray-600">
                                                Diupload pada: <strong>{{ $booking->payment_proof_uploaded_at?->translatedFormat('d F Y, H:i') }} WIB</strong>. Tim admin/keuangan sedang memverifikasi transfer Anda.
                                            </p>
                                            @if($booking->payment_note)
                                                <p class="text-xs text-gray-500 mt-1 italic">
                                                    Catatan: "{{ $booking->payment_note }}"
                                                </p>
                                            @endif
                                        </div>
                                        <a href="{{ $booking->payment_proof_url }}" target="_blank" 
                                           class="text-xs font-bold text-blue-700 hover:text-blue-800 underline shrink-0 inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                            Lihat Bukti Foto
                                        </a>
                                    </div>

                                    {{-- Tombol Konfirmasi WhatsApp --}}
                                    <div class="pt-3 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-3">
                                        <span class="text-xs text-gray-500">Ingin verifikasi lebih cepat? Hubungi tim via WhatsApp:</span>
                                        @php
                                            $waPhone = preg_replace('/[^0-9]/', '', config('services.payment.whatsapp_number', '6281234567890'));
                                            $waMessage = rawurlencode("Halo Admin Visit Sukabumi, saya telah mentransfer pembayaran untuk Kode Booking: {$booking->booking_code} sebesar Rp " . number_format($booking->total_amount, 0, ',', '.') . ". Bukti transfer sudah saya unggah di sistem. Mohon bantuannya untuk verifikasi. Terima kasih.");
                                        @endphp
                                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" 
                                           target="_blank"
                                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white font-bold text-xs rounded-xl shadow-sm transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.181-.077.355.101.174.449.741.964 1.2.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                                            Konfirmasi via WhatsApp
                                        </a>
                                    </div>
                                </div>
                            @else
                                {{-- Form Upload Bukti Transfer --}}
                                <form action="{{ route('booking.upload_proof', $booking->booking_code) }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                                    @csrf
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-sm mb-1">Sudah Melakukan Transfer? Unggah Buktinya di Sini</h4>
                                        <p class="text-xs text-gray-600">
                                            Lampirkan foto struk ATM, tangkapan layar m-Banking, atau mutasi transfer agar admin dapat langsung memverifikasi.
                                        </p>
                                    </div>

                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                                Berkas Foto / Struk Bukti Transfer (Max: 5MB)
                                            </label>
                                            <input type="file" name="payment_proof" accept="image/jpeg,image/png,image/webp" required
                                                   class="block w-full text-xs text-gray-900 border border-gray-300 rounded-xl cursor-pointer bg-white focus:outline-none focus:border-blue-600 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                            @error('payment_proof')
                                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <div>
                                            <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                                                Catatan / Nama Pengirim (Opsional)
                                            </label>
                                            <input type="text" name="payment_note" placeholder="Contoh: Transfer via BCA a.n. Budi"
                                                   class="w-full text-xs px-3.5 py-2 border border-gray-300 rounded-xl focus:ring-1 focus:ring-blue-600 focus:outline-none">
                                        </div>
                                    </div>

                                    <div class="flex flex-col sm:flex-row items-center justify-between gap-3 pt-2">
                                        <button type="submit" 
                                                class="w-full sm:w-auto px-6 py-2.5 bg-blue-700 hover:bg-blue-800 text-white font-bold text-xs rounded-xl transition flex items-center justify-center gap-2 shadow-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                                            Kirim Bukti Pembayaran
                                        </button>

                                        @php
                                            $waPhone = preg_replace('/[^0-9]/', '', config('services.payment.whatsapp_number', '6281234567890'));
                                            $waMessage = rawurlencode("Halo Admin Visit Sukabumi, saya memesan dengan Kode Booking: {$booking->booking_code} sebesar Rp " . number_format($booking->total_amount, 0, ',', '.') . ". Saya ingin melakukan konfirmasi pembayaran manual.");
                                        @endphp
                                        <a href="https://wa.me/{{ $waPhone }}?text={{ $waMessage }}" 
                                           target="_blank"
                                           class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2.5 bg-[#25D366] hover:bg-[#20ba5a] text-white font-bold text-xs rounded-xl shadow-sm transition">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.299.045-.677.063-1.092-.069-.252-.08-.575-.187-.988-.365-1.739-.751-2.874-2.502-2.961-2.617-.087-.116-.708-.94-.708-1.793s.448-1.273.607-1.446c.159-.173.346-.217.462-.217l.332.006c.106.005.249-.04.39.298.144.347.491 1.2.534 1.287.043.087.072.188.014.303-.058.116-.087.188-.173.289l-.26.302c-.087.087-.179.181-.077.355.101.174.449.741.964 1.2.662.591 1.221.774 1.394.86.174.086.275.072.376-.044.101-.116.433-.506.549-.68.116-.173.231-.144.39-.086s1.011.477 1.184.564.289.13.332.203c.043.072.043.419-.101.824z"/></svg>
                                            Bantuan / Konfirmasi via WA
                                        </a>
                                    </div>
                                </form>
                            @endif
                        </div>
                    </div>
                @else
                    {{-- ── PAID CONFIRMATION BANNER ── --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-3xl p-6 text-center space-y-2">
                        <div class="inline-flex items-center justify-center w-12 h-12 bg-emerald-100 text-emerald-700 rounded-full mb-1">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        </div>
                        <h3 class="text-lg font-black text-emerald-900 font-['Viga',sans-serif]">Pembayaran Telah Diverifikasi & Lunas</h3>
                        <p class="text-xs text-emerald-800 max-w-lg mx-auto">
                            Transaksi ini telah dibayar lunas pada {{ $booking->paid_at?->translatedFormat('d F Y, H:i') }} WIB. Bukti invoice resmi ini berlaku sah sebagai tiket masuk atau bukti reservasi menginap.
                        </p>
                    </div>
                @endif

                {{-- Action Block --}}
                <div class="pt-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-gray-500 text-center sm:text-left">
                        Pertanyaan seputar pemesanan? Hubungi Layanan Pelanggan Visit Sukabumi.
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button onclick="window.print()" type="button" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-gray-300 font-bold text-xs text-gray-700 hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Invoice
                        </button>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

<script>
function copyText(text, btnId) {
    if (navigator.clipboard && window.isSecureContext) {
        navigator.clipboard.writeText(text).then(function() {
            showCopied(btnId);
        });
    } else {
        var textArea = document.createElement("textarea");
        textArea.value = text;
        textArea.style.position = "fixed";
        textArea.style.left = "-999999px";
        document.body.appendChild(textArea);
        textArea.focus();
        textArea.select();
        try {
            document.execCommand('copy');
            showCopied(btnId);
        } catch (err) {}
        textArea.remove();
    }
}

function showCopied(btnId) {
    var btn = document.getElementById(btnId);
    if (btn) {
        var original = btn.innerHTML;
        btn.innerHTML = '<svg class="w-3.5 h-3.5 text-emerald-600 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg> Tersalin!';
        setTimeout(function() {
            btn.innerHTML = original;
        }, 2000);
    }
}
</script>
@endsection
