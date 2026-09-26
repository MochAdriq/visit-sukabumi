@extends('layouts.app')

@section('title', 'Klaim Destinasi: ' . $place->name . ' — Visit Sukabumi')
@section('meta_description', 'Ajukan klaim kepemilikan dan verifikasi legalitas pengelola destinasi ' . $place->name . ' di Visit Sukabumi.')

@section('content')
<div class="min-h-screen bg-slate-50 font-sans pb-20">
    @include('components.navbar')

    {{-- ══ HERO HEADER KEMITRAAN RESMI ══ --}}
    <div class="pt-24 pb-12 bg-[#0f294a] border-b border-[#1e3a5f] text-white relative overflow-hidden">
        {{-- Subtle Architectural SVG Watermark --}}
        <div class="absolute right-0 bottom-0 opacity-5 pointer-events-none transform translate-x-12 translate-y-12">
            <svg class="w-96 h-96" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-xs font-semibold text-blue-200/80 mb-5">
                <a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a>
                <svg class="w-3.5 h-3.5 text-blue-300/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <a href="{{ route('place.show', $place->slug) }}" class="hover:text-white transition">{{ $place->name }}</a>
                <svg class="w-3.5 h-3.5 text-blue-300/60" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span class="text-white">Verifikasi Hak Kelola</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-wider text-blue-300 mb-2">
                    Program Kemitraan & Verifikasi Pengelola Resmi
                </p>
                <h1 class="text-2xl sm:text-3xl lg:text-4xl font-extrabold text-white tracking-tight leading-tight">
                    Klaim Kepemilikan & Hak Pengelolaan
                </h1>
                <p class="text-sm sm:text-base text-slate-300 mt-3 leading-relaxed">
                    Pengajuan verifikasi bagi penanggung jawab, instansi, atau kelompok pengelola untuk mengelola profil resmi, reservasi online, dan ulasan destinasi <strong class="text-white font-bold">{{ $place->name }}</strong> melalui Portal Mitra.
                </p>
            </div>
        </div>
    </div>

    {{-- ══ MAIN 2-COLUMN WORKSPACE ══ --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">

            {{-- ── KOLOM KIRI: FORMULIR LEGALITAS PENGELOLA (7 COLS) ── --}}
            <div class="lg:col-span-7 space-y-6">

                {{-- Akun Terdaftar Card --}}
                <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-xs flex items-center justify-between gap-4">
                    <div class="flex items-center gap-3.5">
                        <div class="w-11 h-11 rounded-xl bg-blue-50 border border-blue-100 flex items-center justify-center text-[#1a6bbf] shrink-0">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <p class="text-[11px] font-bold uppercase tracking-wider text-slate-400">Akun Pemohon Terhubung</p>
                            <h3 class="text-sm font-bold text-slate-900">{{ auth()->user()->name }}</h3>
                            <p class="text-xs text-slate-500 font-mono">{{ auth()->user()->email }}</p>
                        </div>
                    </div>
                    <div class="text-right hidden sm:block">
                        <span class="text-xs font-semibold text-emerald-600 flex items-center justify-end gap-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Sesi Terautentikasi
                        </span>
                        <p class="text-[11px] text-slate-400 mt-0.5">Penerima hak kelola saat disetujui</p>
                    </div>
                </div>

                {{-- Form Container --}}
                <div class="bg-white border border-slate-200/90 rounded-2xl p-6 sm:p-8 shadow-xs">
                    <div class="border-b border-slate-100 pb-5 mb-6">
                        <h2 class="text-base font-extrabold text-slate-900 tracking-tight">Formulir Pengajuan Legalitas</h2>
                        <p class="text-xs text-slate-500 mt-1">
                            Pastikan data kontak dan berkas penunjang yang diunggah valid untuk memudahkan verifikasi oleh administrator.
                        </p>
                    </div>

                    <form action="{{ route('claim.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                        @csrf
                        <input type="hidden" name="place_id" value="{{ $place->id }}">

                        {{-- Input 1: WhatsApp Aktif --}}
                        <div>
                            <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 mb-1.5">
                                Nomor WhatsApp Penanggung Jawab <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                </div>
                                <input type="tel" name="applicant_phone" required
                                       value="{{ old('applicant_phone', auth()->user()->phone) }}"
                                       placeholder="Contoh: 081234567890"
                                       class="w-full pl-10 pr-4 py-3 text-sm rounded-xl border border-slate-200 focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition bg-slate-50/50 focus:bg-white text-slate-900 font-medium">
                            </div>
                            <p class="text-[11.5px] text-slate-500 mt-1.5 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Tim verifikator akan menghubungi nomor ini jika diperlukan validasi lapangan atau wawancara singkat.
                            </p>
                            @error('applicant_phone')
                                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input 2: Upload KTP --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Foto KTP Penanggung Jawab <span class="text-red-500">*</span>
                                </label>
                                <span class="text-[11px] font-semibold text-slate-400">JPG, PNG • Maks. 5 MB</span>
                            </div>
                            
                            <div class="border-2 border-dashed border-slate-200 hover:border-[#1a6bbf]/60 rounded-2xl p-6 text-center transition cursor-pointer bg-slate-50/40 hover:bg-slate-50/80 group" id="ktp-dropzone">
                                <input type="file" name="ktp" id="ktp-input" accept="image/*" required
                                       onchange="handleFilePreview('ktp-input', 'ktp-preview', 'ktp-placeholder', 'ktp-preview-img', 'ktp-filename')"
                                       class="hidden">
                                
                                <div id="ktp-placeholder" class="space-y-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 group-hover:bg-blue-50 text-slate-400 group-hover:text-[#1a6bbf] mx-auto flex items-center justify-center transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-700">
                                        Klik untuk memilih foto atau seret berkas KTP ke sini
                                    </p>
                                    <p class="text-[11px] text-slate-400 max-w-sm mx-auto">
                                        Pastikan NIK, nama lengkap, dan foto pada KTP terlihat tajam tanpa pantulan cahaya.
                                    </p>
                                </div>

                                <div id="ktp-preview" class="hidden">
                                    <div class="relative inline-block border border-slate-200 rounded-xl overflow-hidden shadow-xs bg-white p-1">
                                        <img id="ktp-preview-img" src="" class="max-h-44 mx-auto rounded-lg object-contain">
                                    </div>
                                    <p id="ktp-filename" class="text-xs font-semibold text-slate-700 mt-2 font-mono"></p>
                                    <button type="button" onclick="document.getElementById('ktp-input').click()"
                                            class="text-xs text-[#1a6bbf] hover:underline font-bold mt-1 inline-flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                        </svg>
                                        Ganti Foto KTP
                                    </button>
                                </div>
                            </div>
                            <script>document.getElementById('ktp-dropzone').onclick = function(e){ if(e.target.tagName !== 'BUTTON') document.getElementById('ktp-input').click(); }</script>
                            @error('ktp')
                                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Input 3: Upload Surat Legalitas / SK Pengelola --}}
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <label class="block text-xs font-bold uppercase tracking-wider text-slate-700">
                                    Dokumen Legalitas / Surat Tugas / SK Pengelola <span class="text-red-500">*</span>
                                </label>
                                <span class="text-[11px] font-semibold text-slate-400">PDF, JPG, PNG • Maks. 10 MB</span>
                            </div>

                            <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl mb-3 text-xs text-slate-600 leading-relaxed">
                                <p class="font-bold text-slate-800 mb-1 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Dokumen sah yang dapat dilampirkan (Pilih salah satu):
                                </p>
                                <ul class="list-disc list-inside space-y-0.5 text-slate-500 pl-1">
                                    <li>Nomor Induk Berusaha (NIB) berbasis risiko pariwisata.</li>
                                    <li>Surat Keputusan (SK) Pengurus Pokdarwis / Pengelola Wisata.</li>
                                    <li>Surat Rekomendasi / Keterangan Hak Kelola dari Pemerintah Desa / Kelurahan.</li>
                                    <li>Akta Pendirian Badan Usaha / Perjanjian Kerjasama (PKS) pemanfaatan lahan.</li>
                                </ul>
                            </div>

                            <div class="border-2 border-dashed border-slate-200 hover:border-[#1a6bbf]/60 rounded-2xl p-6 text-center transition cursor-pointer bg-slate-50/40 hover:bg-slate-50/80 group" id="surat-dropzone">
                                <input type="file" name="surat" id="surat-input" accept="image/*,application/pdf" required
                                       onchange="handleFilePreview('surat-input', 'surat-preview', 'surat-placeholder', 'surat-preview-img', 'surat-filename')"
                                       class="hidden">
                                
                                <div id="surat-placeholder" class="space-y-2">
                                    <div class="w-12 h-12 rounded-full bg-slate-100 group-hover:bg-blue-50 text-slate-400 group-hover:text-[#1a6bbf] mx-auto flex items-center justify-center transition">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <p class="text-xs sm:text-sm font-bold text-slate-700">
                                        Pilih berkas dokumen legalitas (PDF atau Gambar)
                                    </p>
                                    <p class="text-[11px] text-slate-400">
                                        Dokumen bertanda tangan basah atau berkop resmi sangat mempercepat proses persetujuan.
                                    </p>
                                </div>

                                <div id="surat-preview" class="hidden">
                                    <div class="inline-flex items-center gap-3 p-3 bg-white border border-slate-200 rounded-xl shadow-xs text-left max-w-md mx-auto">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-[#1a6bbf] shrink-0">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                        </div>
                                        <div class="overflow-hidden">
                                            <p id="surat-filename" class="text-xs font-bold text-slate-800 truncate"></p>
                                            <span class="text-[11px] text-emerald-600 font-semibold">Berkas siap diverifikasi</span>
                                        </div>
                                    </div>
                                    <div>
                                        <button type="button" onclick="document.getElementById('surat-input').click()"
                                                class="text-xs text-[#1a6bbf] hover:underline font-bold mt-2 inline-flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                            </svg>
                                            Ganti Berkas Dokumen
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <script>document.getElementById('surat-dropzone').onclick = function(e){ if(e.target.tagName !== 'BUTTON') document.getElementById('surat-input').click(); }</script>
                            @error('surat')
                                <p class="text-xs text-red-500 font-semibold mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Pakta Integritas / Pernyataan --}}
                        <div class="p-4 bg-slate-50 border border-slate-200/80 rounded-xl">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" required class="mt-1 rounded border-slate-300 text-[#1a6bbf] focus:ring-[#1a6bbf]">
                                <span class="text-xs text-slate-700 leading-relaxed">
                                    Saya menyatakan secara sadar dan sah bahwa seluruh data dan dokumen yang saya unggah adalah benar, asli, dan dapat dipertanggungjawabkan secara hukum. Sebagai pengelola, saya berkomitmen menjaga transparansi informasi destinasi dan mendukung pariwisata berkelanjutan di Kabupaten Sukabumi.
                                </span>
                            </label>
                        </div>

                        {{-- Error List --}}
                        @if(isset($errors) && $errors->any())
                            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-xs space-y-1">
                                <div class="font-bold flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Terdapat data yang belum lengkap:
                                </div>
                                <ul class="list-disc list-inside pl-1 text-red-700">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Action Buttons --}}
                        <div class="pt-2 flex flex-col sm:flex-row items-center gap-3">
                            <button type="submit"
                                    class="w-full sm:w-auto px-8 py-3.5 bg-[#163766] hover:bg-[#0f274a] text-white font-bold rounded-xl transition shadow-md text-sm flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-[#f8be2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Kirim Pengajuan Verifikasi
                            </button>

                            <a href="{{ route('place.show', $place->slug) }}"
                               class="w-full sm:w-auto px-6 py-3.5 text-center text-slate-600 hover:text-slate-900 font-semibold text-sm transition">
                                Batal & Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ── KOLOM KANAN: IDENTITAS DESTINASI & BENEFIT MITRA (5 COLS) ── --}}
            <div class="lg:col-span-5 space-y-6 lg:sticky lg:top-24">

                {{-- 1. Kartu Profil Destinasi --}}
                <div class="bg-white border border-slate-200/90 rounded-2xl overflow-hidden shadow-xs">
                    <div class="h-48 relative bg-slate-800">
                        <img src="{{ $place->cover_image_url }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 via-slate-950/30 to-transparent"></div>
                        <div class="absolute bottom-4 left-4 right-4 text-white">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-blue-300">
                                {{ optional($place->category)->name ?? 'Destinasi Wisata' }}
                            </span>
                            <h3 class="text-lg font-black text-white leading-tight mt-0.5">
                                {{ $place->name }}
                            </h3>
                            <p class="text-xs text-slate-300 mt-1 flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5 text-slate-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span>{{ $place->district ? 'Kecamatan ' . $place->district : 'Kabupaten Sukabumi' }}</span>
                            </p>
                        </div>
                    </div>

                    <div class="p-5 border-t border-slate-100 space-y-3">
                        <div class="flex items-center justify-between text-xs">
                            <span class="text-slate-500 font-medium">Status Kepemilikan:</span>
                            <span class="font-bold text-amber-700 bg-amber-50 px-2.5 py-0.5 rounded-md border border-amber-200/60">
                                Terbuka untuk Diklaim
                            </span>
                        </div>
                        @if($place->address)
                            <div class="text-xs text-slate-600 leading-relaxed pt-2 border-t border-slate-100">
                                <span class="font-bold text-slate-700">Alamat Terdaftar:</span> {{ $place->address }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- 2. Privilese & Hak Istimewa Pengelola Resmi --}}
                <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        Hak Istimewa Kemitraan
                    </span>
                    <h3 class="text-base font-extrabold text-slate-900 tracking-tight mb-4">
                        Manfaat Sebagai Mitra Terverifikasi
                    </h3>

                    <div class="space-y-4">
                        {{-- Benefit 1 --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-blue-50 text-[#1a6bbf] flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Akses Penuh Portal Mitra (/kelola)</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Kelola jam operasional, narasi daya tarik, nomor kontak, serta galeri foto secara mandiri.
                                </p>
                            </div>
                        </div>

                        {{-- Benefit 2 --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-emerald-50 text-emerald-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Penjualan Tiket & Kamar Terpadu</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Fasilitas transaksi online langsung dengan e-tiket dan transparansi pajak daerah PBJT 10%.
                                </p>
                            </div>
                        </div>

                        {{-- Benefit 3 --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-amber-50 text-amber-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Lencana Tanggapan Ulasan Resmi</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Balas ulasan wisatawan langsung dengan tanda verifikasi resmi untuk membangun reputasi destinasi.
                                </p>
                            </div>
                        </div>

                        {{-- Benefit 4 --}}
                        <div class="flex items-start gap-3.5">
                            <div class="w-8 h-8 rounded-lg bg-indigo-50 text-indigo-600 flex items-center justify-center shrink-0 mt-0.5">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-xs font-bold text-slate-900">Workstation Tamu & Data Kunjungan</h4>
                                <p class="text-xs text-slate-500 leading-relaxed mt-0.5">
                                    Pantau folios kedatangan tamu, check-in harian, dan ringkasan pendapatan bersih secara real-time.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. Alur Verifikasi Transparan --}}
                <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-xs">
                    <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500 block mb-1">
                        Standar Prosedur
                    </span>
                    <h3 class="text-sm font-extrabold text-slate-900 tracking-tight mb-4">
                        Tahapan Verifikasi Legalitas
                    </h3>

                    <div class="relative pl-6 space-y-5 border-l border-slate-200 ml-2 text-xs">
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-[#163766] border-2 border-white shadow-xs"></div>
                            <h4 class="font-bold text-slate-900">1. Pengajuan Berkas Digital</h4>
                            <p class="text-slate-500 mt-0.5 leading-relaxed">
                                Pengelola mengunggah KTP dan berkas legalitas resmi melalui formulir ini.
                            </p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 border-2 border-white"></div>
                            <h4 class="font-bold text-slate-900">2. Validasi Tim Visit Sukabumi</h4>
                            <p class="text-slate-500 mt-0.5 leading-relaxed">
                                Proses pengecekan kelayakan dokumen dan koordinasi via WhatsApp (Estimasi 1×24 Jam).
                            </p>
                        </div>
                        <div class="relative">
                            <div class="absolute -left-[31px] top-0.5 w-4 h-4 rounded-full bg-slate-300 border-2 border-white"></div>
                            <h4 class="font-bold text-slate-900">3. Hak Akses Portal Diberikan</h4>
                            <p class="text-slate-500 mt-0.5 leading-relaxed">
                                Notifikasi persetujuan dikirim, destinasi resmi berstatus terverifikasi, dan fitur kelola terbuka.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- 4. Helpdesk Kemitraan --}}
                <div class="bg-blue-50/70 border border-blue-200/80 rounded-2xl p-5 text-xs text-blue-900">
                    <h4 class="font-bold text-sm text-[#0f294a] flex items-center gap-1.5 mb-1.5">
                        <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192l-3.536 3.536M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        Pusat Bantuan & Asistensi Kemitraan
                    </h4>
                    <p class="text-blue-800/80 leading-relaxed mb-3">
                        Mengalami kendala dokumen SK atau membutuhkan konfirmasi lanjutan? Tim sekretariat pariwisata siap mendampingi proses klaim destinasi Anda.
                    </p>
                    <a href="https://wa.me/6281234567890?text={{ urlencode('Halo Admin Visit Sukabumi, saya ingin berkonsultasi mengenai klaim pengelolaan destinasi ' . $place->name) }}" target="_blank"
                       class="inline-flex items-center gap-2 bg-[#128c7e] hover:bg-[#075e54] text-white font-bold px-4 py-2 rounded-xl transition text-xs shadow-xs">
                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24">
                            <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                        </svg>
                        <span>WhatsApp Helpdesk</span>
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>

@include('components.footer')

<script>
function handleFilePreview(inputId, previewId, placeholderId, imgId, nameId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);
    const imgEl = imgId ? document.getElementById(imgId) : null;
    const nameEl = nameId ? document.getElementById(nameId) : null;

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    placeholder.classList.add('hidden');
    preview.classList.remove('hidden');

    if (nameEl) {
        nameEl.textContent = file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + ' MB)';
    }

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = function(e) {
            if (imgEl) {
                imgEl.src = e.target.result;
                imgEl.style.display = 'block';
            }
        };
        reader.readAsDataURL(file);
    } else {
        if (imgEl) {
            imgEl.style.display = 'none';
        }
    }
}
</script>
@endsection
