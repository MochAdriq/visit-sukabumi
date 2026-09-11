@extends('layouts.app')

@section('title', 'Tentang Sukabumi — Guratan Alam Pasundan')
@section('meta_description', 'Menyelami keindahan sejarah, budaya, dan alam UNESCO Global Geopark Ciletuh di Sukabumi.')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 overflow-hidden">
    @include('components.navbar')

    {{-- 1. HERO SECTION (Premium) --}}
    <section class="relative h-[85vh] min-h-[600px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image (High quality) --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('assets/images/7.jpg') }}" alt="Pemandangan Sukabumi" class="w-full h-full object-cover filter brightness-[0.6] transform hover:scale-105 transition-transform duration-[20s] ease-out">
        </div>
        
        {{-- Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-transparent to-transparent z-10 opacity-80"></div>
        
        {{-- Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-20">
            <span class="inline-block px-4 py-1.5 rounded-full border border-white/30 backdrop-blur-sm text-white/90 text-sm font-bold tracking-widest uppercase mb-6 drop-shadow-md">
                Lebih Dekat Dengan
            </span>
            <h1 class="text-5xl md:text-7xl lg:text-8xl font-black text-white tracking-tighter leading-tight drop-shadow-xl mb-6">
                SUKABUMI
            </h1>
            <p class="text-lg md:text-2xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md">
                Guratan Mahakarya Alam di Tatar Pasundan
            </p>
        </div>
        
        {{-- Scroll Indicator --}}
        <div class="absolute bottom-10 left-1/2 -translate-x-1/2 z-20 flex flex-col items-center animate-bounce">
            <span class="text-white/60 text-xs font-bold tracking-widest uppercase mb-2">Jelajahi</span>
            <svg class="w-6 h-6 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
        </div>
    </section>

    {{-- 2. INTRO / THE STORY --}}
    <section class="py-24 px-6 md:px-12 lg:px-24 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
            <div class="space-y-8">
                <h2 class="text-4xl md:text-5xl font-black text-gray-900 leading-tight">
                    Kabupaten Terluas <br><span class="text-transparent bg-clip-text bg-gradient-to-r from-[#1a6bbf] to-[#00aa6c]">di Pulau Jawa & Bali</span>
                </h2>
                <div class="w-20 h-1.5 bg-[#00aa6c] rounded-full"></div>
                <p class="text-lg text-gray-600 leading-relaxed font-medium">
                    Sukabumi, sebuah simfoni alam yang membentang dari megahnya Gunung Gede Pangrango di utara hingga eksotisnya ombak Samudra Hindia di selatan. Kata "Sukabumi" diyakini berasal dari bahasa Sunda "Suka-Bumen", yang berarti kawasan yang disukai untuk menetap.
                </p>
                <p class="text-lg text-gray-600 leading-relaxed">
                    Kekayaan alamnya yang melimpah dan hawanya yang sejuk sejak era kolonial menjadikan Sukabumi sebagai salah satu destinasi peristirahatan favorit, mewariskan budaya perkebunan teh dan bangunan bersejarah yang masih berdiri kokoh hingga kini.
                </p>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] rounded-3xl overflow-hidden shadow-2xl">
                    <img src="https://images.unsplash.com/photo-1598583483984-7546e8c87132?q=80&w=1200&auto=format&fit=crop" alt="Perkebunan Teh Sukabumi" class="w-full h-full object-cover">
                </div>
                {{-- Floating Badge --}}
                <div class="absolute -bottom-8 -left-8 bg-white p-6 rounded-2xl shadow-xl max-w-xs hidden md:block">
                    <div class="flex items-center gap-4 mb-3">
                        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-yellow-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        </div>
                        <h4 class="font-bold text-gray-900">Cuaca Sejuk</h4>
                    </div>
                    <p class="text-sm text-gray-500">Udara segar pegunungan yang menenangkan jiwa, cocok untuk melarikan diri dari hiruk pikuk kota.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 3. UNESCO GLOBAL GEOPARK --}}
    <section class="bg-gray-50 py-24 relative overflow-hidden">
        {{-- Decorative SVG --}}
        <div class="absolute top-0 right-0 transform translate-x-1/3 -translate-y-1/3 opacity-5">
            <svg width="600" height="600" fill="currentColor" viewBox="0 0 100 100"><path d="M50 0 C22.4 0 0 22.4 0 50 s22.4 50 50 50 50-22.4 50-50 S77.6 0 50 0zM50 80 C33.4 80 20 66.6 20 50 s13.4-30 30-30 30 13.4 30 30-13.4 30-30 30z"/></svg>
        </div>
        
        <div class="max-w-7xl mx-auto px-6 md:px-12 lg:px-24">
            <div class="text-center max-w-3xl mx-auto mb-16 relative z-10">
                <span class="text-[#1a6bbf] font-bold tracking-widest uppercase text-sm mb-3 block">Situs Warisan Dunia</span>
                <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-6">UNESCO Global Geopark <br>Ciletuh-Palabuhanratu</h2>
                <p class="text-lg text-gray-600">Terbentuk dari tumbukan lempeng tektonik puluhan juta tahun lalu, membentuk amfiteater alam raksasa yang menakjubkan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 relative z-10">
                {{-- Card 1 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#f0f7ff] rounded-2xl flex items-center justify-center text-[#1a6bbf] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Keanekaragaman Hayati</h3>
                    <p class="text-gray-500 leading-relaxed">Menjadi rumah bagi flora dan fauna langka, serta lanskap hutan tropis dan air terjun spektakuler.</p>
                </div>
                {{-- Card 2 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#f0fdf4] rounded-2xl flex items-center justify-center text-[#00aa6c] mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Geodiversity</h3>
                    <p class="text-gray-500 leading-relaxed">Batu-batuan tertua di Pulau Jawa yang tersingkap ke permukaan, saksi bisu evolusi bumi masa lampau.</p>
                </div>
                {{-- Card 3 --}}
                <div class="bg-white rounded-3xl p-8 shadow-sm hover:shadow-xl transition-shadow duration-300 border border-gray-100 group">
                    <div class="w-16 h-16 bg-[#fff7ed] rounded-2xl flex items-center justify-center text-orange-500 mb-6 group-hover:scale-110 transition-transform">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Pemberdayaan Budaya</h3>
                    <p class="text-gray-500 leading-relaxed">Sinergi antara pelestarian alam dan kearifan lokal masyarakat adat Kasepuhan yang unik.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 4. IMAGE GALLERY / WHY SUKABUMI --}}
    <section class="py-24 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-black text-gray-900 mb-4">Mosaik Pengalaman</h2>
            <p class="text-gray-500 text-lg">Setiap sudut Sukabumi menawarkan cerita yang berbeda.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 h-auto md:h-[500px]">
            {{-- Surfing --}}
            <div class="group relative rounded-3xl overflow-hidden h-[250px] md:h-full lg:col-span-2">
                <img src="{{ asset('assets/images/galeri seputar 1.webp') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <h3 class="text-2xl font-bold text-white mb-2">Ombak Kelas Dunia</h3>
                    <p class="text-gray-200 text-sm">Cimaja diakui peselancar internasional.</p>
                </div>
            </div>
            
            {{-- Kuliner --}}
            <div class="group relative rounded-3xl overflow-hidden h-[250px] md:h-full">
                <img src="{{ asset('assets/images/galeri seputar 2.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <h3 class="text-xl font-bold text-white mb-2">Cita Rasa Otentik</h3>
                    <p class="text-gray-200 text-sm">Mochi, Bubur Ayam, hingga Seafood.</p>
                </div>
            </div>

            {{-- Curug --}}
            <div class="group relative rounded-3xl overflow-hidden h-[250px] md:h-full">
                <img src="{{ asset('assets/images/galeri seputar 3.jpg') }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900/90 via-gray-900/40 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <h3 class="text-xl font-bold text-white mb-2">1001 Curug</h3>
                    <p class="text-gray-200 text-sm">Air terjun megah di balik rimbunnya rimba.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- 5. CALL TO ACTION --}}
    <section class="py-24 bg-[#0a192f] text-white text-center relative overflow-hidden">
        {{-- Map Overlay / Graphic --}}
        <div class="absolute inset-0 opacity-10" style="background-image: radial-gradient(#ffffff 1px, transparent 1px); background-size: 30px 30px;"></div>
        
        <div class="relative z-10 max-w-3xl mx-auto px-6">
            <h2 class="text-4xl md:text-5xl font-black mb-6 leading-tight">Siap Memulai Petualanganmu di Sukabumi?</h2>
            <p class="text-xl text-gray-300 mb-10">Temukan destinasi wisata impianmu sekarang juga.</p>
            
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('place.index') }}" class="w-full sm:w-auto px-8 py-4 bg-[#00aa6c] hover:bg-[#00925c] text-white font-bold rounded-full text-lg shadow-lg hover:shadow-xl hover:-translate-y-1 transition-all">
                    Jelajahi Wisata
                </a>
                <a href="{{ route('blog.index') }}" class="w-full sm:w-auto px-8 py-4 bg-transparent border-2 border-white/30 hover:border-white text-white font-bold rounded-full text-lg transition-all">
                    Baca Panduan
                </a>
            </div>
        </div>
    </section>

    @include('components.footer')
</div>
@endsection
