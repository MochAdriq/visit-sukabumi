@extends('layouts.app')

@section('title', 'Profil Saya — Visit Sukabumi')
@section('meta_description', 'Kelola profil, lihat wishlist, dan akses portal mitra Visit Sukabumi.')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900">
    @include('components.navbar')

    {{-- HERO HEADER PROFIL --}}
    <div class="bg-gradient-to-br from-[#0f4c81] via-[#1a6bbf] to-[#2196f3] pt-16 pb-32 relative overflow-hidden">
        {{-- Decorative bg patterns --}}
        <div class="absolute inset-0 opacity-10">
            <svg viewBox="0 0 1440 320" class="absolute bottom-0 left-0 w-full">
                <path fill="white" fill-opacity="1" d="M0,192L48,197.3C96,203,192,213,288,229.3C384,245,480,267,576,261.3C672,256,768,224,864,213.3C960,203,1056,213,1152,218.7C1248,224,1344,224,1392,224L1440,224L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path>
            </svg>
        </div>

        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col sm:flex-row items-center gap-6">
                {{-- Avatar --}}
                <div class="relative group">
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                         class="w-24 h-24 md:w-28 md:h-28 rounded-2xl object-cover border-4 border-white shadow-xl">
                    <div class="absolute inset-0 rounded-2xl bg-black/0 group-hover:bg-black/20 transition flex items-center justify-center">
                        <label for="avatar-upload-quick" class="cursor-pointer opacity-0 group-hover:opacity-100 transition">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                        </label>
                    </div>
                </div>

                {{-- Info User --}}
                <div class="text-center sm:text-left">
                    <div class="flex items-center gap-2 justify-center sm:justify-start flex-wrap">
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white">{{ $user->name }}</h1>
                        @if($user->isMitra())
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full bg-white/20 border border-white/30 text-white text-xs font-bold backdrop-blur-sm">
                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                            </svg>
                            Mitra Terverifikasi
                        </span>
                        @endif
                    </div>
                    <p class="text-blue-200 mt-1">{{ $user->email }}</p>
                    @if($user->bio)
                    <p class="text-blue-100 mt-2 text-sm max-w-md">{{ $user->bio }}</p>
                    @endif
                </div>

                {{-- Tombol Portal Mitra jika disetujui --}}
                @if($user->isMitra())
                <div class="sm:ml-auto">
                    <a href="/kelola" target="_blank"
                       class="inline-flex items-center gap-2 px-5 py-3 bg-white text-[#1a6bbf] font-bold rounded-xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all text-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Buka Portal Mitra
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- CONTENT --}}
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 -mt-16 relative z-10 pb-20">

        {{-- Flash Messages --}}
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 text-green-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-sm">
            <svg class="w-5 h-5 text-red-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
            </svg>
            {{ session('error') }}
        </div>
        @endif

        {{-- TAB NAVIGATION --}}
        <div x-data="{ tab: '{{ request('tab', 'profil') }}' }" class="space-y-6">

            {{-- Tab Pills --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-1.5 flex gap-1">
                @foreach(['profil' => 'Informasi Akun', 'destinasi' => 'Destinasi Saya', 'aktivitas' => 'Aktivitas Wisata'] as $key => $label)
                <button @click="tab = '{{ $key }}'"
                        :class="tab === '{{ $key }}' ? 'bg-[#1a6bbf] text-white shadow-sm' : 'text-gray-600 hover:bg-gray-50'"
                        class="flex-1 px-4 py-2.5 rounded-xl text-sm font-bold transition-all">
                    {{ $label }}
                </button>
                @endforeach
            </div>

            {{-- ══════════ TAB 1: INFORMASI AKUN ══════════ --}}
            <div x-show="tab === 'profil'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- Edit Profil --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:col-span-2">
                    <h2 class="font-bold text-gray-900 text-lg mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Informasi Pribadi
                    </h2>
                    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            {{-- Avatar Upload --}}
                            <div class="md:col-span-2 flex items-center gap-5">
                                <img id="avatar-preview" src="{{ $user->avatar_url }}" class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-200">
                                <div>
                                    <label class="block text-sm font-bold text-gray-700 mb-1">Foto Profil</label>
                                    <input type="file" id="avatar-upload-quick" name="avatar" accept="image/*"
                                           onchange="previewAvatar(this)"
                                           class="block w-full text-sm text-gray-500 file:mr-3 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-[#1a6bbf] hover:file:bg-blue-100 transition">
                                    <p class="text-xs text-gray-400 mt-1">JPG, PNG, WebP. Maks. 2 MB.</p>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Nama Lengkap <span class="text-red-400">*</span></label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                            </div>

                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">No. Telepon / WhatsApp</label>
                                <input type="tel" name="phone" value="{{ old('phone', $user->phone) }}"
                                       placeholder="+62 812 3456 7890"
                                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-700 mb-1">Bio Singkat</label>
                                <textarea name="bio" rows="3" placeholder="Ceritakan sedikit tentang diri Anda..."
                                          class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition resize-none">{{ old('bio', $user->bio) }}</textarea>
                                <p class="text-xs text-gray-400 mt-1">Maks. 500 karakter.</p>
                            </div>
                        </div>

                        @if($errors->any())
                        <div class="mt-3 text-sm text-red-600">
                            @foreach($errors->all() as $error)
                            <p>{{ $error }}</p>
                            @endforeach
                        </div>
                        @endif

                        <div class="mt-5">
                            <button type="submit"
                                    class="px-6 py-2.5 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold rounded-xl transition text-sm shadow-sm">
                                Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Ganti Password --}}
                <div id="tab-keamanan" class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 md:col-span-2">
                    <h2 class="font-bold text-gray-900 text-lg mb-5 flex items-center gap-2">
                        <svg class="w-5 h-5 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                        Keamanan Akun
                    </h2>
                    <form action="{{ route('profile.password') }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Password Saat Ini</label>
                                <input type="password" name="current_password" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                                @error('current_password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Password Baru</label>
                                <input type="password" name="password" required minlength="8"
                                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-700 mb-1">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation" required
                                       class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none transition">
                            </div>
                        </div>
                        <div class="mt-5">
                            <button type="submit"
                                    class="px-6 py-2.5 bg-gray-800 hover:bg-gray-900 text-white font-bold rounded-xl transition text-sm">
                                Ganti Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- ══════════ TAB 2: DESTINASI SAYA ══════════ --}}
            <div x-show="tab === 'destinasi'" x-cloak class="space-y-5">

                {{-- Status Klaim Aktif --}}
                @if($pendingClaim)
                {{-- Pending --}}
                <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-amber-100 flex items-center justify-center text-amber-600 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-amber-900">Pengajuan Klaim Sedang Ditinjau</h3>
                        <p class="text-sm text-amber-700 mt-0.5">
                            Pengajuan Anda untuk <strong>{{ $pendingClaim->place->name }}</strong> sedang diproses oleh tim Visit Sukabumi.
                            Kami akan memeriksa berkas dalam <strong>1×24 jam</strong>.
                        </p>
                        <form action="{{ route('claim.destroy', $pendingClaim->id) }}" method="POST" class="mt-3"
                              onsubmit="return confirm('Yakin ingin membatalkan pengajuan klaim ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-xs font-bold text-amber-600 hover:text-amber-800 underline">
                                Batalkan Pengajuan
                            </button>
                        </form>
                    </div>
                </div>

                @elseif($rejectedClaim && $approvedClaims->count() === 0)
                {{-- Rejected --}}
                <div class="bg-red-50 border border-red-200 rounded-2xl p-5 flex gap-4">
                    <div class="w-10 h-10 rounded-xl bg-red-100 flex items-center justify-center text-red-500 flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="font-bold text-red-900">Pengajuan Klaim Ditolak</h3>
                        <p class="text-sm text-red-700 mt-0.5">
                            Klaim untuk <strong>{{ $rejectedClaim->place->name }}</strong> tidak disetujui.
                        </p>
                        @if($rejectedClaim->admin_notes)
                        <div class="mt-2 bg-red-100 rounded-lg px-3 py-2 text-sm text-red-800">
                            <span class="font-bold">Alasan:</span> {{ $rejectedClaim->admin_notes }}
                        </div>
                        @endif
                        <a href="{{ route('claim.create', $rejectedClaim->place->slug) }}" class="mt-3 inline-flex items-center gap-1 text-xs font-bold text-red-600 hover:text-red-800 underline">
                            Ajukan Ulang dengan Dokumen Baru
                        </a>
                    </div>
                </div>
                @endif

                {{-- Destinasi Terverifikasi --}}
                @foreach($approvedClaims as $approvedClaim)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    @if($approvedClaim->place->primaryImage)
                    <div class="h-32 bg-gray-100 overflow-hidden">
                        <img src="{{ $approvedClaim->place->cover_image_url }}" class="w-full h-full object-cover">
                    </div>
                    @endif
                    <div class="p-5 flex items-center gap-4">
                        <div class="flex-1">
                            <div class="flex items-center gap-2 flex-wrap">
                                <h3 class="font-bold text-gray-900">{{ $approvedClaim->place->name }}</h3>
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-50 border border-green-200 text-green-700 text-xs font-bold">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi
                                </span>
                            </div>
                            <p class="text-sm text-gray-500 mt-0.5">{{ $approvedClaim->place->district }}</p>
                        </div>
                        <a href="/kelola" target="_blank"
                           class="inline-flex items-center gap-2 px-4 py-2.5 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold rounded-xl transition text-sm shadow-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Kelola
                        </a>
                    </div>
                </div>
                @endforeach

                {{-- Ajakan klaim jika belum ada klaim sama sekali --}}
                @if($approvedClaims->count() === 0 && !$pendingClaim)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8 text-center">
                    <div class="w-16 h-16 rounded-2xl bg-blue-50 flex items-center justify-center mx-auto mb-4 text-[#1a6bbf]">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-lg mb-2">Kelola Destinasi Wisata Anda</h3>
                    <p class="text-gray-500 text-sm mb-6 max-w-sm mx-auto">
                        Apakah Anda mengelola destinasi wisata di Sukabumi? Klaim kepemilikan untuk memperbarui informasi dan merespons ulasan pengunjung.
                    </p>
                    <a href="{{ route('place.index') }}"
                       class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold rounded-xl transition text-sm shadow-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cari Destinasi untuk Diklaim
                    </a>
                </div>
                @endif
            </div>

            {{-- ══════════ TAB 3: AKTIVITAS WISATA ══════════ --}}
            <div x-show="tab === 'aktivitas'" x-cloak class="space-y-5">

                {{-- Wishlist --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-bold text-gray-900 text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-red-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        Wishlist Saya ({{ $wishlistedPlaces->count() }})
                    </h2>
                    @if($wishlistedPlaces->count() > 0)
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                        @foreach($wishlistedPlaces as $wPlace)
                        <a href="{{ route('place.show', $wPlace->slug) }}"
                           class="group rounded-xl overflow-hidden border border-gray-100 hover:border-[#1a6bbf]/30 hover:shadow-md transition-all">
                            <div class="h-28 bg-gray-100 overflow-hidden">
                                <img src="{{ $wPlace->cover_image_url }}" alt="{{ $wPlace->name }}"
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            </div>
                            <div class="p-3">
                                <h4 class="font-bold text-sm text-gray-900 leading-snug line-clamp-1">{{ $wPlace->name }}</h4>
                                <p class="text-xs text-gray-400">{{ $wPlace->district }}</p>
                            </div>
                        </a>
                        @endforeach
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('wishlist.index') }}" class="text-sm font-bold text-[#1a6bbf] hover:underline">
                            Lihat Semua Wishlist →
                        </a>
                    </div>
                    @else
                    <p class="text-sm text-gray-400 text-center py-8">Belum ada destinasi di wishlist. <a href="{{ route('place.index') }}" class="text-[#1a6bbf] font-bold hover:underline">Jelajahi sekarang!</a></p>
                    @endif
                </div>

                {{-- Riwayat Ulasan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="font-bold text-gray-900 text-lg mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                        Ulasan yang Saya Tulis ({{ $userReviews->count() }})
                    </h2>
                    @if($userReviews->count() > 0)
                    <div class="space-y-4">
                        @foreach($userReviews as $rev)
                        <div class="flex gap-3 p-4 rounded-xl bg-gray-50">
                            @if($rev->place)
                            <img src="{{ $rev->place->cover_image_url }}" class="w-14 h-14 rounded-xl object-cover flex-shrink-0">
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center justify-between flex-wrap gap-1">
                                    @if($rev->place)
                                    <a href="{{ route('place.show', $rev->place->slug) }}" class="font-bold text-sm text-gray-900 hover:text-[#1a6bbf] transition">
                                        {{ $rev->place->name }}
                                    </a>
                                    @endif
                                    <div class="flex gap-0.5">
                                        @for($i = 1; $i <= 5; $i++)
                                        <svg class="w-3.5 h-3.5 {{ $i <= $rev->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                        </svg>
                                        @endfor
                                    </div>
                                </div>
                                <p class="text-sm text-gray-600 mt-1">{{ $rev->content }}</p>
                                <p class="text-xs text-gray-400 mt-1">{{ $rev->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <p class="text-sm text-gray-400 text-center py-8">Belum ada ulasan. Bagikan pengalaman wisata Anda!</p>
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>

@include('components.footer')

<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('avatar-preview').src = e.target.result;
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
