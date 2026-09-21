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

                {{-- Action / Payment Simulation Block --}}
                <div class="pt-4 border-t border-gray-200 flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-xs text-gray-500 text-center sm:text-left">
                        Pertanyaan seputar pesanan? Hubungi Pusat Bantuan Visit Sukabumi.
                    </div>

                    <div class="flex items-center gap-3 w-full sm:w-auto">
                        <button onclick="window.print()" type="button" class="w-full sm:w-auto px-5 py-2.5 rounded-xl border border-gray-300 font-bold text-xs text-gray-700 hover:bg-gray-100 transition flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Invoice
                        </button>

                        @if($booking->payment_status !== 'paid')
                            <form action="{{ route('booking.pay_simulation', $booking->booking_code) }}" method="POST" class="w-full sm:w-auto">
                                @csrf
                                <button type="submit" class="w-full sm:w-auto px-6 py-2.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-lg shadow-emerald-600/30">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                    Simulasikan Pembayaran Lunas
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
