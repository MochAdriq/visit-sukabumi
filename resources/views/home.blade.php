@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-800">
    @include('components.navbar')

    <main>
        <!-- HERO SECTION -->
        <div class="relative bg-gray-900" style="height: 70vh; min-height: 500px;">
            <div class="absolute inset-0">
                <!-- Menggunakan gambar Pelabuhan Ratu dengan resolusi tinggi untuk hero -->
                <img class="w-full h-full object-cover" src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=1920&h=800&fit=crop" alt="Pemandangan Sukabumi" />
                <div class="absolute inset-0 bg-black opacity-30"></div>
            </div>

            <div class="relative max-w-7xl mx-auto px-6 h-full flex flex-col items-center justify-center">
                <h1 class="text-5xl md:text-7xl font-bold text-white drop-shadow-lg mb-8 text-center" style="text-shadow: 0 4px 12px rgba(0,0,0,0.4);">
                    Discover Sukabumi
                </h1>

                <div class="relative w-full max-w-3xl">
                    <details class="group relative">
                        <summary class="bg-white h-[60px] rounded-full flex items-center justify-between pl-8 pr-2 shadow-2xl cursor-pointer list-none [&::-webkit-details-marker]:hidden">
                            <span class="text-gray-700 text-[17px]">I want to</span>
                            <div class="w-11 h-11 bg-[#1a6bbf] rounded-full flex items-center justify-center text-white transition-transform duration-300 group-open:rotate-180 flex-shrink-0">
                                <svg fill="none" height="24" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" viewBox="0 0 24 24" width="24">
                                    <path d="M6 9l6 6 6-6"/>
                                </svg>
                            </div>
                        </summary>
                        
                        <!-- Dropdown Content -->
                        <div class="absolute left-0 right-0 top-full mt-3 bg-white rounded-2xl shadow-2xl overflow-hidden z-50 py-2">
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Kunjungi destinasi alam terbaik</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Jelajahi Geopark Ciletuh</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Nikmati kuliner lokal</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Ikuti tur arung jeram</a>
                            <a href="#" class="block px-8 py-3 text-[16px] text-[#1a6bbf] hover:bg-[#f0f7ff] hover:text-[#145299] font-semibold transition-colors">Temukan penginapan terbaik</a>
                        </div>
                    </details>
                </div>
            </div>
        </div>

        <!-- USP BAR -->
        <div class="bg-[#1a6bbf] text-white py-6 px-6">
            <div class="max-w-7xl mx-auto flex flex-col md:flex-row items-center gap-6">
                <h2 class="text-[13px] font-bold uppercase tracking-widest whitespace-nowrap border-r border-white/30 pr-6">
                    Sukabumi's Official Visitor Guide
                </h2>
                <div class="flex flex-col sm:flex-row gap-6 flex-1">
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                        </svg>
                        <p class="text-sm">Inspiring <strong>wisatawan lokal & mancanegara</strong></p>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 15l-2 5L9 9l11 4-5 2zm0 0l5 5"/>
                        </svg>
                        <p class="text-sm"><strong>Temukan dengan mudah</strong> melalui direktori terpercaya</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <svg class="w-8 h-8 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                        <p class="text-sm">Kunjunganmu <strong>mendukung pariwisata lokal</strong></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MUST-SEES -->
        <div class="max-w-7xl mx-auto px-6 py-14">
            <h2 class="text-3xl font-black text-gray-900 uppercase tracking-tight mb-3">Must-sees in Sukabumi</h2>
            <p class="text-base text-gray-600 mb-8 max-w-2xl">A trip to Sukabumi wouldn't be complete without experiencing our most iconic nature attractions, stunning waterfalls and exciting outdoor tours.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                @foreach($mustSees as $place)
                    <x-place-card :place="$place" />
                @endforeach
            </div>
        </div>

        <!-- FIRST-TIME VISITOR CALLOUT -->
        <div class="bg-gray-50 py-16">
            <div class="max-w-6xl mx-auto px-6">
                <div class="relative bg-white border border-[#1a6bbf] rounded-tl-[3.5rem] rounded-br-[3.5rem] p-8 md:p-12 shadow-sm overflow-hidden flex flex-col md:flex-row gap-10">
                    
                    <!-- Decorative SVG Bottom Right -->
                    <div class="absolute bottom-0 right-8 text-[#1a6bbf] opacity-80 pointer-events-none hidden md:block">
                        <svg width="140" height="80" viewBox="0 0 140 80" fill="none" stroke="currentColor" stroke-width="1.5">
                            <!-- Mountain / Tree outlines to mimic the London taxi/trees -->
                            <path d="M100 80 L120 40 L140 80" stroke-linejoin="round" />
                            <path d="M110 80 L120 55 L130 80" stroke-linejoin="round" />
                            <path d="M70 80 L90 50 L110 80" stroke-linejoin="round" />
                            <path d="M20 80 L20 65 C20 50 40 50 40 65 L40 80" />
                            <path d="M15 65 L45 65" />
                            <circle cx="23" cy="72" r="3" />
                            <circle cx="37" cy="72" r="3" />
                            <path d="M25 57 L35 57" />
                        </svg>
                    </div>

                    <div class="flex-1 z-10">
                        <h2 class="text-4xl md:text-5xl font-black text-[#1a6bbf] mb-6 leading-tight">Pertama kali ke<br>Sukabumi?</h2>
                        <hr class="border-[#1a6bbf] border-t-2 w-16 mb-6"/>
                        <p class="text-[17px] text-gray-900 font-bold leading-relaxed">
                            Temukan panduan lengkap wisata Sukabumi... dari destinasi alam terbaik hingga kuliner, hotel, aktivitas seru, dan lainnya!
                        </p>
                    </div>
                    
                    <div class="flex-1 space-y-8 z-10">
                        <p class="text-[15px] text-gray-700 leading-relaxed">
                            Jika ini pertama kali kamu mengunjungi Sukabumi, panduan ini akan membantu perjalananmu menjadi aman, mudah, dan yang paling penting, menyenangkan! Jelajahi Sukabumi dengan mudah melalui informasi rute terbaru, panduan transportasi darat, dan tips wisata yang praktis.
                        </p>
                        <a href="#" class="inline-block px-10 py-3.5 text-[15px] font-bold text-white bg-[#1a6bbf] hover:bg-[#145299] rounded-full transition-colors shadow-md">
                            Pelajari lebih lanjut
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- ANIMATED CATEGORY ICONS -->
        @php
        $categories = [
            ['name' => 'Wisata Alam',    'lottie' => asset('lottie/wisata-alam.json')],
            ['name' => 'Wisata Pantai',  'lottie' => asset('lottie/wisata-pantai.json')],
            ['name' => 'Kuliner Lokal',  'lottie' => asset('lottie/kuliner-lokal.json')],
            ['name' => 'Hotel & Resort', 'lottie' => asset('lottie/hotel-resort.json')],
        ];
        @endphp

        <div class="max-w-7xl mx-auto px-6 py-12">
            <h2 class="text-[22px] font-bold text-gray-900 mb-6">Butuh inspirasi aktivitas?</h2>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
                @foreach($categories as $cat)
                    <a href="#" class="vs-cat-card group">
                        <div class="vs-cat-lottie">
                            <lottie-player src="{{ $cat['lottie'] }}" background="transparent" speed="1" style="width:100%;height:100%;" autoplay loop></lottie-player>
                        </div>
                        <h3 class="vs-cat-label">{{ $cat['name'] }}</h3>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- ══════════════════════════════════════════
             EXPLORE SUKABUMI — 4 article cards
        ══════════════════════════════════════════ -->
        <div class="bg-white border-t border-gray-100 py-14">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Jelajahi Sukabumi</h2>
                <p class="text-[15px] text-[#1a6bbf] mb-8 max-w-3xl leading-relaxed">
                    Dari <strong>keindahan alam</strong> kelas dunia, hingga <strong>kuliner khas</strong>, aktivitas seru, dan pesona budaya lokal — temukan banyak hal menakjubkan untuk dilakukan dan dilihat di Sukabumi.
                </p>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Card 1 -->
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-3 aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&fit=crop" alt="Wisata Alam" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h3 class="text-[16px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-2 transition-colors mb-1">Wisata alam terbaik di Sukabumi</h3>
                        <p class="text-[13px] text-gray-500 leading-relaxed">Nikmati hamparan alam Sukabumi yang menakjubkan, dari hutan tropis, geopark, hingga air terjun tersembunyi.</p>
                    </a>
                    <!-- Card 2 -->
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-3 aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=640&fit=crop" alt="Wisata Pantai" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h3 class="text-[16px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-2 transition-colors mb-1">Tur & aktivitas wisata pantai</h3>
                        <p class="text-[13px] text-gray-500 leading-relaxed">Temukan pantai-pantai eksotis di Sukabumi Selatan dengan ombak, sunset, dan keindahan bawah laut yang luar biasa.</p>
                    </a>
                    <!-- Card 3 -->
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-3 aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=640&fit=crop" alt="Kuliner Sukabumi" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h3 class="text-[16px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-2 transition-colors mb-1">Kuliner & makanan khas Sukabumi</h3>
                        <p class="text-[13px] text-gray-500 leading-relaxed">Cicipi cita rasa otentik Sukabumi mulai dari Mie Kocok, Soto Mie, hingga jajanan pasar yang menggugah selera.</p>
                    </a>
                    <!-- Card 4 -->
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-3 aspect-[4/3]">
                            <img src="https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=640&fit=crop" alt="Wisata Hari" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h3 class="text-[16px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-2 transition-colors mb-1">Wisata sehari dari Sukabumi</h3>
                        <p class="text-[13px] text-gray-500 leading-relaxed">Jelajahi situs bersejarah, desa wisata unik, dan kawasan alam memukau dalam satu perjalanan sehari yang tak terlupakan.</p>
                    </a>
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════
             TOP TICKETS — Tab filter
        ══════════════════════════════════════════ -->
        <div class="bg-gray-50 py-14 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Tiket & Destinasi Populer</h2>

                <!-- Tab Pills -->
                <div class="flex gap-3 mb-6" id="ticket-tabs">
                    <button onclick="switchTab('alam')" id="tab-alam" class="vs-tab-pill active">Wisata Alam</button>
                    <button onclick="switchTab('pantai')" id="tab-pantai" class="vs-tab-pill">Wisata Pantai</button>
                    <button onclick="switchTab('kuliner')" id="tab-kuliner" class="vs-tab-pill">Kuliner</button>
                </div>

                <h3 class="text-xl font-bold text-gray-900 mb-2">Destinasi wisata terpopuler di Sukabumi</h3>
                <p class="text-[14px] text-[#1a6bbf] mb-7 max-w-3xl">Sukabumi adalah rumah bagi <strong>berbagai destinasi luar biasa</strong>, mulai dari Geopark Ciletuh hingga pantai selatan yang eksotis dan keindahan air terjun tersembunyi di pedalaman.</p>

                <!-- Tab Content: Alam -->
                <div id="content-alam" class="vs-tab-content grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach([
                        ['Geopark Ciletuh','https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=320&fit=crop','Top Pick','Rp 0'],
                        ['Situ Gunung','https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=320&fit=crop','Popular','Rp 25rb'],
                        ['Curug Cikaso','https://images.unsplash.com/photo-1596404554311-66774e50ebec?q=80&w=320&fit=crop','','Rp 15rb'],
                        ['Curug Luhur','https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=320&fit=crop','','Rp 20rb'],
                        ['Taman Nasional Gn. Halimun','https://images.unsplash.com/photo-1448375240586-882707db888b?q=80&w=320&fit=crop','Essential','Rp 35rb'],
                        ['Pantai Ujung Genteng','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=320&fit=crop','','Rp 15rb'],
                    ] as $ticket)
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-2 aspect-[3/4] relative">
                            @if($ticket[2])
                            <span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">{{ $ticket[2] }}</span>
                            @endif
                            <img src="{{ $ticket[1] }}" alt="{{ $ticket[0] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-1 leading-tight mb-1">{{ $ticket[0] }}</h4>
                        <span class="inline-block bg-[#1a6bbf] text-white text-[11px] font-bold px-3 py-1 rounded-sm">Mulai {{ $ticket[3] }}</span>
                    </a>
                    @endforeach
                </div>

                <!-- Tab Content: Pantai (hidden) -->
                <div id="content-pantai" class="vs-tab-content hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach([
                        ['Pantai Palabuhanratu','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=320&fit=crop','Top Pick','Rp 0'],
                        ['Pantai Ujung Genteng','https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=320&fit=crop','Popular','Rp 15rb'],
                        ['Pantai Cibangban','https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=320&fit=crop','','Rp 10rb'],
                        ['Pantai Minajaya','https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=320&fit=crop','Essential','Rp 10rb'],
                        ['Pantai Loji','https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=320&fit=crop','','Rp 10rb'],
                        ['Pantai Cisolok','https://images.unsplash.com/photo-1596404554311-66774e50ebec?q=80&w=320&fit=crop','','Rp 10rb'],
                    ] as $ticket)
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-2 aspect-[3/4] relative">
                            @if($ticket[2])
                            <span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">{{ $ticket[2] }}</span>
                            @endif
                            <img src="{{ $ticket[1] }}" alt="{{ $ticket[0] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-1 leading-tight mb-1">{{ $ticket[0] }}</h4>
                        <span class="inline-block bg-[#1a6bbf] text-white text-[11px] font-bold px-3 py-1 rounded-sm">Mulai {{ $ticket[3] }}</span>
                    </a>
                    @endforeach
                </div>

                <!-- Tab Content: Kuliner (hidden) -->
                <div id="content-kuliner" class="vs-tab-content hidden grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                    @foreach([
                        ['Mie Kocok Sukabumi','https://images.unsplash.com/photo-1555939594-58d7cb561ad1?q=80&w=320&fit=crop','Top Pick','Rp 25rb'],
                        ['Soto Mie Bogor','https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?q=80&w=320&fit=crop','Popular','Rp 20rb'],
                        ['Karedok Sukabumi','https://images.unsplash.com/photo-1512621776951-a57141f2eefd?q=80&w=320&fit=crop','','Rp 15rb'],
                        ['Bubur Ayam Khas','https://images.unsplash.com/photo-1547592166-23ac45744acd?q=80&w=320&fit=crop','','Rp 15rb'],
                        ['Dodol Sukabumi','https://images.unsplash.com/photo-1551024506-0bccd828d307?q=80&w=320&fit=crop','','Rp 30rb'],
                        ['Nasi Tutug Oncom','https://images.unsplash.com/photo-1567620905732-2d1ec7ab7445?q=80&w=320&fit=crop','Essential','Rp 20rb'],
                    ] as $ticket)
                    <a href="#" class="group block">
                        <div class="overflow-hidden rounded-lg mb-2 aspect-[3/4] relative">
                            @if($ticket[2])
                            <span class="absolute top-2 left-0 bg-[#f9a826] text-gray-900 text-[10px] font-bold px-2 py-0.5 z-10 rounded-r shadow-sm">{{ $ticket[2] }}</span>
                            @endif
                            <img src="{{ $ticket[1] }}" alt="{{ $ticket[0] }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </div>
                        <h4 class="text-[13px] font-bold text-gray-900 group-hover:text-[#1a6bbf] group-hover:underline underline-offset-1 leading-tight mb-1">{{ $ticket[0] }}</h4>
                        <span class="inline-block bg-[#1a6bbf] text-white text-[11px] font-bold px-3 py-1 rounded-sm">Mulai {{ $ticket[3] }}</span>
                    </a>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- ══════════════════════════════════════════
             WHAT'S COMING UP — Filter pills + Banner + 4 cards
        ══════════════════════════════════════════ -->
        <div class="bg-white py-14 border-t border-gray-100">
            <div class="max-w-7xl mx-auto px-6">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Apa yang akan datang di Sukabumi?</h2>
                <p class="text-[14px] text-[#1a6bbf] mb-5 max-w-3xl">
                    Temukan <strong>event dan festival</strong> terbaru di Sukabumi setiap bulannya. Atau cari inspirasi aktivitas seru untuk <strong>akhir pekan ini.</strong>
                </p>

                <!-- Filter Pills -->
                <div class="flex flex-wrap gap-3 mb-8">
                    <a href="#" class="px-5 py-2 border-2 border-[#1a6bbf] text-[#1a6bbf] text-[13px] font-bold rounded-full hover:bg-[#1a6bbf] hover:text-white transition-colors">Minggu ini</a>
                    <a href="#" class="px-5 py-2 border-2 border-gray-300 text-gray-700 text-[13px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Akhir pekan ini</a>
                    <a href="#" class="px-5 py-2 border-2 border-gray-300 text-gray-700 text-[13px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Bulan ini</a>
                    <a href="#" class="px-5 py-2 border-2 border-gray-300 text-gray-700 text-[13px] font-bold rounded-full hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors">Musim panas ini</a>
                </div>
            </div>

            <!-- Full-width Banner -->
            <div class="relative w-full h-72 mb-10 overflow-hidden">
                <img src="https://images.unsplash.com/photo-1596404554311-66774e50ebec?q=80&w=1920&h=500&fit=crop" alt="Aktivitas Sukabumi" class="w-full h-full object-cover"/>
                <div class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center gap-5">
                    <h3 class="text-white text-3xl md:text-4xl font-bold text-center drop-shadow-lg">Aktivitas seru di Sukabumi bulan ini</h3>
                    <a href="#" class="px-10 py-3.5 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold text-[15px] rounded-full transition-colors shadow-xl">
                        Lihat selengkapnya
                    </a>
                </div>
            </div>

            <!-- 4 cards below banner -->
            <div class="max-w-7xl mx-auto px-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <a href="#" class="group relative block overflow-hidden rounded-xl h-64 shadow-md">
                        <img src="https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&fit=crop" alt="Arung Jeram" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 inset-x-0 p-5">
                            <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline underline-offset-2">Arung Jeram Sungai Citarik</h4>
                        </div>
                    </a>
                    <a href="#" class="group relative block overflow-hidden rounded-xl h-64 shadow-md">
                        <img src="https://images.unsplash.com/photo-1506905925346-21bda4d32df4?q=80&w=640&fit=crop" alt="Hiking Halimun" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 inset-x-0 p-5">
                            <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline underline-offset-2">Hiking Gunung Halimun Salak</h4>
                        </div>
                    </a>
                    <a href="#" class="group relative block overflow-hidden rounded-xl h-64 shadow-md">
                        <img src="https://images.unsplash.com/photo-1610486001224-b0402b8552fc?q=80&w=640&fit=crop" alt="Jembatan Situ Gunung" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 inset-x-0 p-5">
                            <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline underline-offset-2">Jembatan Gantung Situ Gunung</h4>
                        </div>
                    </a>
                    <a href="#" class="group relative block overflow-hidden rounded-xl h-64 shadow-md">
                        <img src="https://images.unsplash.com/photo-1507525428034-b723cf961d3e?q=80&w=640&fit=crop" alt="Surfing Palabuhanratu" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                        <div class="absolute bottom-0 inset-x-0 p-5">
                            <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline underline-offset-2">Surfing di Palabuhanratu</h4>
                        </div>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- ══════════════════════════════════════════
         FOOTER — Visit London style, blue theme
    ══════════════════════════════════════════ -->
    <footer class="bg-white border-t border-gray-200">

        <!-- Top footer: Logo + SVG Illustration + Social Icons -->
        <div class="max-w-7xl mx-auto px-6 py-8 flex flex-col md:flex-row items-center justify-between gap-6 border-b border-gray-200">
            <!-- Brand -->
            <div>
                <div class="text-[#1a6bbf] text-2xl font-black tracking-tight leading-none">VISIT SUKABUMI</div>
                <div class="text-[11px] text-gray-500 font-semibold tracking-widest uppercase mt-0.5">Panduan Wisata Resmi</div>
            </div>

            <!-- Decorative Sukabumi skyline SVG -->
            <div class="text-gray-300 hidden md:block">
                <svg width="220" height="55" viewBox="0 0 220 55" fill="none" stroke="currentColor" stroke-width="1.2">
                    <!-- Simple mountain/wave/nature outline -->
                    <path d="M10 55 L10 35 L30 15 L50 35 L70 20 L90 40 L110 25 L130 40 L150 15 L170 35 L190 10 L210 35 L210 55 Z" stroke-linejoin="round"/>
                    <circle cx="90" cy="8" r="6"/>
                    <path d="M84 8 Q90 2 96 8"/>
                </svg>
            </div>

            <!-- Social Icons -->
            <div class="flex items-center gap-4">
                @foreach([
                    ['TikTok','M9 12a4 4 0 1 0 4 4V4a5 5 0 0 0 5 5'],
                    ['YouTube','M22.54 6.42a2.78 2.78 0 0 0-1.95-1.96C18.88 4 12 4 12 4s-6.88 0-8.59.46a2.78 2.78 0 0 0-1.95 1.96A29 29 0 0 0 1 12a29 29 0 0 0 .46 5.58a2.78 2.78 0 0 0 1.95 1.95C5.12 20 12 20 12 20s6.88 0 8.59-.47a2.78 2.78 0 0 0 1.95-1.95A29 29 0 0 0 23 12a29 29 0 0 0-.46-5.58zM10 15.5V8.5l6 3.5-6 3.5z'],
                    ['Instagram','M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37zm1.5-4.87h.01M7.5 20.5h9a5 5 0 0 0 5-5v-9a5 5 0 0 0-5-5h-9a5 5 0 0 0-5 5v9a5 5 0 0 0 5 5z'],
                    ['Facebook','M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z'],
                ] as $soc)
                <a href="#" class="w-9 h-9 rounded-full border border-gray-300 flex items-center justify-center text-gray-500 hover:border-[#1a6bbf] hover:text-[#1a6bbf] transition-colors" title="{{ $soc[0] }}">
                    <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="{{ $soc[1] }}"/></svg>
                </a>
                @endforeach
            </div>
        </div>

        <!-- Mid footer: 4 column links -->
        <div class="max-w-7xl mx-auto px-6 py-10 grid grid-cols-2 md:grid-cols-4 gap-8 border-b border-gray-200">
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">WISATA</h4>
                <ul class="space-y-2.5">
                    @foreach(['Tempat wisata Sukabumi','Wisata alam','Wisata pantai','Hiking & trekking','Arung jeram','Kuliner & makanan','Belanja oleh-oleh','Penginapan'] as $l)
                    <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition-colors">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">DESTINASI POPULER</h4>
                <ul class="space-y-2.5">
                    @foreach(['Geopark Ciletuh','Situ Gunung','Pelabuhan Ratu','Curug Cikaso','Curug Luhur','Pantai Ujung Genteng','Taman Nasional Halimun','Gunung Gede Pangrango'] as $l)
                    <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition-colors">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">AKTIVITAS TERBAIK</h4>
                <ul class="space-y-2.5">
                    @foreach(['Arung Jeram Citarik','Jembatan Situ Gunung','Snorkeling Ujung Genteng','Surfing Palabuhanratu','Glamping Halimun','Wisata Edukasi Geopark','Bersepeda Selabintana','Camping Curug'] as $l)
                    <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition-colors">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div>
                <h4 class="text-[11px] font-black uppercase tracking-widest text-gray-900 mb-4 pb-2 border-b border-gray-200">PANDUAN PERJALANAN</h4>
                <ul class="space-y-2.5">
                    @foreach(['Cara ke Sukabumi','Transportasi lokal','Peta wisata Sukabumi','Tips keselamatan','Hotel & penginapan','Paket wisata','Kontak darurat','Tentang Visit Sukabumi'] as $l)
                    <li><a href="#" class="text-[13px] text-gray-600 hover:text-[#1a6bbf] hover:underline transition-colors">{{ $l }}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <!-- Bottom bar: Blue background like Visit London's red bar -->
        <div class="bg-[#1a6bbf]">
            <div class="max-w-7xl mx-auto px-6 py-5 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div class="flex flex-col">
                    <span class="text-white text-[15px] font-black tracking-tight">VISIT SUKABUMI</span>
                    <span class="text-blue-200 text-[11px] mt-0.5">Didukung oleh Dinas Pariwisata Kabupaten Sukabumi</span>
                </div>
                <div class="flex flex-wrap gap-x-6 gap-y-2">
                    @foreach(['Hubungi Kami','Tentang Kami','Kebijakan Privasi','Aksesibilitas','Syarat & Ketentuan'] as $link)
                    <a href="#" class="text-blue-100 hover:text-white text-[12px] font-medium transition-colors">{{ $link }}</a>
                    @endforeach
                </div>
            </div>
            <div class="max-w-7xl mx-auto px-6 pb-5">
                <p class="text-blue-200 text-[11px] leading-relaxed max-w-3xl">
                    Visit Sukabumi adalah platform panduan wisata resmi untuk Kabupaten dan Kota Sukabumi. Kami adalah inisiatif digital untuk mempromosikan pariwisata lokal, mendukung UMKM, dan memperkenalkan keindahan Sukabumi kepada dunia.
                </p>
            </div>
        </div>
    </footer>

</div>
@endsection

@push('scripts')
<script>
    function switchTab(tab) {
        // Hide all content
        document.querySelectorAll('.vs-tab-content').forEach(el => el.classList.add('hidden'));
        // Deactivate all pills
        document.querySelectorAll('.vs-tab-pill').forEach(el => el.classList.remove('active'));
        // Show selected
        document.getElementById('content-' + tab).classList.remove('hidden');
        document.getElementById('tab-' + tab).classList.add('active');
    }
</script>
@endpush
