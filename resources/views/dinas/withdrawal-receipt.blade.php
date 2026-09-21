<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Berita Acara Penyetoran Pajak — {{ $withdrawal->withdrawal_code }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&family=Viga&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none !important; }
            .page-break { page-break-before: always; }
        }
    </style>
</head>
<body class="bg-gray-100 font-['Inter',sans-serif] text-gray-900 min-h-screen py-10 px-4 sm:px-6">

    {{-- Action Bar --}}
    <div class="max-w-4xl mx-auto mb-6 flex justify-between items-center no-print">
        <a href="{{ url('/dinas/tax-withdrawals') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-600 hover:text-black transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Portal Dinas
        </a>
        <button onclick="window.print()" type="button" class="inline-flex items-center gap-2 bg-[#163766] hover:bg-[#102747] text-white font-bold text-sm px-6 py-2.5 rounded-xl shadow-md transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
            Cetak Berita Acara (SPJ)
        </button>
    </div>

    {{-- Paper Container --}}
    <div class="max-w-4xl mx-auto bg-white border border-gray-300 shadow-xl rounded-2xl p-8 sm:p-12">
        
        {{-- Kop Surat Resmi Pemda --}}
        <div class="border-b-4 border-double border-gray-800 pb-5 mb-8 text-center relative">
            <div class="flex items-center justify-center gap-4 mb-2">
                <img src="{{ asset('assets/images/logo-v2.png') }}" alt="Visit Sukabumi" class="h-14 w-auto object-contain">
                <div>
                    <h2 class="text-base font-bold tracking-widest text-gray-600 uppercase">Pemerintah Kabupaten Sukabumi</h2>
                    <h1 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight uppercase">Badan Pendapatan Daerah (Bapenda)</h1>
                    <p class="text-xs text-gray-500">Jl. Raya Cisaat No. 12, Sukabumi, Jawa Barat &middot; Portal Pendapatan Asli Daerah (PAD) Pariwisata</p>
                </div>
            </div>
        </div>

        {{-- Document Title --}}
        <div class="text-center mb-8">
            <h3 class="text-lg font-black tracking-wider uppercase underline underline-offset-4 text-gray-900">
                Berita Acara Rekonsiliasi & Penyetoran Pajak Daerah (PBJT)
            </h3>
            <p class="text-xs font-mono text-gray-600 mt-1">Nomor: BA-PBJT/{{ $withdrawal->withdrawal_code }}</p>
            <p class="text-xs text-gray-500 mt-0.5">Tanggal Penerbitan: {{ $withdrawal->created_at->translatedFormat('d F Y, H:i') }} WIB</p>
        </div>

        {{-- Statement Text --}}
        <div class="text-sm leading-relaxed text-gray-800 mb-6 space-y-3">
            <p>
                Pada hari ini, <strong>{{ $withdrawal->created_at->translatedFormat('l') }}</strong>, tanggal <strong>{{ $withdrawal->created_at->translatedFormat('d F Y') }}</strong>, telah dilakukan serah terima dan penyetoran dana <strong>Pajak Barang dan Jasa Tertentu (PBJT)</strong> hasil transaksi resmi sektor pariwisata melalui platform <strong>Visit Sukabumi</strong> dengan rincian sebagai berikut:
            </p>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8 bg-gray-50 p-5 rounded-2xl border border-gray-200">
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Rekening Tujuan Penyetoran (RKUD)</span>
                <p class="font-bold text-gray-900 text-sm">{{ $withdrawal->rkudAccount->bank_name ?? 'Bank BJB' }}</p>
                <p class="text-xs font-mono text-gray-700">No. Rek: {{ $withdrawal->rkudAccount->account_number ?? '-' }}</p>
                <p class="text-xs text-gray-600">A.n: {{ $withdrawal->rkudAccount->account_holder_name ?? 'KAS DAERAH KABUPATEN SUKABUMI' }}</p>
            </div>
            <div>
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-1">Status Penyaluran & Verifikasi</span>
                <div class="flex items-center gap-2 mt-1">
                    @if($withdrawal->status === 'transferred')
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300">
                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            SUDAH MASUK KAS DAERAH
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-300">
                            {{ strtoupper($withdrawal->status) }}
                        </span>
                    @endif
                </div>
                <p class="text-xs text-gray-500 mt-1">Pemohon: {{ $withdrawal->requester?->name ?? 'Pejabat Bapenda' }}</p>
                @if($withdrawal->transferred_at)
                    <p class="text-xs text-gray-500">Waktu Transfer: {{ $withdrawal->transferred_at->translatedFormat('d M Y, H:i') }} WIB</p>
                @endif
            </div>
        </div>

        {{-- Financial Breakdown Table --}}
        <div class="mb-8">
            <h4 class="text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">Rincian Nilai Pajak Daerah yang Disetorkan</h4>
            <table class="w-full text-sm border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-xs uppercase font-bold">
                        <th class="border border-gray-300 p-2.5 text-center w-12">No</th>
                        <th class="border border-gray-300 p-2.5 text-left">Komponen Penyetoran PAD</th>
                        <th class="border border-gray-300 p-2.5 text-center">Dasar Hukum</th>
                        <th class="border border-gray-300 p-2.5 text-right w-44">Jumlah Nominal</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2.5 text-center">1</td>
                        <td class="border border-gray-300 p-2.5 font-medium">
                            Penyetoran Saldo Escrow Pajak Barang dan Jasa Tertentu (PBJT)
                            <span class="block text-xs text-gray-500 font-normal">Hasil pemotongan otomatis transaksi tiket event dan akomodasi hotel</span>
                        </td>
                        <td class="border border-gray-300 p-2.5 text-center text-xs text-gray-600">UU HKPD No. 1 / 2022</td>
                        <td class="border border-gray-300 p-2.5 text-right font-mono font-bold text-gray-900">
                            Rp {{ number_format($withdrawal->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                    <tr class="bg-gray-50 font-black text-sm">
                        <td colspan="3" class="border border-gray-300 p-3 text-right uppercase">TOTAL DISETOR KE RKUD:</td>
                        <td class="border border-gray-300 p-3 text-right font-mono text-base text-gray-900">
                            Rp {{ number_format($withdrawal->total_amount, 0, ',', '.') }}
                        </td>
                    </tr>
                </tbody>
            </table>
            @if($withdrawal->notes)
                <p class="text-xs text-gray-600 mt-2"><strong>Catatan Dinas:</strong> {{ $withdrawal->notes }}</p>
            @endif
        </div>

        {{-- Proof of Transfer Image (If Exists) --}}
        @if($withdrawal->transfer_proof_path)
            <div class="mb-8 p-4 bg-gray-50 rounded-2xl border border-gray-200">
                <span class="text-xs font-bold text-gray-700 uppercase tracking-wider block mb-2">Lampiran Bukti Transfer Kasda Bank BJB</span>
                <div class="max-h-64 overflow-hidden rounded-xl border border-gray-200">
                    <img src="{{ Storage::url($withdrawal->transfer_proof_path) }}" alt="Bukti Transfer Bank" class="w-full object-contain max-h-64">
                </div>
            </div>
        @endif

        {{-- Signatures --}}
        <div class="pt-8 border-t border-gray-300 grid grid-cols-2 gap-8 text-center text-xs">
            <div>
                <p class="text-gray-500 mb-1">Pihak Pertama (Pengelola Platform / Escrow)</p>
                <p class="font-bold text-gray-900">PT Visit Sukabumi Nusantara</p>
                <div class="h-20 flex items-center justify-center text-gray-300 font-mono text-xs italic">
                    [Tercatat Resmi di Sistem]
                </div>
                <p class="font-bold text-gray-900">Administrator Sistem PAD</p>
                <p class="text-gray-500">VisitSukabumi.com</p>
            </div>
            <div>
                <p class="text-gray-500 mb-1">Pihak Kedua (Pemerintah Kabupaten Sukabumi)</p>
                <p class="font-bold text-gray-900">Badan Pendapatan Daerah (Bapenda)</p>
                <div class="h-20 flex items-center justify-center text-gray-300 font-mono text-xs italic">
                    [Tanda Tangan / Stempel Basah]
                </div>
                <p class="font-bold text-gray-900 underline underline-offset-2">{{ $withdrawal->requester?->name ?? 'Bendahara Penerimaan Bapenda' }}</p>
                <p class="text-gray-500">NIP. ........................................</p>
            </div>
        </div>

    </div>
</body>
</html>
