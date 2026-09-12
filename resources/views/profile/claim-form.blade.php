@extends('layouts.app')

@section('title', 'Klaim Destinasi: ' . $place->name . ' — Visit Sukabumi')
@section('meta_description', 'Ajukan klaim kepemilikan destinasi ' . $place->name . ' di Visit Sukabumi.')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans">
    @include('components.navbar')

    <div class="pt-20 pb-16 max-w-3xl mx-auto px-4 sm:px-6">

        {{-- Breadcrumb --}}
        <div class="flex items-center gap-2 text-sm text-gray-400 mb-6 pt-4">
            <a href="{{ route('place.show', $place->slug) }}" class="hover:text-[#1a6bbf] transition">{{ $place->name }}</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-gray-600 font-medium">Klaim Kepemilikan</span>
        </div>

        {{-- Header --}}
        <div class="bg-gradient-to-br from-[#0f4c81] to-[#1a6bbf] rounded-3xl p-8 mb-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-48 h-48 rounded-full bg-white/5 -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10 flex items-center gap-5">
                <div class="w-20 h-20 rounded-2xl overflow-hidden border-2 border-white/30 flex-shrink-0">
                    <img src="{{ $place->cover_image_url }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                </div>
                <div>
                    <p class="text-blue-200 text-sm mb-1">Mengajukan klaim untuk</p>
                    <h1 class="text-2xl font-extrabold">{{ $place->name }}</h1>
                    <p class="text-blue-200 text-sm">{{ $place->district }}</p>
                </div>
            </div>
        </div>

        {{-- Info Box --}}
        <div class="bg-blue-50 border border-blue-200 rounded-2xl p-5 mb-6 flex gap-3">
            <svg class="w-5 h-5 text-[#1a6bbf] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-bold mb-1">Cara Kerja Klaim Destinasi</p>
                <ol class="list-decimal list-inside space-y-0.5 text-blue-700">
                    <li>Unggah foto KTP dan surat pengelola / NIB / SK Pengelola</li>
                    <li>Tim Visit Sukabumi akan memverifikasi dalam <strong>1×24 jam</strong></li>
                    <li>Jika disetujui, Anda mendapat akses <strong>Portal Mitra</strong> untuk mengelola destinasi</li>
                </ol>
            </div>
        </div>

        {{-- Form --}}
        <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-7">
            <h2 class="font-bold text-gray-900 text-lg mb-6">Formulir Pengajuan Klaim</h2>

            <form action="{{ route('claim.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="place_id" value="{{ $place->id }}">

                {{-- Nomor WA --}}
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Nomor WhatsApp Aktif <span class="text-red-400">*</span>
                    </label>
                    <input type="tel" name="applicant_phone" required
                           value="{{ old('applicant_phone', auth()->user()->phone) }}"
                           placeholder="Contoh: 0812-3456-7890"
                           class="w-full border border-gray-200 rounded-xl px-4 py-3 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                    <p class="text-xs text-gray-400 mt-1">Kami akan menghubungi Anda melalui WhatsApp ini untuk koordinasi verifikasi.</p>
                    @error('applicant_phone')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload KTP --}}
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Foto KTP (Kartu Tanda Penduduk) <span class="text-red-400">*</span>
                    </label>
                    <div class="border-2 border-dashed border-gray-200 hover:border-[#1a6bbf]/40 rounded-xl p-5 text-center transition cursor-pointer" id="ktp-dropzone">
                        <input type="file" name="ktp" id="ktp-input" accept="image/*" required
                               onchange="updateFilePreview('ktp-input', 'ktp-preview', 'ktp-placeholder')"
                               class="hidden">
                        <div id="ktp-placeholder">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/>
                            </svg>
                            <p class="text-sm text-gray-500">Klik untuk upload foto KTP</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG. Maks. 5 MB. Pastikan semua teks terbaca jelas.</p>
                        </div>
                        <div id="ktp-preview" class="hidden">
                            <img id="ktp-preview-img" src="" class="max-h-40 mx-auto rounded-lg object-contain">
                            <p class="text-xs text-[#1a6bbf] font-bold mt-2 cursor-pointer" onclick="document.getElementById('ktp-input').click()">Ganti Foto</p>
                        </div>
                    </div>
                    <script>document.getElementById('ktp-dropzone').onclick = function(){ document.getElementById('ktp-input').click(); }</script>
                    @error('ktp')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Upload Surat --}}
                <div class="mb-5">
                    <label class="block text-sm font-bold text-gray-700 mb-1.5">
                        Surat Pengelola / NIB / SK <span class="text-red-400">*</span>
                    </label>
                    <p class="text-xs text-gray-400 mb-2">Bisa berupa: Nomor Induk Berusaha (NIB), Surat Keputusan Pengelola, Surat Tugas dari Desa/Kelurahan, atau dokumen resmi lainnya.</p>
                    <div class="border-2 border-dashed border-gray-200 hover:border-[#1a6bbf]/40 rounded-xl p-5 text-center transition cursor-pointer" id="surat-dropzone">
                        <input type="file" name="surat" id="surat-input" accept="image/*,application/pdf" required
                               onchange="updateFilePreview('surat-input', 'surat-preview', 'surat-placeholder')"
                               class="hidden">
                        <div id="surat-placeholder">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <p class="text-sm text-gray-500">Klik untuk upload surat pengelola</p>
                            <p class="text-xs text-gray-400 mt-1">JPG, PNG, PDF. Maks. 10 MB.</p>
                        </div>
                        <div id="surat-preview" class="hidden">
                            <img id="surat-preview-img" src="" class="max-h-40 mx-auto rounded-lg object-contain">
                            <p id="surat-preview-name" class="text-sm text-gray-600 mt-2"></p>
                            <p class="text-xs text-[#1a6bbf] font-bold mt-1 cursor-pointer" onclick="document.getElementById('surat-input').click()">Ganti File</p>
                        </div>
                    </div>
                    <script>document.getElementById('surat-dropzone').onclick = function(){ document.getElementById('surat-input').click(); }</script>
                    @error('surat')
                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Pernyataan --}}
                <div class="mb-6">
                    <label class="flex items-start gap-3 cursor-pointer">
                        <input type="checkbox" required class="mt-0.5 rounded border-gray-300 text-[#1a6bbf] focus:ring-[#1a6bbf]">
                        <span class="text-sm text-gray-600">
                            Saya menyatakan bahwa informasi yang saya berikan adalah benar dan sah. Saya bertanggung jawab atas pengelolaan destinasi ini dan akan menjaga kualitas informasi di Visit Sukabumi.
                        </span>
                    </label>
                </div>

                @if($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-sm">
                    @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                    @endforeach
                </div>
                @endif

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-7 py-3 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold rounded-xl transition shadow-sm text-sm">
                        Kirim Pengajuan Klaim
                    </button>
                    <a href="{{ route('place.show', $place->slug) }}"
                       class="px-5 py-3 text-gray-600 hover:text-gray-900 font-medium text-sm transition">
                        Batal
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

@include('components.footer')

<script>
function updateFilePreview(inputId, previewId, placeholderId) {
    const input = document.getElementById(inputId);
    const preview = document.getElementById(previewId);
    const placeholder = document.getElementById(placeholderId);

    if (!input.files || !input.files[0]) return;

    const file = input.files[0];
    placeholder.classList.add('hidden');
    preview.classList.remove('hidden');

    if (file.type.startsWith('image/')) {
        const reader = new FileReader();
        reader.onload = e => {
            const img = preview.querySelector('img');
            if (img) img.src = e.target.result;
            const nameEl = preview.querySelector('[id$="-name"]');
            if (nameEl) nameEl.textContent = '';
        };
        reader.readAsDataURL(file);
    } else {
        // PDF: show filename only
        const img = preview.querySelector('img');
        if (img) img.style.display = 'none';
        const nameEl = preview.querySelector('[id$="-name"]');
        if (nameEl) nameEl.textContent = file.name;
    }
}
</script>
@endsection
