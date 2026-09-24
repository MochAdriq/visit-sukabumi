@extends('layouts.app')

@section('title', 'Masuk ke Akun — Visit Sukabumi')
@section('meta_description', 'Masuk ke akun Visit Sukabumi Anda untuk menyimpan wishlist destinasi, memesan tiket acara, dan membagikan ulasan penjelajahan.')

@section('content')
{{-- CSS Khusus Animasi Ken Burns --}}
<style>
    @keyframes kenBurnsZoomIn {
        0% { transform: scale(1.0); }
        100% { transform: scale(1.16); }
    }
    @keyframes kenBurnsZoomOut {
        0% { transform: scale(1.16); }
        100% { transform: scale(1.0); }
    }
    .animate-ken-burns-in {
        animation: kenBurnsZoomIn 8.5s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
    .animate-ken-burns-out {
        animation: kenBurnsZoomOut 8.5s cubic-bezier(0.25, 1, 0.5, 1) forwards;
    }
</style>

<div class="min-h-screen w-full bg-[#FAF9F5] flex flex-col lg:flex-row antialiased">

    {{-- ══ SISI KIRI: Visual Showcase Wisata Alam Sukabumi dengan Slideshow & Animasi Ken Burns ══ --}}
    <div x-data="{
            active: 0,
            slides: [
                {
                    image: '{{ asset('assets/images/3.jpg') }}',
                    alt: 'Curug Cikaso, Geopark Ciletuh',
                    location: 'Curug Cikaso — UNESCO Global Geopark Ciletuh',
                    zoomType: 'zoom-in'
                },
                {
                    image: '{{ asset('assets/images/6.jpg') }}',
                    alt: 'Pesisir Samudra Selatan Sukabumi',
                    location: 'Pesisir Pantai Ujung Genteng & Palabuhanratu',
                    zoomType: 'zoom-out'
                },
                {
                    image: '{{ asset('assets/images/12.jpg') }}',
                    alt: 'Panorama Dataran Tinggi Sukabumi',
                    location: 'Panorama Perbukitan & Alam Terbuka Sukabumi',
                    zoomType: 'zoom-in'
                }
            ],
            timer: null,
            startSlideshow() {
                this.timer = setInterval(() => {
                    this.active = (this.active + 1) % this.slides.length;
                }, 8000);
            },
            init() {
                this.startSlideshow();
            }
        }" 
        class="hidden lg:relative lg:flex lg:w-7/12 xl:w-7/12 flex-col justify-between p-12 bg-slate-950 text-white overflow-hidden select-none">
        
        {{-- Layer Slideshow Background Images --}}
        <template x-for="(slide, index) in slides" :key="index">
            <div class="absolute inset-0 transition-opacity duration-1000 ease-in-out pointer-events-none"
                 :class="active === index ? 'opacity-100 z-[1]' : 'opacity-0 z-0'">
                <img :src="slide.image" 
                     :alt="slide.alt" 
                     class="w-full h-full object-cover object-center"
                     :class="{
                         'animate-ken-burns-in': active === index && slide.zoomType === 'zoom-in',
                         'animate-ken-burns-out': active === index && slide.zoomType === 'zoom-out'
                     }">
            </div>
        </template>

        {{-- Vignette & Deep Navy Overlay --}}
        <div class="absolute inset-0 z-[2] bg-gradient-to-t from-[#0B1B33]/95 via-[#0B1B33]/45 to-[#0B1B33]/30 pointer-events-none"></div>

        {{-- Header Kiri: Logo Resmi Navbar --}}
        <div class="relative z-10">
            <a href="{{ url('/') }}" class="inline-block group">
                <img src="{{ asset('images/logo-v2.png') }}" 
                     alt="Visit Sukabumi" 
                     class="h-12 xl:h-14 w-auto object-contain drop-shadow-lg group-hover:opacity-90 transition-opacity">
            </a>
        </div>

        {{-- Footer Kiri: Editorial Travel Caption --}}
        <div class="relative z-10 max-w-xl space-y-4">

            <h2 class="text-3xl xl:text-4xl font-black leading-tight text-white tracking-tight">
                Jelajahi Surga Tersembunyi di Selatan Jawa Barat.
            </h2>

            <p class="text-sm text-slate-200 leading-relaxed font-normal">
                Satu akun untuk menyimpan destinasi impian Anda, memesan tiket acara budaya dan hotel dengan transparansi pajak resmi, serta berbagi ulasan otentik bersama ribuan penjelajah lainnya.
            </p>

            {{-- Indikator Slide & 3 Nilai Layanan --}}
            <div class="pt-4 border-t border-white/15 space-y-4">
                {{-- Slide Dots --}}
                <div class="flex items-center gap-1.5">
                    <template x-for="(slide, i) in slides" :key="i">
                        <button type="button" @click="active = i" 
                                class="h-1.5 rounded-full transition-all duration-300"
                                :class="active === i ? 'w-6 bg-[#F8BE2C]' : 'w-1.5 bg-white/40 hover:bg-white/70'"></button>
                    </template>
                </div>

                <div class="grid grid-cols-3 gap-4">
                    <div>
                        <div class="text-lg font-black text-[#F8BE2C]">120+</div>
                        <div class="text-xs text-slate-300 mt-0.5">Destinasi Terverifikasi</div>
                    </div>
                    <div>
                        <div class="text-lg font-black text-[#F8BE2C]">100%</div>
                        <div class="text-xs text-slate-300 mt-0.5">Pajak Daerah Resmi</div>
                    </div>
                    <div>
                        <div class="text-lg font-black text-[#F8BE2C]">Otentik</div>
                        <div class="text-xs text-slate-300 mt-0.5">Ulasan dari Wisatawan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- ══ SISI KANAN: Form Autentikasi Pengguna (Bersih, Hangat, & Aksesibel) ══ --}}
    <div class="w-full lg:w-5/12 flex flex-col justify-between p-6 sm:p-10 lg:p-12 xl:p-16">
        
        {{-- Top Bar: Kembali ke Beranda & Logo Mobile --}}
        <div class="flex items-center justify-between">
            <a href="{{ url('/') }}" 
               class="inline-flex items-center gap-2 text-xs sm:text-sm font-semibold text-slate-600 hover:text-[#163766] transition-colors py-2 px-3 -ml-3 rounded-lg hover:bg-slate-100">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span>Kembali ke Beranda</span>
            </a>

            {{-- Logo resmi di Mobile --}}
            <div class="lg:hidden">
                <a href="{{ url('/') }}" class="inline-block">
                    <img src="{{ asset('images/logo-v2.png') }}" 
                         alt="Visit Sukabumi" 
                         class="h-8 sm:h-9 w-auto object-contain">
                </a>
            </div>
        </div>

        {{-- Bagian Tengah: Kartu Autentikasi --}}
        <div class="my-auto py-8 max-w-sm w-full mx-auto">
            
            {{-- Header Form --}}
            <div class="mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 tracking-tight">
                    Masuk & Jelajahi Sukabumi
                </h1>
                <p class="text-sm text-slate-600 mt-2 leading-relaxed">
                    Selalu ada sudut indah dan cerita baru yang menunggumu di sini. Masuk untuk menyimpan destinasi impian, rekomendasi lokal, dan mulai rencanakan liburanmu berikutnya.
                </p>
            </div>

            {{-- Error Flash Notification --}}
            @if ($errors->any())
                <div class="mb-6 bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-xl text-xs">
                    <div class="font-bold mb-1 flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Terjadi Kendala:
                    </div>
                    <ul class="list-disc pl-5 space-y-0.5 text-red-700">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- ══ METODE UTAMA: GOOGLE SIGN-IN RESMI (1-KLIK) ══ --}}
            <div class="space-y-4">
                <a href="{{ route('auth.google', array_filter(['redirect' => request('redirect', session('url.intended'))])) }}"
                   class="w-full flex items-center justify-center gap-3 py-3.5 px-4 rounded-xl text-sm font-bold text-slate-800 bg-white hover:bg-slate-50 border border-slate-300 shadow-sm hover:shadow transition-all duration-150 active:scale-[0.99] group focus:outline-none focus:ring-2 focus:ring-[#163766] focus:ring-offset-2">
                    <svg class="w-5 h-5 flex-shrink-0" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Lanjutkan dengan Akun Google</span>
                </a>
            </div>

            {{-- ══ MODE PENGEMBANGAN / LOCAL LOGIN ══ --}}
            @if(app()->environment('local'))
                <div class="relative flex py-6 items-center">
                    <div class="flex-grow border-t border-slate-200"></div>
                    <span class="flex-shrink mx-3 text-[11px] text-slate-400 uppercase tracking-widest font-semibold">Atau Mode Dev (Email)</span>
                    <div class="flex-grow border-t border-slate-200"></div>
                </div>

                <form action="{{ route('login') }}" method="POST" class="space-y-4">
                    @csrf

                    <div>
                        <label for="email" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1.5">Alamat Email</label>
                        <input id="email" name="email" type="email" autocomplete="email" required value="{{ old('email') }}"
                            class="block w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#163766] focus:border-[#163766] transition text-sm">
                    </div>

                    <div>
                        <div class="flex items-center justify-between mb-1.5">
                            <label for="password" class="block text-xs font-bold text-slate-700 uppercase tracking-wider">Kata Sandi</label>
                            @if(Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs text-[#163766] hover:underline font-semibold">Lupa sandi?</a>
                            @endif
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required
                            class="block w-full px-3.5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-900 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#163766] focus:border-[#163766] transition text-sm">
                    </div>

                    <div class="flex items-center justify-between text-xs pt-1">
                        <label class="flex items-center text-slate-600 cursor-pointer">
                            <input id="remember" name="remember" type="checkbox"
                                class="h-4 w-4 rounded border-slate-300 text-[#163766] focus:ring-[#163766]">
                            <span class="ml-2 font-medium">Ingat perangkat ini</span>
                        </label>
                    </div>

                    <div class="pt-2">
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 rounded-xl text-sm font-bold text-white bg-[#163766] hover:bg-[#122c52] shadow-sm hover:shadow transition duration-150 active:scale-[0.99] focus:outline-none focus:ring-2 focus:ring-[#163766] focus:ring-offset-2">
                            Masuk dengan Email
                        </button>
                    </div>
                </form>

                <div class="mt-6 text-center">
                    <p class="text-xs text-slate-600">
                        Belum punya akun lokal?
                        <a href="{{ route('register') }}" class="font-bold text-[#163766] hover:underline">Daftar sekarang</a>
                    </p>
                </div>
            @endif

        </div>

        {{-- Footer Kanan: Kebijakan & Privasi --}}
        <div class="pt-6 border-t border-slate-200 text-center text-xs text-slate-400">
            <p>
                Dengan masuk, Anda menyetujui 
                <a href="{{ route('legal.show', 'syarat-ketentuan') }}" class="text-slate-600 hover:underline">Ketentuan Layanan</a> 
                serta 
                <a href="{{ route('legal.show', 'kebijakan-privasi') }}" class="text-slate-600 hover:underline">Kebijakan Privasi</a> 
                Visit Sukabumi.
            </p>
        </div>

    </div>

</div>
@endsection
