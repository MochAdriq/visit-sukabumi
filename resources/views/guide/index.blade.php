@extends('layouts.app')

@section('title', 'Panduan Wisata Sukabumi — Tips, Rute, Itinerary & Kontak Darurat')
@section('meta_description', 'Panduan lengkap liburan ke Sukabumi: rute transportasi KA Pangrango & Tol Bocimi, rekomendasi itinerary 1-3 hari, tips persiapan esensial, keselamatan pantai, dan kontak darurat.')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 overflow-hidden">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO HEADER (Actionable Guide)
    ══════════════════════════════════════════ --}}
    <section class="relative h-[70vh] min-h-[520px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/11.jpg') }}" alt="Panduan Wisata Sukabumi" class="w-full h-full object-cover filter brightness-[0.5] transform scale-105">
        </div>
        
        {{-- Multi-stop Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-black/40 to-black/30 z-10"></div>
        
        {{-- Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-12">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-white/20 bg-white/10 backdrop-blur-md text-white text-xs md:text-sm font-bold tracking-widest uppercase mb-5 shadow-lg">
                <svg class="w-4 h-4 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7"/>
                </svg>
                <span>Traveler Survival & Planning Toolkit</span>
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-black text-white tracking-tight leading-tight drop-shadow-2xl mb-5">
                Panduan Wisata Sukabumi
            </h1>

            <p class="text-base sm:text-xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md">
                Rute transportasi, rekomendasi itinerary siap pakai, tips persiapan lapangan, hingga kontak darurat terpadu.
            </p>

            {{-- Quick Links Jump Bar --}}
            <div class="mt-8 flex flex-wrap items-center justify-center gap-2.5 text-xs sm:text-sm">
                <a href="#rute-transportasi" class="px-4 py-2 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    Rute & Transportasi
                </a>
                <a href="#itinerary-rekomendasi" class="px-4 py-2 rounded-full bg-[#00aa6c]/80 hover:bg-[#00aa6c] text-white font-semibold backdrop-blur-md transition shadow-md">
                    Itinerary 1-3 Hari
                </a>
                <a href="#tips-esensial" class="px-4 py-2 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    Tips Lapangan
                </a>
                <a href="#keselamatan-pantai" class="px-4 py-2 rounded-full bg-white/15 hover:bg-white/25 text-white font-semibold backdrop-blur-md transition border border-white/20">
                    Keselamatan & Etika
                </a>
                <a href="#kontak-darurat" class="px-4 py-2 rounded-full bg-red-600/80 hover:bg-red-600 text-white font-semibold backdrop-blur-md transition shadow-md">
                    Kontak Darurat
                </a>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         2. PILAR 1: RUTE & TRANSPORTASI MENUJU SUKABUMI
    ══════════════════════════════════════════ --}}
    <section id="rute-transportasi" class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center max-w-3xl mx-auto mb-14">
            <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2 block">Akses & Moda</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">Cara Menuju ke Sukabumi</h2>
            <p class="text-base text-gray-600 leading-relaxed">
                Pilihan moda transportasi darat paling efisien dari Jabodetabek dan Bandung untuk liburan tanpa stres.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            {{-- Moda 1: Kereta Api --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 rounded-md bg-green-50 text-green-700 text-[11px] font-bold mb-2">Bebas Macet (Rekomendasi)</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Kereta Api (KA Pangrango)</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Berangkat dari <strong>Stasiun Bogor</strong> langsung ke <strong>Stasiun Sukabumi</strong> melewati Cicurug, Parungkuda, Cibadak, dan Cisaat. Waktu tempuh hanya ~2 jam tanpa risiko macet akhir pekan.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="font-semibold text-gray-800 mb-0.5">Tiket: Access by KAI</div>
                    <div>Pesan minimal H-7 sebelum keberangkatan.</div>
                </div>
            </div>

            {{-- Moda 2: Mobil Pribadi / Tol Bocimi --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-[#00aa6c] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 rounded-md bg-blue-50 text-blue-700 text-[11px] font-bold mb-2">Fleksibel Rombongan</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Mobil / Tol Bocimi</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Akses Tol Jagorawi tembus Tol Bocimi hingga pintu tol Parungkuda/Cibadak. Dari pintu tol, lanjutkan menuju kota Sukabumi (40 menit) atau belok arah Palabuhanratu via Cikidang.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="font-semibold text-gray-800 mb-0.5">Waktu Tempuh: 2.5 - 3.5 Jam</div>
                    <div>Hindari jam puncak Jumat malam & Minggu sore.</div>
                </div>
            </div>

            {{-- Moda 3: Bus AKAP & Travel Shuttle --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-amber-50 text-[#f9a826] flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 rounded-md bg-amber-50 text-amber-700 text-[11px] font-bold mb-2">Ekonomis</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Bus AKAP & Travel Shuttle</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Bus antarkota tersedia dari Terminal Kampung Rambutan, Lebak Bulus, Kalideres, serta Bandung (via Cianjur). Pilihan travel antar-jemput pool-to-pool juga melayani rute Jakarta - Sukabumi setiap hari.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="font-semibold text-gray-800 mb-0.5">Tujuan Akhir: Terminal KH Sanusi</div>
                    <div>Tersedia angkutan lanjutan ke seluruh penjuru kota.</div>
                </div>
            </div>

            {{-- Moda 4: Transportasi Lokal --}}
            <div class="bg-white rounded-3xl p-6 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between group">
                <div>
                    <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-5 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <span class="inline-block px-2.5 py-1 rounded-md bg-purple-50 text-purple-700 text-[11px] font-bold mb-2">Keliling Kota & Wisata</span>
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Rental & Transportasi Lokal</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Rental motor dan mobil tersedia banyak di dekat Stasiun Sukabumi. Ojek online beroperasi aktif di area perkotaan, Cibadak, Cisaat, dan Palabuhanratu. Untuk ke Geopark Ciletuh, sangat disarankan menyewa mobil berdaya tinggi.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t border-gray-100 text-xs text-gray-500">
                    <div class="font-semibold text-gray-800 mb-0.5">Rental Motor: ~Rp 80k - 120k/hari</div>
                    <div>Rental Mobil: ~Rp 350k - 600k/hari (+driver).</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         3. PILAR 2: KOLEKSI ITINERARY SIAP PAKAI
    ══════════════════════════════════════════ --}}
    <section id="itinerary-rekomendasi" class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#00aa6c] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2 block">Rencana Perjalanan</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">Itinerary Rekomendasi Siap Pakai</h2>
                <p class="text-base text-gray-600 leading-relaxed">
                    Jadwal perjalanan yang sudah dirancang searah agar liburanmu efisien tanpa habis waktu di jalan.
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                {{-- Itinerary 1 Hari --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full bg-blue-50 text-[#1a6bbf] font-extrabold text-xs">Pilihan Cepat</span>
                            <span class="text-xs font-bold text-gray-400">1 Hari Penuh</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">One-Day Refreshing: Sukabumi Utara</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-6">
                            Cocok untuk pelarian singkat akhir pekan bersama keluarga atau teman tanpa perlu menginap.
                        </p>
                        
                        <div class="space-y-4 border-l-2 border-blue-100 pl-4 text-xs">
                            <div>
                                <span class="font-bold text-gray-900 block">07.30 – 09.30</span>
                                <p class="text-gray-600 mt-0.5">Tiba di Stasiun Cisaat/Sukabumi via KA Pangrango pagi.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">10.00 – 13.00</span>
                                <p class="text-gray-600 mt-0.5">Eksplor Suspension Bridge Situ Gunung & trekking santai ke Curug Sawer.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">13.30 – 15.00</span>
                                <p class="text-gray-600 mt-0.5">Makan siang masakan khas Sunda (Nasi Liwet & Ikan Bakar) di Cisaat.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">15.30 – 17.00</span>
                                <p class="text-gray-600 mt-0.5">Beli Mochi Lampion Kaswari dan ngopi santai di pusat kota Sukabumi.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">17.30</span>
                                <p class="text-gray-600 mt-0.5">Perjalanan pulang via KA Pangrango sore atau Tol Bocimi.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-100">
                        <a href="{{ route('place.index', ['search' => 'Situ Gunung']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-blue-50 text-[#1a6bbf] hover:bg-[#1a6bbf] hover:text-white font-bold text-xs transition">
                            Lihat Destinasi Sukabumi Utara →
                        </a>
                    </div>
                </div>

                {{-- Itinerary 2 Hari 1 Malam --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm hover:shadow-xl transition-all duration-300 border-2 border-[#00aa6c]/30 flex flex-col justify-between relative">
                    <div class="absolute -top-3 right-6 bg-[#00aa6c] text-white px-3 py-0.5 rounded-full text-[11px] font-bold shadow-sm">
                        Paling Favorit
                    </div>
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full bg-emerald-50 text-[#00aa6c] font-extrabold text-xs">Weekend Escape</span>
                            <span class="text-xs font-bold text-gray-400">2 Hari 1 Malam</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Weekend Adventure: Rafting & Sunset Pantai</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-6">
                            Kombinasi sempurna antara pacuan adrenalin jeram sungai dan ketenangan suasana pantai selatan.
                        </p>

                        <div class="space-y-4 border-l-2 border-emerald-100 pl-4 text-xs">
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 1 (Pagi - Siang): Arung Jeram Citarik</span>
                                <p class="text-gray-600 mt-0.5">Tiba di Cikidang, pemanasan dan arung jeram 9 km atau 12 km di Sungai Citarik.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 1 (Sore - Malam): Sunset & Seafood</span>
                                <p class="text-gray-600 mt-0.5">Meluncur ke Palabuhanratu, nikmati sunset Karang Hawu & makan malam ikan bakar pesisir.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 2 (Pagi): Pemandian Air Panas Cisolok</span>
                                <p class="text-gray-600 mt-0.5">Relaksasi di geyser air panas alami Cisolok yang memancar dari bebatuan sungai.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 2 (Siang - Sore): Belanja & Pulang</span>
                                <p class="text-gray-600 mt-0.5">Beli ikan asin & kerajinan tangan di pasar Palabuhanratu sebelum kembali pulang.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-100">
                        <a href="{{ route('place.index', ['search' => 'Citarik']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-emerald-50 text-[#00aa6c] hover:bg-[#00aa6c] hover:text-white font-bold text-xs transition">
                            Lihat Paket Petualangan Citarik →
                        </a>
                    </div>
                </div>

                {{-- Itinerary 3 Hari 2 Malam --}}
                <div class="bg-white rounded-3xl p-7 shadow-sm hover:shadow-xl transition-all duration-300 border border-gray-200 flex flex-col justify-between">
                    <div>
                        <div class="flex items-center justify-between gap-2 mb-4">
                            <span class="px-3 py-1 rounded-full bg-amber-50 text-[#f9a826] font-extrabold text-xs">Grand Tour</span>
                            <span class="text-xs font-bold text-gray-400">3 Hari 2 Malam</span>
                        </div>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Grand Geopark Ciletuh & Penyu Ujung Genteng</h3>
                        <p class="text-xs text-gray-500 leading-relaxed mb-6">
                            Penjelajahan menyeluruh warisan dunia UNESCO, pantai penyu, dan air terjun purba bertingkat.
                        </p>

                        <div class="space-y-4 border-l-2 border-amber-100 pl-4 text-xs">
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 1: Puncak Darma & Curug Cimarinjung</span>
                                <p class="text-gray-600 mt-0.5">Tiba di Geopark via jalan sabuk pesisir Loji, panorama amfiteater laut dari Puncak Darma.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 2: Curug Sodong, Pantai & Pelepasan Tukik</span>
                                <p class="text-gray-600 mt-0.5">Explore Curug Sodong & Curug Cikanteh, lalu sore hari menyaksikan pelepasan anak penyu di Pangumbahan Ujung Genteng.</p>
                            </div>
                            <div>
                                <span class="font-bold text-gray-900 block">Hari 3: Susur Sungai Curug Cikaso</span>
                                <p class="text-gray-600 mt-0.5">Naik perahu motor kayu menyusuri sungai hijau toska menuju kemegahan 3 pancuran Curug Cikaso.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-8 pt-5 border-t border-gray-100">
                        <a href="{{ route('place.index', ['search' => 'Geopark Ciletuh']) }}" class="inline-flex items-center justify-center w-full py-2.5 px-4 rounded-xl bg-amber-50 text-[#f9a826] hover:bg-[#f9a826] hover:text-gray-900 font-bold text-xs transition">
                            Lihat Destinasi Geopark Ciletuh →
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         4. PILAR 3: TIPS LAPANGAN & SURVIVAL KIT
    ══════════════════════════════════════════ --}}
    <section id="tips-esensial" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-2 block">Hal Wajib Tahu</span>
                <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-4">Tips Lapangan & Persiapan Esensial</h2>
                <p class="text-base text-gray-600 leading-relaxed">
                    Hal-hal praktis yang sering diabaikan wisatawan, tetapi sangat menentukan kelancaran liburanmu di Sukabumi.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                {{-- Tip 1 --}}
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-800 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Siapkan Uang Tunai (Cash)</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Di area Geopark Ciletuh, Ujung Genteng, dan curug-curug terpencil, mesin ATM dan mesin gesek kartu EDC sangat langka. Selalu tarik uang tunai yang cukup saat berada di pusat kota Sukabumi atau Cibadak.
                    </p>
                </div>

                {{-- Tip 2 --}}
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-red-100 text-red-700 flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Mengemudi di Jalur Cikidang</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Jalur Cikidang menuju Palabuhanratu memiliki turunan curam dan tikungan S tajam. Gunakan gigi rendah (*engine break*), hindari menginjak rem terus-menerus, dan siapkan obat anti-mabuk untuk penumpang.
                    </p>
                </div>

                {{-- Tip 3 --}}
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.394 9.393c5.857-5.857 15.355-5.857 21.213 0"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Sinyal & Peta Offline</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Provider Telkomsel dan Indosat memiliki jangkauan paling stabil di pesisir dan geopark. Sebelum berangkat, unduh peta area Sukabumi secara offline di Google Maps untuk mengantisipasi *blank spot* di perbukitan.
                    </p>
                </div>

                {{-- Tip 4 --}}
                <div class="bg-gray-50 rounded-3xl p-6 border border-gray-100">
                    <div class="w-12 h-12 rounded-xl bg-emerald-100 text-[#00aa6c] flex items-center justify-center mb-4">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                        </svg>
                    </div>
                    <h3 class="font-bold text-gray-900 text-base mb-2">Perlengkapan Wajib Bawa</h3>
                    <p class="text-xs text-gray-600 leading-relaxed">
                        Sandal gunung antislip (bebatuan curug sangat licin), kantong kering (*dry bag*) untuk melindungi kamera/ponsel dari cipratan air terjun, jaket hangat untuk Sukabumi utara, dan tabir surya (*sunscreen*) untuk pantai.
                    </p>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         5. PILAR 4: KESELAMATAN PANTAI & ETIKA ADAT
    ══════════════════════════════════════════ --}}
    <section id="keselamatan-pantai" class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 items-start">
                {{-- Left: Keselamatan Pantai --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-red-50 text-red-600 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Keselamatan Maritim</span>
                            <h3 class="text-xl font-bold text-gray-900">Zona Pantai Aman vs Berbahaya</h3>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed mb-6">
                        Pantai selatan Sukabumi berhadapan langsung dengan Samudra Hindia yang memiliki karakteristik gelombang besar dan arus bawah laut (*rip current*) yang kuat.
                    </p>

                    <div class="space-y-4 text-xs">
                        <div class="p-4 rounded-2xl bg-red-50/70 border border-red-100 flex gap-3 items-start">
                            <div class="w-2.5 h-2.5 rounded-full bg-red-500 mt-1 flex-shrink-0"></div>
                            <div>
                                <strong class="text-red-900 block mb-0.5">Waspadai Bendera Merah di Pantai</strong>
                                <p class="text-red-700 leading-relaxed">Jika terpasang bendera merah oleh petugas Balawista/SAR, <strong>dilarang keras berenang</strong> ke tengah laut karena terdapat palung laut dan arus seret mematikan.</p>
                            </div>
                        </div>

                        <div class="p-4 rounded-2xl bg-green-50/70 border border-green-100 flex gap-3 items-start">
                            <div class="w-2.5 h-2.5 rounded-full bg-green-500 mt-1 flex-shrink-0"></div>
                            <div>
                                <strong class="text-green-900 block mb-0.5">Pantai dengan Area Berenang Relatif Aman</strong>
                                <p class="text-green-700 leading-relaxed">Laguna Pantai Ujung Genteng (airnya tenang karena terlindung terumbu karang alami) dan area teluk tertentu di Palabuhanratu yang diawasi penjaga pantai.</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Right: Etika Budaya Adat --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-gray-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-700 flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Norma Kesantunan</span>
                            <h3 class="text-xl font-bold text-gray-900">Etika Berkunjung ke Kampung Adat</h3>
                        </div>
                    </div>

                    <p class="text-sm text-gray-600 leading-relaxed mb-6">
                        Saat bertamu ke kawasan Kasepuhan Adat Banten Kidul (seperti Ciptagelar atau Sinar Resmi), wisatawan diharapkan menjunjung tinggi tata krama Pasundan:
                    </p>

                    <div class="space-y-3.5 text-xs text-gray-700">
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#00aa6c] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Pakaian Sopan:</strong> Kenakan pakaian tertutup dan hindari celana terlalu pendek saat memasuki Imah Gede (rumah utama ketua adat).</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#00aa6c] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Izin Sebelum Memotret:</strong> Selalu minta izin sebelum memotret Abah (sesepuh adat), ritual sakral, atau bagian dalam lumbung padi (*leuit*).</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#00aa6c] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Hormati Hutan Titipan:</strong> Jangan memetik tanaman langka dan bawa pulang kembali sampah plastikmu (*Zero Waste*).</span>
                        </div>
                        <div class="flex items-start gap-2.5">
                            <svg class="w-4 h-4 text-[#00aa6c] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                            <span><strong>Tutur Kata Santun:</strong> Gunakan sapaan ramah Sunda seperti <em>"Sampurasun"</em> (dijawab <em>"Rampes"</em>) dan <em>"Hatur Nuhun"</em> (terima kasih).</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         6. PILAR 5: KONTAK DARURAT TERPADU (Emergency)
    ══════════════════════════════════════════ --}}
    <section id="kontak-darurat" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-gradient-to-br from-red-600 via-red-700 to-rose-900 rounded-3xl p-8 sm:p-12 text-white shadow-xl relative overflow-hidden">
                <div class="relative z-10 max-w-4xl mx-auto">
                    <div class="text-center mb-10">
                        <span class="inline-block px-3 py-1 rounded-full bg-white/20 text-white text-xs font-bold uppercase tracking-wider mb-3 backdrop-blur-xs">
                            Bantuan Cepat 24 Jam
                        </span>
                        <h2 class="text-2xl sm:text-4xl font-black mb-3">Direktori Kontak Darurat Terpadu</h2>
                        <p class="text-sm sm:text-base text-red-100 max-w-xl mx-auto">
                            Simpan nomor-nomor penting ini di ponselmu sebelum memulai perjalanan menjelajah Sukabumi.
                        </p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        {{-- SAR --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                SAR
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">SAR Pos Palabuhanratu</h4>
                                <p class="text-xs text-red-200 mt-0.5">Penyelamatan Pantai & Laut</p>
                                <a href="tel:115" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">Hotline: 115</a>
                            </div>
                        </div>

                        {{-- Polisi --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                POL
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">Polres Sukabumi</h4>
                                <p class="text-xs text-red-200 mt-0.5">Keamanan & Layanan Polisi</p>
                                <a href="tel:110" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">Hotline: 110</a>
                            </div>
                        </div>

                        {{-- BPBD --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                BPD
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">BPBD Kab. Sukabumi</h4>
                                <p class="text-xs text-red-200 mt-0.5">Siaga Kebencanaan Alam</p>
                                <a href="tel:02666323717" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">(0266) 632-3717</a>
                            </div>
                        </div>

                        {{-- RSUD Bunut --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                IGD
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">RSUD R. Syamsudin (Bunut)</h4>
                                <p class="text-xs text-red-200 mt-0.5">IGD Kota Sukabumi</p>
                                <a href="tel:0266225180" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">(0266) 225-180</a>
                            </div>
                        </div>

                        {{-- RSUD Sekarwangi --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                IGD
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">RSUD Sekarwangi</h4>
                                <p class="text-xs text-red-200 mt-0.5">IGD Wilayah Cibadak</p>
                                <a href="tel:0266531261" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">(0266) 531-261</a>
                            </div>
                        </div>

                        {{-- RSUD Palabuhanratu --}}
                        <div class="bg-white/10 backdrop-blur-md rounded-2xl p-5 border border-white/15 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl bg-white text-red-600 flex items-center justify-center flex-shrink-0 font-black text-sm">
                                IGD
                            </div>
                            <div>
                                <h4 class="font-bold text-sm">RSUD Palabuhanratu</h4>
                                <p class="text-xs text-red-200 mt-0.5">IGD Pesisir Selatan</p>
                                <a href="tel:0266432081" class="inline-block mt-2 font-black text-white hover:underline text-sm tracking-wide">(0266) 432-081</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════
         7. ARTIKEL PANDUAN & TIPS TERKINI DARI BLOG
    ══════════════════════════════════════════ --}}
    @if(isset($guidePosts) && $guidePosts->isNotEmpty())
    <section class="py-20 bg-gray-50 border-t border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-end justify-between gap-4 mb-12">
                <div>
                    <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-xs sm:text-sm mb-1.5 block">Artikel Terkait</span>
                    <h2 class="text-2xl sm:text-4xl font-black text-gray-900">Tips & Cerita Perjalanan</h2>
                </div>
                <a href="{{ route('blog.index') }}" class="text-sm font-bold text-[#1a6bbf] hover:underline flex items-center gap-1">
                    Lihat Semua Artikel Blog →
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @foreach($guidePosts as $post)
                    <div class="bg-white rounded-3xl overflow-hidden shadow-sm hover:shadow-lg transition-all duration-300 border border-gray-200 flex flex-col justify-between group">
                        <div>
                            <div class="h-48 relative overflow-hidden bg-gray-100">
                                @if($post->cover_image)
                                    <img src="{{ Storage::url($post->cover_image) }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full bg-gradient-to-br from-blue-100 to-blue-50 flex items-center justify-center text-blue-300 font-bold">
                                        Visit Sukabumi
                                    </div>
                                @endif
                                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[11px] font-bold text-gray-800 shadow-sm">
                                    {{ $post->category ?? 'Panduan' }}
                                </div>
                            </div>
                            <div class="p-6">
                                <span class="text-[11px] text-gray-400 block mb-2">{{ optional($post->published_at)->format('d M Y') ?? date('d M Y') }}</span>
                                <h3 class="font-bold text-gray-900 text-base leading-snug group-hover:text-[#1a6bbf] transition-colors line-clamp-2 mb-2">
                                    <a href="{{ route('blog.show', $post->slug) }}">
                                        {{ $post->title }}
                                    </a>
                                </h3>
                                <p class="text-xs text-gray-600 line-clamp-3 leading-relaxed">
                                    {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}
                                </p>
                            </div>
                        </div>
                        <div class="p-6 pt-0">
                            <a href="{{ route('blog.show', $post->slug) }}" class="inline-flex items-center gap-1 text-xs font-bold text-[#1a6bbf] hover:underline">
                                Baca Selengkapnya →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════
         8. CALL TO ACTION (Mulai Cari Tempat)
    ══════════════════════════════════════════ --}}
    <section class="py-20 bg-[#0a192f] text-white text-center relative overflow-hidden">
        <div class="relative z-10 max-w-2xl mx-auto px-6">
            <h2 class="text-3xl sm:text-4xl font-black mb-4 leading-tight">Sudah Siap Meluncur ke Sukabumi?</h2>
            <p class="text-gray-300 text-sm sm:text-base mb-8 leading-relaxed">
                Jelajahi ratusan destinasi wisata alam, hotel & penginapan, kuliner legendaris, hingga paket tur resmi.
            </p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('place.index') }}" class="w-full sm:w-auto px-8 py-3.5 bg-[#00aa6c] hover:bg-[#00925c] text-white font-extrabold rounded-full text-sm shadow-lg transition">
                    Cari Tempat Wisata
                </a>
                <a href="{{ route('penginapan.index') }}" class="w-full sm:w-auto px-8 py-3.5 bg-white/15 hover:bg-white/25 text-white font-bold rounded-full text-sm backdrop-blur-md transition border border-white/20">
                    Cari Tempat Menginap
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')
</div>
@endsection
