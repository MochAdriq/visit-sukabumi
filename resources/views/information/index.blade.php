@extends('layouts.app')

@section('title', 'Tentang Sukabumi — Guratan Alam Pasundan')
@section('meta_description', 'Profil resmi pariwisata Kabupaten Sukabumi, kabupaten terluas di Jawa Barat dengan UNESCO Global Geopark Ciletuh-Palabuhanratu, alam GURILAPS, dan warisan budaya Pasundan.')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 overflow-hidden">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO SECTION (Immersive & Premium)
    ══════════════════════════════════════════ --}}
    <section class="relative h-[85vh] min-h-[620px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/7.jpg') }}" alt="Panorama Keindahan Sukabumi" class="w-full h-full object-cover filter brightness-[0.55] transform scale-105 hover:scale-110 transition-transform duration-[25s] ease-out">
        </div>
        
        {{-- Elegant Multi-Stop Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-black/40 to-black/30 z-10"></div>
        
        {{-- Hero Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/20 bg-white/10 backdrop-blur-md text-white text-xs md:text-sm font-bold tracking-widest uppercase mb-6 shadow-lg">
                <svg class="w-4 h-4 text-[#f9a826]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
                <span>Portal Resmi Informasi Wisata</span>
            </div>
            
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white tracking-tight leading-none drop-shadow-2xl mb-6">
                SUKABUMI
            </h1>
            
            <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md">
                Guratan Mahakarya Alam di Tatar Pasundan
            </p>
            
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3 text-xs md:text-sm">
                <a href="#fakta-wilayah" class="px-5 py-2.5 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    Fakta Wilayah
                </a>
                <a href="#gurilaps" class="px-5 py-2.5 rounded-full bg-[#1a6bbf]/80 hover:bg-[#1a6bbf] text-white font-semibold backdrop-blur-md transition shadow-md">
                    Konsep GURILAPS
                </a>
                <a href="#zonasi-wisata" class="px-5 py-2.5 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    3 Zonasi Wisata
                </a>
                <a href="#musim-berkunjung" class="px-5 py-2.5 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    Panduan Musim
                </a>
            </div>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center animate-bounce">
            <span class="text-white/70 text-[11px] font-bold tracking-widest uppercase mb-1.5">Jelajahi</span>
            <svg class="w-5 h-5 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
            </svg>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         2. QUICK FACTS INFOGRAPHIC BAR (Angka Kunci)
    ══════════════════════════════════════════ --}}
    <section id="fakta-wilayah" class="relative -mt-12 z-30 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
            {{-- Fact 1 --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                    </svg>
                </div>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">4.145 km²</div>
                <h4 class="text-xs sm:text-sm font-bold text-[#1a6bbf] mt-1">Kabupaten Terluas</h4>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-1 leading-snug">Nomor 1 terluas di Jawa Barat (~11% luas provinsi) & terluas ke-2 di Pulau Jawa.</p>
            </div>

            {{-- Fact 2 --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-cyan-50 text-cyan-600 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">117+ km</div>
                <h4 class="text-xs sm:text-sm font-bold text-cyan-600 mt-1">Bentang Pantai Selatan</h4>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-1 leading-snug">Garis pantai samudra eksotis menghadap langsung Samudra Hindia.</p>
            </div>

            {{-- Fact 3 --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-[#00aa6c] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">0 – 2.958</div>
                <h4 class="text-xs sm:text-sm font-bold text-[#00aa6c] mt-1">Meter di Atas Laut</h4>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-1 leading-snug">Rentang elevasi ekstrem: dari pesisir pantai tropis hingga kawah Gunung Gede.</p>
            </div>

            {{-- Fact 4 --}}
            <div class="bg-white rounded-2xl sm:rounded-3xl p-5 sm:p-6 shadow-xl border border-gray-100 hover:shadow-2xl transition-all duration-300">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-[#f9a826] flex items-center justify-center mb-4">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="text-2xl sm:text-3xl lg:text-4xl font-black text-gray-900 leading-tight">UNESCO</div>
                <h4 class="text-xs sm:text-sm font-bold text-[#f9a826] mt-1">Global Geopark 2018</h4>
                <p class="text-[11px] sm:text-xs text-gray-500 mt-1 leading-snug">Ciletuh-Palabuhanratu diakui secara internasional sebagai situs warisan dunia.</p>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         3. INTRO / ASAL-USUL "SUKA-BUMEN"
    ══════════════════════════════════════════ --}}
    <section class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
            <div class="space-y-6">
                <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-[#1a6bbf]/10 text-[#1a6bbf] text-xs font-extrabold uppercase tracking-wider">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                    </svg>
                    <span>Asal-Usul & Sejarah Wilayah</span>
                </div>

                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                    Kabupaten Terluas <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1a6bbf] via-blue-600 to-[#00aa6c]">di Jawa Barat</span>
                </h2>
                
                <div class="w-20 h-1.5 bg-[#00aa6c] rounded-full"></div>

                <p class="text-base sm:text-lg text-gray-600 leading-relaxed font-normal">
                    Sukabumi adalah sebuah simfoni alam yang membentang dari megahnya lereng <strong>Gunung Gede Pangrango</strong> di utara hingga eksotisme ombak <strong>Samudra Hindia</strong> di selatan. Nama <em>"Sukabumi"</em> diperkenalkan pada era kolonial sekitar tahun 1815 oleh Dr. Andries de Wilde, yang terinspirasi dari kata bahasa Sunda <strong>"Suka-Bumen"</strong> — sebuah kawasan yang begitu menyenangkan dan disukai oleh manusia untuk menetap berdiam diri.
                </p>

                <p class="text-base sm:text-lg text-gray-600 leading-relaxed font-normal">
                    Dengan luas mencapai <strong>4.145 km²</strong>, Kabupaten Sukabumi berdiri kokoh sebagai kabupaten terluas di seantero Provinsi Jawa Barat (dan terluas kedua di Pulau Jawa). Keanekaragaman mikroklimatnya menyajikan udara pegunungan yang menusuk dingin di utara, perkebunan teh yang menghampar hijau di ketinggian, ngarai sungai berarus deras di bagian tengah, hingga semilir angin pantai tropis di garis pesisir selatan.
                </p>

                <div class="pt-2 flex flex-wrap items-center gap-3 text-xs sm:text-sm font-semibold text-gray-700">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100">
                        <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        47 Kecamatan
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100">
                        <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        381 Desa & 5 Kelurahan
                    </span>
                    <span class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-gray-100">
                        <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Ibu Kota: Palabuhanratu
                    </span>
                </div>
            </div>

            {{-- Visual Image Side --}}
            <div class="relative">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl bg-gray-100">
                    <img src="{{ asset('assets/images/12.jpg') }}" alt="Perkebunan Teh Sukabumi Pasundan" class="w-full h-full object-cover">
                </div>
                {{-- Floating Badge --}}
                <div class="absolute -bottom-6 -left-6 sm:-bottom-8 sm:-left-8 bg-white p-5 sm:p-6 rounded-2xl shadow-xl max-w-xs border border-gray-100">
                    <div class="flex items-center gap-3.5 mb-2.5">
                        <div class="w-11 h-11 bg-yellow-100 rounded-xl flex items-center justify-center text-yellow-600 flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900 text-sm sm:text-base leading-tight">Hawa Sejuk Alami</h4>
                            <span class="text-[11px] text-[#00aa6c] font-semibold">18°C – 26°C rata-rata</span>
                        </div>
                    </div>
                    <p class="text-xs text-gray-500 leading-relaxed">
                        Destinasi peristirahatan favorit sejak era kolonial untuk melarikan diri dari hiruk-pikuk perkotaan.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         4. KONSEP "GURILAPS" (DNA Pariwisata Alam)
    ══════════════════════════════════════════ --}}
    <section id="gurilaps" class="py-20 bg-gradient-to-b from-gray-50 to-white relative overflow-hidden border-y border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2.5 block">Identitas Resmi Pariwisata</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 mb-5">
                    Filosofi <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1a6bbf] to-[#00aa6c]">"GURILAPS"</span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                    Satu-satunya daerah di Jawa Barat yang merangkum seluruh elemen bentang alam bumi ke dalam satu kesatuan harmoni: <strong>Gunung, Rimba, Laut, Pantai, dan Sungai/Seni-Budaya</strong>.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6">
                {{-- GU --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center font-black text-xl mb-5 shadow-xs">
                            GU
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Gunung</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Megahnya Puncak Gede (2.958 mdpl) dan Pangrango (3.019 mdpl), lembah Alun-Alun Surya Kencana, serta jalur pendakian legendaris berudara dingin menusuk.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] font-bold text-[#1a6bbf]">
                        Situ Gunung • Gede Pangrango
                    </div>
                </div>

                {{-- RI --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-emerald-50 text-[#00aa6c] flex items-center justify-center font-black text-xl mb-5 shadow-xs">
                            RI
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Rimba</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Hutan hujan tropis Taman Nasional Gunung Halimun Salak (TNGHS) yang lebat, habitat flora langka, owa jawa, elang jawa, dan ratusan sumber mata air jernih.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] font-bold text-[#00aa6c]">
                        TNGHS • Rimba Halimun
                    </div>
                </div>

                {{-- LA --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-cyan-50 text-cyan-600 flex items-center justify-center font-black text-xl mb-5 shadow-xs">
                            LA
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Laut & Danau</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Keluasan Samudra Hindia yang kaya potensi maritim, berpadu dengan ketenangan air danau vulkanik Situ Gunung yang memantulkan rimbunnya dedaunan hutan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] font-bold text-cyan-600">
                        Samudra Hindia • Situ Gunung
                    </div>
                </div>

                {{-- P --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-amber-50 text-[#f9a826] flex items-center justify-center font-black text-xl mb-5 shadow-xs">
                            P
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Pantai</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Lebih dari 117 km pantai eksotis: pasir putih Ujung Genteng, tebing karang Karang Hawu, hingga gulungan ombak Cimaja yang diakui peselancar internasional.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] font-bold text-[#f9a826]">
                        Cimaja • Ujung Genteng
                    </div>
                </div>

                {{-- S --}}
                <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl hover:-translate-y-1.5 transition-all duration-300 border border-gray-100 flex flex-col justify-between">
                    <div>
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center font-black text-xl mb-5 shadow-xs">
                            S
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Sungai & Seni</h3>
                        <p class="text-xs text-gray-600 leading-relaxed">
                            Aliran jeram arung jeram kelas dunia di Sungai Citarik & Cicatih, berpadu dengan kearifan budaya masyarakat adat Kasepuhan dan keramahan Pasundan.
                        </p>
                    </div>
                    <div class="mt-6 pt-4 border-t border-gray-100 text-[11px] font-bold text-indigo-600">
                        Rafting Citarik • Adat Kasepuhan
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         5. UNESCO GLOBAL GEOPARK CILETUH
    ══════════════════════════════════════════ --}}
    <section class="py-24 bg-white relative overflow-hidden">
        {{-- Decorative SVG --}}
        <div class="absolute top-0 right-0 transform translate-x-1/3 -translate-y-1/3 opacity-5 pointer-events-none">
            <svg width="600" height="600" fill="currentColor" viewBox="0 0 100 100">
                <path d="M50 0 C22.4 0 0 22.4 0 50 s22.4 50 50 50 50-22.4 50-50 S77.6 0 50 0zM50 80 C33.4 80 20 66.6 20 50 s13.4-30 30-30 30 13.4 30 30-13.4 30-30 30z"/>
            </svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-3 block">Situs Warisan Dunia UNESCO</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 mb-6 leading-tight">
                    UNESCO Global Geopark <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1a6bbf] via-blue-600 to-[#00aa6c]">Ciletuh-Palabuhanratu</span>
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                    Terbentuk dari tumbukan lempeng tektonik samudera dan benua puluhan juta tahun silam, menghasilkan amfiteater alam raksasa berbentuk tapal kuda yang menghadap langsung ke lautan lepas.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Card 1: Geodiversity --}}
                <div class="bg-gray-50 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#f0f7ff] rounded-2xl flex items-center justify-center text-[#1a6bbf] mb-6 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Warisan Geologi Purba</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Menyimpan batuan tertua di Pulau Jawa berupa formasi batuan dasar samudera (*melange complex*) berumur lebih dari 65 juta tahun yang tersingkap megah di permukaan tanah.
                    </p>
                </div>

                {{-- Card 2: Biodiversity --}}
                <div class="bg-gray-50 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#f0fdf4] rounded-2xl flex items-center justify-center text-[#00aa6c] mb-6 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keanekaragaman Hayati</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Habitat suaka konservasi penyu hijau di Pangumbahan, hutan tropis lebat, serta jajaran air terjun megah bertingkat seperti Curug Cimarinjung, Curug Cikaso, dan Curug Sodong.
                    </p>
                </div>

                {{-- Card 3: Cultural Diversity --}}
                <div class="bg-gray-50 rounded-3xl p-8 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#fff7ed] rounded-2xl flex items-center justify-center text-[#f9a826] mb-6 group-hover:scale-110 transition-transform shadow-xs">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Kearifan Budaya Lokal</h3>
                    <p class="text-gray-600 text-sm leading-relaxed">
                        Keterpaduan antara pelestarian alam dan kearifan masyarakat adat Kasepuhan yang menjunjung tinggi hukum adat dalam menjaga hutan larangan dan ketahanan pangan padi leluhur.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         6. ZONASI WISATA (3 KORIDOR SUKABUMI)
    ══════════════════════════════════════════ --}}
    <section id="zonasi-wisata" class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2.5 block">Panduan Menjelajah</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 mb-5">
                    3 Koridor Utama Destinasi
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                    Karena wilayahnya yang sangat luas, destinasi Sukabumi terbagi ke dalam 3 koridor wisata utama dengan karakteristik bentang alam dan sensasi liburan yang berbeda.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Koridor 1: Utara --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="h-48 relative overflow-hidden">
                            <img src="{{ asset('assets/images/3.jpg') }}" alt="Sukabumi Utara Pegunungan" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-5 right-5">
                                <span class="text-xs font-black uppercase tracking-wider text-blue-300">Koridor 1</span>
                                <h3 class="text-xl font-black text-white">Sukabumi Utara</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#1a6bbf] mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/></svg>
                                <span>Highland, Agrowisata & Refreshment</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Kawasan berhawa dingin sejuk di lereng Gunung Gede Pangrango. Pusat rekreasi keluarga, jembatan gantung terpanjang di Asia Tenggara (Suspension Bridge), perkemahan mewah (glamping), dan agrowisata sayur-teh.
                            </p>
                            <ul class="text-xs text-gray-500 space-y-1.5 pb-2">
                                <li>• Situ Gunung Suspension Bridge & Curug Sawer</li>
                                <li>• Taman Rekreasi Selabintana & Pondok Halimun</li>
                                <li>• Jalur Pendakian Gunung Gede via Selabintana</li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('place.index', ['search' => 'Situ Gunung']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-blue-50 text-[#1a6bbf] hover:bg-[#1a6bbf] hover:text-white font-bold text-xs transition">
                            Eksplor Sukabumi Utara →
                        </a>
                    </div>
                </div>

                {{-- Koridor 2: Tengah --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="h-48 relative overflow-hidden">
                            <img src="{{ asset('assets/images/5.jpg') }}" alt="Sukabumi Tengah Adventure" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-5 right-5">
                                <span class="text-xs font-black uppercase tracking-wider text-emerald-300">Koridor 2</span>
                                <h3 class="text-xl font-black text-white">Sukabumi Tengah</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#00aa6c] mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                                <span>Adventure, Rafting & 1001 Curug</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Jalur petualangan pemacu adrenalin. Menghubungkan daerah Cikidang, Cibadak, hingga Warungkiara. Terkenal dengan aliran sungai deras Citarik-Cicatih berstandar internasional dan gua purba karst.
                            </p>
                            <ul class="text-xs text-gray-500 space-y-1.5 pb-2">
                                <li>• Arung Jeram (Rafting) Sungai Citarik & Cicatih</li>
                                <li>• Susur Gua Siluman & Wisata Karst Buniwangi</li>
                                <li>• Curug Bibijilan & Pemandian Air Panas Cisolok</li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('place.index', ['search' => 'Citarik']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-emerald-50 text-[#00aa6c] hover:bg-[#00aa6c] hover:text-white font-bold text-xs transition">
                            Eksplor Sukabumi Tengah →
                        </a>
                    </div>
                </div>

                {{-- Koridor 3: Selatan --}}
                <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="h-48 relative overflow-hidden">
                            <img src="{{ asset('assets/images/4.jpg') }}" alt="Sukabumi Selatan Pantai Geopark" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute bottom-4 left-5 right-5">
                                <span class="text-xs font-black uppercase tracking-wider text-amber-300">Koridor 3</span>
                                <h3 class="text-xl font-black text-white">Sukabumi Selatan</h3>
                            </div>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center gap-2 text-xs font-bold text-[#f9a826] mb-3">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                <span>UNESCO Geopark, Ocean & Coastal</span>
                            </div>
                            <p class="text-sm text-gray-600 leading-relaxed mb-4">
                                Bentang Samudra Hindia dan teluk Palabuhanratu. Surga geologi purba UNESCO Geopark Ciletuh, hamparan pasir putih penyu bertelur di Ujung Genteng, serta titik selancar kelas dunia Cimaja.
                            </p>
                            <ul class="text-xs text-gray-500 space-y-1.5 pb-2">
                                <li>• Amfiteater Geopark Ciletuh & Puncak Darma</li>
                                <li>• Pantai Karang Hawu & Titik Selancar Cimaja</li>
                                <li>• Konservasi Penyu Pangumbahan & Pantai Ujung Genteng</li>
                            </ul>
                        </div>
                    </div>
                    <div class="p-6 pt-0">
                        <a href="{{ route('place.index', ['search' => 'Geopark Ciletuh']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-amber-50 text-[#f9a826] hover:bg-[#f9a826] hover:text-gray-900 font-bold text-xs transition">
                            Eksplor Sukabumi Selatan →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         7. KEARIFAN BUDAYA & SEJARAH (Living Heritage)
    ══════════════════════════════════════════ --}}
    <section class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">
                {{-- Left: Heritage visual cards --}}
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-4">
                        <div class="rounded-3xl overflow-hidden shadow-md h-56 bg-gray-100">
                            <img src="{{ asset('assets/images/6.jpg') }}" alt="Budaya Sukabumi" class="w-full h-full object-cover">
                        </div>
                        <div class="bg-amber-50 p-5 rounded-3xl border border-amber-100">
                            <div class="w-10 h-10 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">Ketahanan Pangan Leuit</h4>
                            <p class="text-xs text-gray-600 mt-1">Menyimpan gabah padi di ribuan lumbung komunal yang tahan hingga puluhan tahun.</p>
                        </div>
                    </div>
                    <div class="space-y-4 pt-8">
                        <div class="bg-blue-50 p-5 rounded-3xl border border-blue-100">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center mb-3">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <h4 class="font-bold text-gray-900 text-sm">Warisan Kolonial 1882</h4>
                            <p class="text-xs text-gray-600 mt-1">Stasiun kereta api bersejarah dan Terowongan Lampegan yang legendaris.</p>
                        </div>
                        <div class="rounded-3xl overflow-hidden shadow-md h-56 bg-gray-100">
                            <img src="{{ asset('assets/images/10.jpg') }}" alt="Masyarakat Sukabumi" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>

                {{-- Right: Content description --}}
                <div class="space-y-6">
                    <div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-amber-500/10 text-amber-700 text-xs font-extrabold uppercase tracking-wider">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                        <span>Warisan Leluhur yang Tetap Hidup</span>
                    </div>

                    <h2 class="text-3xl sm:text-4xl font-black text-gray-900 leading-tight">
                        Harmoni Alam & <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-amber-600 to-[#00aa6c]">Kearifan Adat Kasepuhan</span>
                    </h2>

                    <p class="text-base text-gray-600 leading-relaxed">
                        Sukabumi bukan sekadar bentang alam yang elok, melainkan rumah bagi masyarakat adat yang hidup berdampingan secara harmonis dengan ekosistemnya. Di kawasan pegunungan Halimun Selatan berdiam <strong>Kasepuhan Adat Banten Kidul</strong> (seperti Kasepuhan Ciptagelar dan Sinar Resmi).
                    </p>

                    <p class="text-base text-gray-600 leading-relaxed">
                        Mereka memegang teguh filosofi bertani padi organik tanpa pupuk kimia, menolak memperjualbelikan beras hasil bumi, dan menyimpannya di ribuan <em>leuit</em> (lumbung padi komunal). Tradisi tahunan <strong>Seren Taun</strong> menjadi pesta rasa syukur agung yang merekatkan persaudaraan dan pelestarian benih padi pusaka Nusantara.
                    </p>

                    <div class="grid grid-cols-2 gap-4 pt-2">
                        <div class="border-l-2 border-[#1a6bbf] pl-4">
                            <div class="text-lg font-bold text-gray-900">Seren Taun</div>
                            <div class="text-xs text-gray-500 mt-0.5">Upacara adat syukur panen raya warisan abad ke-14.</div>
                        </div>
                        <div class="border-l-2 border-[#00aa6c] pl-4">
                            <div class="text-lg font-bold text-gray-900">Hutan Tutupan</div>
                            <div class="text-xs text-gray-500 mt-0.5">Zonasi adat penjaga kelestarian hulu air pegunungan.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         8. PANDUAN MUSIM & WAKTU TERBAIK BERKUNJUNG
    ══════════════════════════════════════════ --}}
    <section id="musim-berkunjung" class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2.5 block">Tips Perjalanan</span>
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 mb-5">
                    Waktu Terbaik untuk Berkunjung
                </h2>
                <p class="text-base sm:text-lg text-gray-600 leading-relaxed">
                    Setiap musim di Sukabumi memberikan keajaiban yang berbeda. Rencanakan perjalananmu sesuai aktivitas wisata yang ingin dinikmati.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Season 1 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-[#f9a826] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-amber-600">Mei – September</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-1 mb-3">Musim Kemarau & Pendakian</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Waktu paling ideal untuk pendakian Gunung Gede Pangrango, berkemah di tepi danau Situ Gunung, serta menikmati matahari terbenam tanpa terganggu hujan lebat.
                    </p>
                    <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <strong>Aktivitas Terbaik:</strong> Trekking curug, camping, foto lanskap, outbound keluarga.
                    </div>
                </div>

                {{-- Season 2 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#1a6bbf]">Juni – Oktober</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-1 mb-3">Musim Ombak Peselancar</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Tinggi ombak di Teluk Cimaja dan Palabuhanratu mencapai titik puncaknya, menarik perhatian peselancar mancanegara dalam event kejuaraan selancar nasional.
                    </p>
                    <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <strong>Aktivitas Terbaik:</strong> Surfing di Cimaja, snorkeling Ujung Genteng, wisata perahu nelayan.
                    </div>
                </div>

                {{-- Season 3 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200 hover:shadow-md transition">
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00aa6c] flex items-center justify-center mb-6">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold uppercase tracking-wider text-[#00aa6c]">Sepanjang Tahun</span>
                    <h3 class="text-xl font-bold text-gray-900 mt-1 mb-3">Wisata Budaya & Kuliner</h3>
                    <p class="text-sm text-gray-600 leading-relaxed mb-4">
                        Kelezatan Mochi Lampion khas Kaswari, hidangan bubur ayam Sukabumi berkuah kuning, seafood segar Palabuhanratu, dan kafe kopi lokal selalu siap memanjakan lidah kapan pun kamu berkunjung.
                    </p>
                    <div class="text-xs text-gray-500 bg-gray-50 p-3 rounded-xl border border-gray-100">
                        <strong>Aktivitas Terbaik:</strong> Belanja oleh-oleh, café hopping di kota, wisata sejarah stasiun.
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         9. MOSAIK PENGALAMAN (Bento Grid Visual)
    ══════════════════════════════════════════ --}}
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2.5 block">Galeri Ragam Persona</span>
            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black text-gray-900 mb-4">Mosaik Pengalaman Sukabumi</h2>
            <p class="text-gray-500 text-base sm:text-lg">Setiap sudut Sukabumi menyuguhkan cerita dan kenangan yang tak terlupakan.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 h-auto md:h-[520px]">
            {{-- Surfing --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full lg:col-span-2 shadow-md">
                <img src="{{ asset('assets/images/galeri seputar 1.webp') }}" alt="Ombak Cimaja Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-cyan-300 uppercase tracking-wider">Olahraga Air</span>
                    <h3 class="text-2xl font-bold text-white mb-1.5">Ombak Selancar Kelas Dunia</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Pantai Cimaja diakui liga peselancar profesional internasional.</p>
                </div>
            </div>
            
            {{-- Kuliner --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/galeri seputar 2.jpg') }}" alt="Kuliner Khas Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-wider">Kuliner Otentik</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Kelezatan Khas</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Mochi kenyal legendaris, bubur ayam, hingga hidangan seafood pesisir.</p>
                </div>
            </div>

            {{-- Curug --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/galeri seputar 3.jpg') }}" alt="1001 Curug Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider">Lanskap Rimba</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Negeri 1001 Curug</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Air terjun megah di balik keasrian rimba pegunungan tropis.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         10. CALL TO ACTION (Mulai Petualangan)
    ══════════════════════════════════════════ --}}
    <section class="py-24 bg-[#0a192f] text-white text-center relative overflow-hidden">
        {{-- Map Overlay / Graphic --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 32px 32px;"></div>
        
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 text-blue-200 text-xs font-bold uppercase tracking-wider mb-6 border border-white/10">
                <svg class="w-4 h-4 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <span>Siap Menjelajahi Sukabumi?</span>
            </div>

            <h2 class="text-3xl sm:text-4xl md:text-5xl font-black mb-6 leading-tight">
                Mulai Rencanakan <br class="hidden sm:block"/>
                Petualangan Impianmu Sekarang
            </h2>
            
            <p class="text-base sm:text-lg text-gray-300 mb-10 max-w-xl mx-auto leading-relaxed">
                Temukan rekomendasi destinasi wisata terbaik, tips liburan, panduan rute, hingga pusat informasi terpadu.
            </p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('place.index') }}" class="w-full sm:w-auto px-8 py-4 bg-[#00aa6c] hover:bg-[#00925c] text-white font-extrabold rounded-full text-base shadow-xl hover:shadow-2xl hover:-translate-y-0.5 transition-all">
                    Jelajahi Direktori Wisata
                </a>
                <a href="{{ route('blog.index') }}" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white/30 hover:border-white text-white font-bold rounded-full text-base transition-all">
                    Baca Panduan & Cerita
                </a>
                <a href="{{ route('legal.show', 'hubungi-kami') }}" class="w-full sm:w-auto px-7 py-4 bg-white/10 hover:bg-white/20 text-white font-bold rounded-full text-base backdrop-blur-md transition-all border border-white/10">
                    Pusat Bantuan
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')
</div>
@endsection
