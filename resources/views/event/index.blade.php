@extends('layouts.app')

@section('title', 'Kalender Event & Festival — Visit Sukabumi')
@section('meta_description', 'Temukan kalender acara, upacara adat kebudayaan Pasundan, festival musik, dan atraksi wisata terbaru di Kabupaten Sukabumi.')

@php
    $heroImg = asset('assets/images/6.jpg');
    if (isset($topEvents) && $topEvents->count() > 0) {
        $firstWithImg = $topEvents->first(fn($e) => !empty($e->image_path));
        if ($firstWithImg) {
            $heroImg = Storage::url($firstWithImg->image_path);
        }
    } elseif (isset($events) && $events->count() > 0) {
        $firstWithImg = $events->first(fn($e) => !empty($e->image_path));
        if ($firstWithImg) {
            $heroImg = Storage::url($firstWithImg->image_path);
        }
    }
@endphp

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900 pb-16">
    @include('components.navbar')

    {{-- ══════════════════════════════════════════
         1. HERO SECTION (Immersive & Premium)
    ══════════════════════════════════════════ --}}
    <section class="relative h-[80vh] min-h-[580px] w-full flex items-center justify-center overflow-hidden">
        {{-- Background Image (Dinamis dari Database Event) --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ $heroImg }}" alt="Semarak Event & Festival Budaya Sukabumi" class="w-full h-full object-cover filter brightness-[0.55] transform scale-105 hover:scale-110 transition-transform duration-[20s] ease-out">
        </div>
        
        {{-- Elegant Multi-Stop Gradient Overlay --}}
        <div class="absolute inset-0 bg-gradient-to-t from-[#0a192f] via-black/45 to-black/30 z-10"></div>
        
        {{-- Hero Content --}}
        <div class="relative z-20 text-center px-4 max-w-4xl mx-auto mt-12">
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-black text-white tracking-tight leading-tight drop-shadow-2xl mb-4">
                EVENT & FESTIVAL
            </h1>
            
            <p class="text-base sm:text-xl text-gray-200 font-medium max-w-2xl mx-auto leading-relaxed drop-shadow-md mb-8">
                Rayakan Semarak Tradisi Adat Pasundan, Pentas Seni, dan Atraksi Bahari Sukabumi
            </p>
            
            {{-- SEARCH BAR (Integrated) --}}
            <form action="{{ route('event.index') }}" method="GET" class="w-full max-w-2xl mx-auto bg-white rounded-full p-2 flex items-center shadow-2xl relative z-10 border border-white/20">
                <div class="pl-3 md:pl-4 text-gray-400">
                    <svg class="w-5 h-5 md:w-6 md:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul acara, tradisi, atau lokasi..." class="w-full bg-transparent border-none focus:ring-0 text-gray-900 text-sm md:text-base px-3 md:px-4 py-2 md:py-3 outline-none font-medium placeholder-gray-400">
                <button type="submit" class="bg-[#00aa6c] hover:bg-[#008a57] text-white px-6 md:px-8 py-2 md:py-3 rounded-full font-bold text-sm md:text-base transition shadow-md whitespace-nowrap">
                    Cari Event
                </button>
            </form>
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
         2. BREADCRUMBS STRIP
    ══════════════════════════════════════════ --}}
    <div class="border-b border-gray-100 py-3.5 bg-gray-50/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex text-xs md:text-sm text-gray-500 gap-2 items-center flex-wrap">
                <a href="{{ url('/') }}" class="hover:text-[#1a6bbf] transition-colors font-medium">Home</a>
                <span class="text-gray-300">›</span>
                <span class="font-bold text-gray-900">Event & Festival</span>
            </nav>
        </div>
    </div>

    {{-- ══════════════════════════════════════════
         3. EDITORIAL SECTION (Ala Magazine Portal)
    ══════════════════════════════════════════ --}}
    @if(!request()->has('q'))
    <section class="border-b border-gray-100 bg-white py-12 md:py-16">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-12 items-start">
                
                {{-- Kolom Utama: Narasi Cerita Editorial (65% width) --}}
                <div class="lg:col-span-8">
                    <h2 class="text-2xl md:text-3xl lg:text-4xl font-black text-gray-950 tracking-tight mb-3">
                        Mengenal Semarak Event & Tradisi Budaya Sukabumi
                    </h2>
                    <div class="w-16 h-1.5 bg-[#00aa6c] rounded-full mb-6"></div>

                    <div class="text-[15px] md:text-[16px] text-gray-700 leading-relaxed space-y-4 font-normal">
                        <p>
                            Kalender pariwisata Kabupaten Sukabumi senantiasa berdenyut hidup sepanjang tahun, mempersembahkan perpaduan memukau antara khazanah adat Sunda Pasundan yang sakral, tradisi maritim pesisir Samudra Hindia, hingga gelaran festival seni, musik, dan olahraga petualangan alam bebas. Setiap agenda menghadirkan narasi kebudayaan otentik yang telah diwariskan turun-temurun oleh masyarakat tatar Pasundan.
                        </p>
                        <p>
                            Salah satu perayaan budaya paling megah yang menarik perhatian peneliti dan wisatawan adalah <strong>Upacara Adat Seren Taun</strong> di Kasepuhan Banten Kidul (seperti Kasepuhan Ciptagelar dan Sinar Resmi), sebuah ritual ungkapan rasa syukur atas panen padi dengan tradisi sakral <em>ngampihkeun pare ka leuit</em>. Di pesisir selatan, kemeriahan <strong>Festival Hari Nelayan Palabuhanratu</strong> menyuguhkan parade karnaval rakyat, larung sesaji laut, serta pentas seni tradisional. Bagi pencinta olahraga ekstrem, pesisir Cimaja juga rutin menjadi tuan rumah kompetisi selancar kelas dunia yang menguji nyali surfer internasional.
                        </p>
                        <p>
                            Saat merencanakan kunjungan untuk menghadiri acara adat atau festival di Sukabumi, wisatawan diimbau untuk selalu menghormati norma dan kearifan lokal setempat, mengenakan pakaian yang sopan, serta memantau kalender jadwal resmi karena pelaksanaan ritual adat kasepuhan kerap mengikuti perhitungan penanggalan tradisional Sunda.
                        </p>
                    </div>
                </div>

                {{-- Kolom Samping: Quick Guide / Sekilas Panduan (35% width) --}}
                <aside class="lg:col-span-4">
                    <div class="bg-slate-50 rounded-3xl border border-slate-200/80 p-6 sm:p-7 shadow-sm sticky top-24">
                        <div class="flex items-center gap-3 pb-4 mb-5 border-b border-slate-200/80">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#1a6bbf] flex items-center justify-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-gray-900 leading-tight">Sekilas Panduan Event</h3>
                                <p class="text-xs text-gray-500">Agenda & tradisi Sukabumi</p>
                            </div>
                        </div>

                        <div class="space-y-4 text-sm">
                            {{-- Info 1: Karakter Acara --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-[#1a6bbf] mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Karakter Acara</span>
                                    <span class="font-bold text-gray-900">Upacara Adat, Festival Seni & Bahari</span>
                                </div>
                            </div>

                            {{-- Info 2: Agenda Ikonik --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-amber-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Agenda Ikonik</span>
                                    <span class="font-bold text-gray-900">Seren Taun Kasepuhan & Hari Nelayan</span>
                                </div>
                            </div>

                            {{-- Info 3: Tips Traveler --}}
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-lg bg-white border border-slate-200 flex items-center justify-center shrink-0 text-indigo-600 mt-0.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <span class="block text-xs font-semibold text-gray-400 uppercase tracking-wider">Etika Berkunjung</span>
                                    <span class="font-bold text-gray-900">Kenakan Pakaian Sopan & Hormati Adat</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Lompat ke Daftar --}}
                        <div class="mt-6 pt-4 border-t border-slate-200/80">
                            <a href="#daftar-event" class="inline-flex items-center justify-center gap-2 w-full py-2.5 px-4 rounded-xl bg-[#1a6bbf] hover:bg-[#15589c] text-white font-bold text-xs transition shadow-sm">
                                <span>Lihat Agenda Event</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </aside>

            </div>
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════
         4. TOP UPCOMING EVENTS (Travelers' Choice)
    ══════════════════════════════════════════ --}}
    @if(isset($topEvents) && $topEvents->count() > 0 && !request()->has('q'))
    <section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-12 md:mt-16 mb-16">
        <div class="flex justify-between items-end mb-6">
            <div>
                <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf] block mb-1">Sorotan Kalender</span>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900">Travelers' Choice: Top Upcoming Events</h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">Acara paling dinantikan dalam waktu dekat.</p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($topEvents as $index => $event)
                <div class="group relative block overflow-hidden rounded-2xl h-72 shadow-sm border border-gray-200 bg-gray-50 flex flex-col justify-end">
                    <a href="{{ route('event.show', $event->slug) }}" class="absolute inset-0 z-10"></a>
                    @if($event->image_path)
                        <img src="{{ Storage::url($event->image_path) }}" alt="{{ $event->title }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                    @else
                        <div class="absolute inset-0 w-full h-full flex items-center justify-center bg-[#00aa6c]/10">
                            <svg class="w-12 h-12 text-[#00aa6c]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                    
                    {{-- Ranking Label --}}
                    <div class="absolute top-4 left-4 z-20 flex items-center gap-1 bg-black/60 backdrop-blur text-white px-2.5 py-1 rounded-lg text-xs font-bold border border-white/20">
                        Top {{ $index + 1 }}
                    </div>

                    {{-- Content --}}
                    <div class="relative z-20 p-5">
                        <div class="flex items-center gap-2 mb-2">
                            <div class="bg-[#00aa6c] text-white px-2 py-0.5 rounded text-[10px] font-bold uppercase">
                                {{ $event->start_date->translatedFormat('M') }}
                            </div>
                            <div class="text-white font-bold text-sm drop-shadow-sm">
                                {{ $event->start_date->format('d') }} {{ $event->start_date->translatedFormat('Y') }}
                            </div>
                        </div>
                        <h4 class="text-white font-bold text-[16px] leading-tight group-hover:underline drop-shadow-md mb-1">{{ $event->title }}</h4>
                        @if($event->location_name)
                        <div class="flex items-center text-white/80 text-[12px] drop-shadow-sm">
                            <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $event->location_name }}
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ══════════════════════════════════════════
         5. ALL EVENTS (MAIN LISTING GRID)
    ══════════════════════════════════════════ --}}
    <section id="daftar-event" class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-16 mt-8 scroll-mt-20">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-end mb-8 gap-4 border-b border-gray-200 pb-4">
            <div>
                <h2 class="text-2xl md:text-3xl font-black text-gray-900">
                    {{ request()->has('q') ? 'Hasil Pencarian: "' . request('q') . '"' : 'Semua Event & Festival' }}
                </h2>
                <p class="text-sm md:text-base text-gray-500 mt-1">
                    {{ collect($events->items())->count() > 0 ? $events->total() . ' agenda acara ditemukan.' : 'Jelajahi berbagai acara seru di Sukabumi.' }}
                </p>
            </div>
            @if(request()->has('q'))
                <a href="{{ route('event.index') }}" class="inline-flex items-center gap-1.5 text-sm font-bold text-[#1a6bbf] hover:text-[#15589c] transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    <span>Hapus Pencarian</span>
                </a>
            @endif
        </div>

        @if($events->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach($events as $event)
                <div class="group flex flex-col bg-white rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-all duration-300 border border-gray-100 hover:-translate-y-1">
                    {{-- Image --}}
                    <div class="relative w-full aspect-[4/3] flex-shrink-0 cursor-pointer overflow-hidden bg-gray-100">
                        <a href="{{ route('event.show', $event->slug) }}" class="block w-full h-full">
                            @if($event->image_path)
                                <img alt="{{ $event->title }}" src="{{ Storage::url($event->image_path) }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
                            @else
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <svg class="w-10 h-10 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                </div>
                            @endif
                        </a>
                        
                        {{-- Date Badge --}}
                        <div class="absolute top-3 left-3 bg-white/95 backdrop-blur-sm rounded-xl px-2.5 py-1.5 text-center shadow-md border border-gray-100">
                            <div class="text-[10px] font-black text-rose-600 uppercase leading-none">{{ $event->start_date->translatedFormat('M') }}</div>
                            <div class="text-lg font-black text-gray-900 leading-tight">{{ $event->start_date->format('d') }}</div>
                        </div>
                    </div>

                    {{-- Content --}}
                    <div class="p-4 flex flex-col flex-grow justify-between">
                        <div>
                            <h3 class="font-bold text-gray-900 text-lg mb-1 leading-snug group-hover:text-[#1a6bbf] transition-colors">
                                <a href="{{ route('event.show', $event->slug) }}">{{ $event->title }}</a>
                            </h3>
                            
                            {{-- Rating --}}
                            @php
                                $rating = $event->reviews_avg_rating ?? rand(4,5);
                            @endphp
                            <div class="flex items-center gap-1 mb-2">
                                <div class="flex items-center text-[#00aa6c]">
                                    @for($i = 0; $i < 5; $i++)
                                        <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                </div>
                                <span class="text-xs text-gray-500 font-medium">({{ $event->reviews_count ?? rand(5, 50) }})</span>
                            </div>

                            @if($event->location_name)
                                <div class="flex items-center gap-1 text-xs text-gray-600 mb-2 truncate">
                                    <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="truncate">{{ $event->location_name }}</span>
                                </div>
                            @endif
                            <p class="text-[13px] text-gray-600 line-clamp-2 leading-relaxed">
                                {{ strip_tags($event->description) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        
        <div class="mt-12 flex justify-center">
            {{ $events->links() }}
        </div>
        @else
        <div class="bg-gray-50 rounded-3xl border border-gray-200 p-12 flex flex-col items-center justify-center text-center mt-4">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-1">Tidak Ada Acara Ditemukan</h3>
            <p class="text-gray-500 text-sm max-w-sm mb-6">Coba sesuaikan kata kunci pencarian Anda untuk menemukan acara lainnya.</p>
            <a href="{{ route('event.index') }}" class="px-6 py-2.5 rounded-full bg-[#00aa6c] hover:bg-[#008a57] text-white font-bold text-sm transition shadow-sm">
                Tampilkan Semua Event
            </a>
        </div>
        @endif
    </section>

    {{-- ══════════════════════════════════════════
         6. MOSAIK DOKUMENTASI (Bento Grid Visual)
    ══════════════════════════════════════════ --}}
    @if(!request()->has('q'))
    <section class="py-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto border-t border-gray-100">
        <div class="text-center mb-14">
            <span class="text-xs font-bold tracking-widest uppercase text-[#1a6bbf] block mb-2">Dokumentasi Ragam Acara</span>
            <h2 class="text-3xl sm:text-4xl font-black text-gray-900 mb-3">Mosaik Kemeriahan Sukabumi</h2>
            <p class="text-gray-500 text-sm sm:text-base max-w-xl mx-auto">Potret momen tradisi adat leluhur, aksi peselancar dunia, dan hangatnya perayaan rakyat.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 h-auto md:h-[480px]">
            {{-- Upacara Adat --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full lg:col-span-2 shadow-md">
                <img src="{{ asset('assets/images/6.jpg') }}" alt="Upacara Adat Seren Taun Sukabumi" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-amber-300 uppercase tracking-wider block mb-1">Warisan Leluhur</span>
                    <h3 class="text-2xl font-bold text-white mb-1.5">Kearifan Seren Taun Pasundan</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Tradisi sakral panen padi dan rasa syukur masyarakat adat Kasepuhan Ciptagelar.</p>
                </div>
            </div>
            
            {{-- Surfing & Festival Bahari --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/galeri seputar 1.webp') }}" alt="Kompetisi Selancar Cimaja" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-cyan-300 uppercase tracking-wider block mb-1">Kompetisi Bahari</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Liga Surfing Cimaja</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Peselancar dunia beradu kemampuan di ombak Samudra Hindia.</p>
                </div>
            </div>

            {{-- Karnaval & Seni Budaya --}}
            <div class="group relative rounded-3xl overflow-hidden h-[260px] md:h-full shadow-md">
                <img src="{{ asset('assets/images/10.jpg') }}" alt="Karnaval Budaya Hari Nelayan" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/90 via-gray-900/30 to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6">
                    <span class="text-xs font-bold text-emerald-300 uppercase tracking-wider block mb-1">Pentas Rakyat</span>
                    <h3 class="text-xl font-bold text-white mb-1.5">Festival Hari Nelayan</h3>
                    <p class="text-gray-300 text-xs sm:text-sm">Parade kostum pesisir dan pertunjukan kesenian rakyat di Palabuhanratu.</p>
                </div>
            </div>
        </div>
    </section>
    @endif

    @include('components.footer')
</div>
@endsection
