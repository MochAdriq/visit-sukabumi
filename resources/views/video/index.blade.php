@extends('layouts.app')

@section('title', 'Galeri Video & Dokumentasi Wisata Sukabumi - Visit Sukabumi')
@section('meta_description', 'Saksikan kompilasi video dokumentasi keindahan alam, Geopark Ciletuh UNESCO, pesona pantai, air terjun, dan budaya lokal Sukabumi dalam visual sinematik.')
@section('og_image', asset('images/logo-v2.png'))

@section('content')
<div x-data="{ 
    activeEmbedUrl: '', 
    activeTitle: '', 
    isPlayerOpen: false,
    openVideo(url, title) {
        this.activeEmbedUrl = url + (url.includes('?') ? '&autoplay=1' : '?autoplay=1');
        this.activeTitle = title;
        this.isPlayerOpen = true;
        document.body.classList.add('overflow-hidden');
    },
    closeVideo() {
        this.isPlayerOpen = false;
        this.activeEmbedUrl = '';
        this.activeTitle = '';
        document.body.classList.remove('overflow-hidden');
    }
}" 
@keydown.escape.window="closeVideo()" 
class="min-h-screen bg-gray-50 text-gray-900 pb-20">

    {{-- ══════════════════════════════════════════════════════
         HERO BANNER (Cinematic Dark Ocean & Forest Theme)
         ══════════════════════════════════════════════════════ --}}
    <section class="relative bg-gradient-to-br from-[#071526] via-[#0F294A] to-[#163B66] text-white pt-10 pb-16 md:pt-14 md:pb-20 overflow-hidden">
        {{-- Background Glow & Geometric Accents --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div class="absolute -top-24 -right-24 w-96 h-96 rounded-full bg-blue-500/10 blur-3xl"></div>
            <div class="absolute bottom-0 -left-20 w-80 h-80 rounded-full bg-emerald-500/10 blur-3xl"></div>
            <div class="absolute inset-0 bg-[radial-gradient(#ffffff_1px,transparent_1px)] [background-size:24px_24px] opacity-5"></div>
        </div>

        <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            {{-- Breadcrumbs --}}
            <nav class="flex items-center gap-2 text-xs text-blue-200/80 mb-6 font-medium">
                <a href="{{ url('/') }}" class="hover:text-white transition-colors flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span>Beranda</span>
                </a>
                <span>/</span>
                <span class="text-white font-semibold">Galeri Video</span>
            </nav>

            <div class="max-w-3xl">
                <p class="text-xs font-bold uppercase tracking-wider text-blue-300 mb-3">
                    Dokumentasi Sinematik
                </p>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-black text-white tracking-tight leading-tight">
                    Sukabumi Dalam Lensa Video
                </h1>
                <p class="text-base sm:text-lg text-blue-100/90 mt-3 md:mt-4 leading-relaxed font-normal">
                    Rasakan atmosfer nyata kemegahan Geopark Ciletuh UNESCO, deburan ombak pantai selatan, keindahan air terjun asri, dan kehangatan budaya masyarakat Sukabumi.
                </p>
            </div>
        </div>
    </section>

    {{-- ══════════════════════════════════════════════════════
         MAIN CONTENT AREA
         ══════════════════════════════════════════════════════ --}}
    <div class="max-w-[1380px] mx-auto px-4 sm:px-6 lg:px-8 -mt-6 sm:-mt-8 relative z-20">

        {{-- Category Filters Card --}}
        <div class="bg-white rounded-2xl p-3 sm:p-4 shadow-xl border border-gray-100 flex items-center justify-between gap-4 overflow-hidden mb-8 sm:mb-12">
            <div class="flex items-center gap-2 overflow-x-auto no-scrollbar w-full py-1">
                @foreach($categories as $slug => $label)
                    @php
                        $isSelected = ($selectedCategory === $slug);
                    @endphp
                    <a href="{{ route('video.index', ['category' => $slug]) }}" 
                       class="whitespace-nowrap px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-bold transition-all flex items-center gap-2 {{ $isSelected ? 'bg-[#1a6bbf] text-white shadow-md shadow-blue-500/20' : 'bg-gray-50 text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
                        @if($slug === 'all')
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-gray-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                        @elseif($slug === 'Wisata Alam')
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-emerald-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        @elseif($slug === 'Budaya & Event')
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-amber-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        @elseif($slug === 'Kuliner')
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-orange-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 {{ $isSelected ? 'text-white' : 'text-purple-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        @endif
                        <span>{{ $label }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════════
             FEATURED SPOTLIGHT (Only on Page 1 & All Categories)
             ══════════════════════════════════════════════════════ --}}
        @if($featuredVideo && $videos->currentPage() === 1 && $selectedCategory === 'all')
        <div class="mb-10 sm:mb-14">
            <div class="bg-gradient-to-br from-slate-900 via-slate-800 to-indigo-950 text-white rounded-3xl p-5 sm:p-8 lg:p-10 shadow-2xl border border-slate-700/50 relative overflow-hidden">
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    {{-- Left / Video Thumbnail Preview --}}
                    <div class="lg:col-span-7">
                        <div class="relative group cursor-pointer aspect-video rounded-2xl overflow-hidden shadow-2xl bg-black border border-white/10"
                             @click="openVideo('{{ $featuredVideo->embed_url }}', '{{ addslashes($featuredVideo->title) }}')">
                            
                            {{-- High Quality Thumbnail with fallback --}}
                            <img src="{{ $featuredVideo->thumbnail_url }}" 
                                 onerror="this.onerror=null; this.src='{{ $featuredVideo->hq_thumbnail_url }}';" 
                                 alt="{{ $featuredVideo->title }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-90 group-hover:opacity-100">
                            
                            {{-- Dark Overlay --}}
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-black/30 group-hover:from-black/60 transition-colors"></div>

                            {{-- Pulsing Play Button Center --}}
                            <div class="absolute inset-0 flex items-center justify-center">
                                <div class="relative flex items-center justify-center">
                                    <div class="absolute w-20 h-20 rounded-full bg-red-600/40 animate-ping"></div>
                                    <div class="w-16 h-16 sm:w-20 sm:h-20 rounded-full bg-red-600 group-hover:bg-red-500 text-white flex items-center justify-center shadow-xl shadow-red-600/40 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-7 h-7 sm:w-8 sm:h-8 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Right / Video Metadata --}}
                    <div class="lg:col-span-5 flex flex-col justify-center">
                        <p class="text-xs font-bold uppercase tracking-wider text-[#F8BE2C] mb-2">
                            Pilihan Utama <span class="text-slate-500 mx-1.5">•</span> <span class="text-blue-200 font-semibold">{{ $featuredVideo->category }}</span>
                            @if($featuredVideo->duration)
                                <span class="text-slate-500 mx-1.5">•</span> <span class="text-slate-300 font-normal tracking-normal">{{ $featuredVideo->duration }}</span>
                            @endif
                        </p>

                        <h2 class="text-xl sm:text-2xl lg:text-3xl font-extrabold text-white leading-snug mb-3">
                            {{ $featuredVideo->title }}
                        </h2>

                        @if($featuredVideo->description)
                        <p class="text-sm sm:text-base text-gray-300 leading-relaxed mb-6 line-clamp-3">
                            {{ $featuredVideo->description }}
                        </p>
                        @endif

                        <div class="pt-2">
                            <button type="button" 
                                    @click="openVideo('{{ $featuredVideo->embed_url }}', '{{ addslashes($featuredVideo->title) }}')"
                                    class="inline-flex items-center gap-3 px-6 py-3.5 rounded-2xl bg-red-600 hover:bg-red-500 text-white font-bold text-sm shadow-xl shadow-red-600/30 transition-all transform hover:-translate-y-0.5 cursor-pointer">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M8 5v14l11-7z"/>
                                </svg>
                                <span>Tonton Dokumentasi Sekarang</span>
                            </button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        @endif

        {{-- ══════════════════════════════════════════════════════
             GRID OF VIDEOS
             ══════════════════════════════════════════════════════ --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl sm:text-2xl font-black text-gray-900 tracking-tight">
                        {{ $categories[$selectedCategory] ?? 'Semua Video' }}
                    </h2>
                    <p class="text-xs sm:text-sm text-gray-500 mt-1">
                        Menampilkan {{ $videos->total() }} video dokumentasi pilihan
                    </p>
                </div>
            </div>

            @if($videos->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
                    @foreach($videos as $video)
                        <article class="bg-white rounded-2xl overflow-hidden shadow-xs hover:shadow-xl transition-all duration-300 border border-gray-100 flex flex-col group">
                            
                            {{-- Video Thumbnail Area --}}
                            <div class="relative aspect-video overflow-hidden bg-gray-900 cursor-pointer"
                                 @click="openVideo('{{ $video->embed_url }}', '{{ addslashes($video->title) }}')">
                                
                                <img src="{{ $video->thumbnail_url }}" 
                                     onerror="this.onerror=null; this.src='{{ $video->hq_thumbnail_url }}';" 
                                     alt="{{ $video->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 opacity-95 group-hover:opacity-100" 
                                     loading="lazy">

                                {{-- Dark Hover Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/10 to-black/20 group-hover:from-black/50 transition-colors"></div>

                                {{-- Play Button Icon --}}
                                <div class="absolute inset-0 flex items-center justify-center">
                                    <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-full bg-red-600 group-hover:bg-red-500 text-white flex items-center justify-center shadow-lg shadow-red-600/30 group-hover:scale-110 transition-transform duration-300">
                                        <svg class="w-5 h-5 sm:w-6 sm:h-6 translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M8 5v14l11-7z"/>
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            {{-- Card Body --}}
                            <div class="p-5 flex-1 flex flex-col justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-wider text-[#1a6bbf] mb-2">
                                        {{ $video->category }}
                                        @if($video->duration)
                                            <span class="text-gray-300 font-normal mx-1.5">•</span>
                                            <span class="text-gray-500 font-normal tracking-normal">{{ $video->duration }}</span>
                                        @endif
                                    </p>
                                    <h3 class="text-base sm:text-lg font-bold text-gray-900 group-hover:text-[#1a6bbf] transition-colors line-clamp-2 leading-snug cursor-pointer"
                                        @click="openVideo('{{ $video->embed_url }}', '{{ addslashes($video->title) }}')">
                                        {{ $video->title }}
                                    </h3>

                                    @if($video->description)
                                    <p class="text-xs sm:text-sm text-gray-500 mt-2 line-clamp-2 leading-relaxed">
                                        {{ $video->description }}
                                    </p>
                                    @endif
                                </div>

                                <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                                    <div class="flex items-center gap-1.5 text-xs text-gray-400">
                                        <svg class="w-4 h-4 text-red-600 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/>
                                        </svg>
                                        <span>YouTube Video</span>
                                    </div>

                                    <button type="button" 
                                            @click="openVideo('{{ $video->embed_url }}', '{{ addslashes($video->title) }}')"
                                            class="inline-flex items-center gap-1 text-xs font-bold text-[#1a6bbf] hover:text-blue-800 transition-colors cursor-pointer">
                                        <span>Tonton</span>
                                        <svg class="w-3.5 h-3.5 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            </div>

                        </article>
                    @endforeach
                </div>

                {{-- Pagination --}}
                <div class="mt-12 flex justify-center">
                    {{ $videos->links() }}
                </div>
            @else
                {{-- Empty State --}}
                <div class="bg-white rounded-3xl p-12 text-center border border-gray-200 shadow-xs max-w-lg mx-auto">
                    <div class="w-16 h-16 rounded-full bg-blue-50 text-[#1a6bbf] flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-gray-900">Belum ada video di kategori ini</h3>
                    <p class="text-sm text-gray-500 mt-1 mb-6">
                        Pilih kategori lain untuk melihat dokumentasi wisata menarik lainnya.
                    </p>
                    <a href="{{ route('video.index') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-[#1a6bbf] text-white text-xs font-bold hover:bg-blue-700 transition">
                        <span>Lihat Semua Video</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            @endif
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════
         LIGHTBOX / MODAL VIDEO PLAYER (ALPINES.JS)
         ══════════════════════════════════════════════════════ --}}
    <div x-show="isPlayerOpen" 
         x-cloak
         style="display: none;"
         class="fixed inset-0 z-[99999] flex items-center justify-center p-3 sm:p-6 md:p-10">
        
        {{-- Backdrop --}}
        <div @click="closeVideo()" 
             x-show="isPlayerOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-black/85 backdrop-blur-md"></div>

        {{-- Modal Window --}}
        <div x-show="isPlayerOpen"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 scale-100"
             x-transition:leave-end="opacity-0 scale-95"
             class="relative bg-slate-900 rounded-2xl sm:rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden border border-white/10 z-10 flex flex-col">
            
            {{-- Header Bar --}}
            <div class="px-4 py-3 sm:px-6 sm:py-4 bg-slate-950 flex items-center justify-between border-b border-white/10">
                <div class="flex items-center gap-2.5 min-w-0 pr-4">
                    <span class="w-2.5 h-2.5 rounded-full bg-red-600 animate-pulse flex-shrink-0"></span>
                    <h4 class="text-xs sm:text-sm font-bold text-white truncate" x-text="activeTitle || 'Pemutar Video Wisata'"></h4>
                </div>
                <button @click="closeVideo()" 
                        type="button" 
                        class="text-gray-400 hover:text-white p-1 rounded-lg hover:bg-white/10 transition-colors cursor-pointer flex-shrink-0" 
                        aria-label="Tutup Video">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            {{-- 16:9 Iframe Container --}}
            <div class="relative aspect-video w-full bg-black">
                <template x-if="isPlayerOpen">
                    <iframe :src="activeEmbedUrl" 
                            class="absolute inset-0 w-full h-full border-0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                            allowfullscreen></iframe>
                </template>
            </div>

            {{-- Footer Note --}}
            <div class="px-4 py-2.5 sm:px-6 bg-slate-950 text-right">
                <span class="text-[11px] text-gray-400">Tekan tombol <kbd class="px-1.5 py-0.5 bg-white/10 rounded text-gray-200">ESC</kbd> atau klik di luar untuk menutup</span>
            </div>
        </div>
    </div>

</div>
@endsection
