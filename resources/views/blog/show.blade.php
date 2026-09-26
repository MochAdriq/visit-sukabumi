@extends('layouts.app')

@php
    $seoDescription = Str::limit(strip_tags($post->content), 155);
    
    // Hindari format .avif untuk og:image karena WhatsApp/FB crawler tidak mendukung AVIF
    $hasCompatibleImage = $post->image_path && !str_ends_with(strtolower(strtok($post->image_path, '?')), '.avif');
    $seoImage       = $hasCompatibleImage ? asset('storage/' . $post->image_path) : asset('assets/images/og-default.jpg');
    $seoUrl         = route('blog.show', $post->slug);
    $authorName     = $post->author_name ?? optional($post->author)->name ?? 'Tim Visit Sukabumi';
    $publishedAt    = optional($post->published_at)->toIso8601String();
    $modifiedAt     = optional($post->updated_at)->toIso8601String();
@endphp

{{-- ══ SEO META ══ --}}
@section('title', $post->title . ' — Visit Sukabumi')
@section('meta_description', $seoDescription)
@section('canonical', $seoUrl)
@section('og_type', 'article')
@section('og_title', $post->title)
@section('og_description', $seoDescription)
@section('og_image', $seoImage)
@section('og_image_alt', 'Ilustrasi artikel: ' . $post->title)

{{-- ══ JSON-LD: Article + BreadcrumbList ══ --}}
@push('structured_data')
@php
    $blogSchema = [
        [
            '@type' => 'NewsArticle',
            'headline' => $post->title,
            'description' => $seoDescription,
            'image' => [$seoImage],
            'url' => $seoUrl,
            'datePublished' => $publishedAt,
            'dateModified' => $modifiedAt,
            'author' => [
                '@type' => 'Person',
                'name' => $authorName,
            ],
            'publisher' => [
                '@type' => 'Organization',
                'name' => 'Visit Sukabumi',
                'logo' => [
                    '@type' => 'ImageObject',
                    'url' => asset('assets/images/logo.png'),
                ],
            ],
            'inLanguage' => 'id',
            'mainEntityOfPage' => [
                '@type' => 'WebPage',
                '@id' => $seoUrl,
            ],
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Beranda',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Blog',
                    'item' => route('blog.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $post->category,
                    'item' => route('blog.index', ['category' => $post->category]),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 4,
                    'name' => $post->title,
                    'item' => $seoUrl,
                ],
            ],
        ],
    ];
@endphp
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => $blogSchema], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-[#fafafa] font-sans text-gray-900 pb-20 relative">
    @include('components.navbar')

    {{-- Floating Back to Top Button --}}
    <div x-data="{ showTopBtn: false }" 
         @scroll.window="showTopBtn = (window.pageYOffset > 400)"
         class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-40">
        <button 
            x-show="showTopBtn" 
            x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-4 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-90"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            type="button"
            aria-label="Scroll ke atas"
            title="Kembali ke atas"
            class="w-11 h-11 rounded-full bg-white/95 backdrop-blur-md shadow-xl border border-gray-200 text-gray-700 hover:text-white hover:bg-emerald-700 hover:border-emerald-700 transition-all duration-300 flex items-center justify-center cursor-pointer group hover:scale-105 active:scale-95">
            <svg class="w-5 h-5 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 md:pt-10">

        {{-- ══ BREADCRUMB & KICKER (ANTI-SLOP: MURNI TYPOGRAPHY TANPA PILL BADGE) ══ --}}
        <div class="mb-4">
            <nav class="flex items-center gap-2 text-xs text-gray-500 font-medium overflow-x-auto whitespace-nowrap pb-1">
                <a href="/" class="hover:text-emerald-700 transition-colors">Beranda</a>
                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('blog.index') }}" class="hover:text-emerald-700 transition-colors">Blog</a>
                <svg class="w-3.5 h-3.5 text-gray-300 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="hover:text-emerald-700 transition-colors font-semibold text-gray-700">
                    {{ $post->category }}
                </a>
            </nav>

            {{-- Kicker Kategori Redaksi --}}
            <div class="mt-2 text-xs font-bold uppercase tracking-widest text-emerald-700">
                VISIT SUKABUMI • {{ strtoupper($post->category) }}
            </div>
        </div>

        {{-- ══ JUDUL UTAMA ARTIKEL (KOMPAS EDITORIAL STYLE) ══ --}}
        <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-[40px] font-black text-gray-950 tracking-tight leading-[1.2] mb-5">
            {{ $post->title }}
        </h1>

        {{-- ══ BYLINE & METADATA BAR JURNALISTIK ══ --}}
        <div class="border-y border-gray-200 py-3.5 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            {{-- Info Penulis & Editor --}}
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-full bg-slate-100 border border-slate-200 text-emerald-800 font-bold flex items-center justify-center text-sm shrink-0">
                    {{ strtoupper(substr($post->author_display_name, 0, 1)) }}
                </div>
                <div class="text-xs leading-snug">
                    <div class="font-bold text-gray-900">
                        {{ $post->author_display_name }}
                    </div>
                    <div class="text-gray-500 mt-0.5">
                        <span>Penulis</span>
                        <span class="mx-1 text-gray-300">•</span>
                        <span>Editor: Tim Redaksi Visit Sukabumi</span>
                    </div>
                </div>
            </div>

            {{-- Waktu Publikasi & Shortcut Komentar --}}
            <div class="flex items-center gap-4 text-xs text-gray-500">
                <div class="flex items-center gap-1.5">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ $post->published_at ? $post->published_at->translatedFormat('d F Y, H:i') . ' WIB' : 'Draft Redaksi' }}</span>
                </div>

                <a href="#comments" class="flex items-center gap-1.5 hover:text-emerald-700 transition font-medium border-l border-gray-200 pl-4">
                    <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    <span>{{ $post->comments ? $post->comments->count() : 0 }} Komentar</span>
                </a>
            </div>
        </div>

        {{-- ══ SHARE BAR HORIZONTAL (100% SVG MURNI) ══ --}}
        <div x-data="{ copied: false }" class="mb-8 flex flex-wrap items-center justify-between gap-3 bg-white p-3.5 rounded-2xl border border-gray-200 shadow-xs">
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider mr-1">Bagikan:</span>
                
                {{-- WhatsApp --}}
                <a href="https://api.whatsapp.com/send?text={{ rawurlencode($post->title . ' - ' . route('blog.show', $post->slug)) }}" 
                   target="_blank" rel="noopener noreferrer"
                   title="Bagikan ke WhatsApp"
                   class="w-8 h-8 rounded-full bg-emerald-50 text-emerald-600 hover:bg-emerald-600 hover:text-white transition flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12.04 2c-5.46 0-9.91 4.45-9.91 9.91 0 1.75.46 3.45 1.32 4.95L2.05 22l5.25-1.38c1.45.79 3.08 1.21 4.74 1.21 5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.816 9.816 0 0012.04 2zm5.78 14.07c-.24.68-1.4 1.28-1.93 1.34-.5.06-1.14.09-3.67-.96-3.24-1.34-5.32-4.66-5.48-4.88-.16-.22-1.32-1.76-1.32-3.36 0-1.6 1.05-2.39 1.42-2.71.37-.32.81-.4 1.08-.4.27 0 .54.01.78.02.25.02.58-.09.91.7.34.82 1.16 2.83 1.26 3.04.1.21.17.46.03.73-.13.27-.2.43-.4.66-.2.23-.42.52-.6.7-.2.2-.41.42-.18.82.23.4 1.02 1.68 2.19 2.72 1.5 1.34 2.77 1.75 3.17 1.95.4.2.63.17.87-.1.24-.27 1.01-1.18 1.28-1.58.27-.4.54-.34.91-.2.37.14 2.36 1.11 2.76 1.31.4.2.68.3.78.47.1.17.1.98-.14 1.66z"/>
                    </svg>
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ rawurlencode(route('blog.show', $post->slug)) }}" 
                   target="_blank" rel="noopener noreferrer"
                   title="Bagikan ke Facebook"
                   class="w-8 h-8 rounded-full bg-blue-50 text-blue-600 hover:bg-blue-600 hover:text-white transition flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>

                {{-- X (Twitter) --}}
                <a href="https://twitter.com/intent/tweet?url={{ rawurlencode(route('blog.show', $post->slug)) }}&text={{ rawurlencode($post->title) }}" 
                   target="_blank" rel="noopener noreferrer"
                   title="Bagikan ke X"
                   class="w-8 h-8 rounded-full bg-slate-100 text-slate-800 hover:bg-black hover:text-white transition flex items-center justify-center">
                    <svg class="w-3.5 h-3.5" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                    </svg>
                </a>

                {{-- Telegram --}}
                <a href="https://t.me/share/url?url={{ rawurlencode(route('blog.show', $post->slug)) }}&text={{ rawurlencode($post->title) }}" 
                   target="_blank" rel="noopener noreferrer"
                   title="Bagikan ke Telegram"
                   class="w-8 h-8 rounded-full bg-sky-50 text-sky-600 hover:bg-sky-500 hover:text-white transition flex items-center justify-center">
                    <svg class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm4.64 6.8c-.15 1.58-.8 5.42-1.13 7.19-.14.75-.42 1-.68 1.03-.58.05-1.02-.38-1.58-.75-.88-.58-1.38-.94-2.23-1.5-.99-.65-.35-1.01.22-1.59.15-.15 2.71-2.48 2.76-2.69a.2.2 0 00-.05-.18c-.06-.05-.14-.03-.21-.02-.09.02-1.49.95-4.22 2.79-.4.27-.76.41-1.08.4-.36-.01-1.04-.2-1.55-.37-.63-.2-1.12-.31-1.08-.66.02-.18.27-.36.74-.55 2.92-1.27 4.86-2.11 5.83-2.51 2.78-1.16 3.35-1.36 3.73-1.36.08 0 .27.02.39.12.1.08.13.19.14.27-.01.06.01.24 0 .38z"/>
                    </svg>
                </a>

                {{-- Salin Tautan (Copy Link) --}}
                <button type="button" 
                        @click="navigator.clipboard.writeText('{{ route('blog.show', $post->slug) }}'); copied = true; setTimeout(() => copied = false, 2500)"
                        class="h-8 px-3 rounded-full bg-slate-50 hover:bg-slate-100 border border-slate-200 text-slate-700 text-xs font-semibold flex items-center gap-1.5 transition cursor-pointer">
                    <template x-if="!copied">
                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                    </template>
                    <template x-if="copied">
                        <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                        </svg>
                    </template>
                    <span x-text="copied ? 'Tautan Disalin!' : 'Salin Tautan'">Salin Tautan</span>
                </button>
            </div>

            {{-- Kemudahan Berbagi Modal Lengkap --}}
            <x-share-modal 
                :title="$post->title" 
                :text="'Baca artikel: ' . $post->title . ' di Visit Sukabumi! ' . Str::limit(strip_tags($post->content), 120)" 
                :url="route('blog.show', $post->slug)" 
                :image="$post->image_path ? Storage::url($post->image_path) : null"
                :category="$post->category"
                button-class="text-xs font-bold text-slate-600 hover:text-emerald-700 flex items-center gap-1 transition"
                button-text="Opsi Lain"
            />
        </div>

        {{-- ══ GRID UTAMA: 2 KOLOM (KONTEN 68% : SIDEBAR 32%) ══ --}}
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            {{-- ════════════════════════════════════════════
                 KOLOM KIRI: KONTEN ARTIKEL UTAMA (~68%)
                 ════════════════════════════════════════════ --}}
            <div class="lg:col-span-8 min-w-0">

                {{-- Lead Media: Video Player (16:9) or Featured Image --}}
                @if($post->youtube_embed_url)
                    <figure class="mb-8">
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-md border border-gray-200 bg-black">
                            <iframe 
                                src="{{ $post->youtube_embed_url }}" 
                                title="{{ $post->title }}"
                                class="absolute inset-0 w-full h-full border-0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        </div>
                        <figcaption class="mt-2.5 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-gray-500 gap-1 leading-relaxed">
                            <span>Tayangan video: <strong>{{ $post->title }}</strong></span>
                            <span class="text-slate-400 shrink-0 font-medium">(Video: YouTube)</span>
                        </figcaption>
                    </figure>
                @elseif($post->image_path)
                    <figure class="mb-8">
                        <div class="rounded-2xl overflow-hidden shadow-xs border border-gray-200 bg-slate-100">
                            <img src="{{ Storage::url($post->image_path) }}" 
                                 alt="{{ $post->title }}" 
                                 class="w-full h-auto max-h-[500px] object-cover">
                        </div>
                        <figcaption class="mt-2.5 flex flex-col sm:flex-row sm:items-center justify-between text-xs text-gray-500 gap-1 leading-relaxed">
                            <span>Ilustrasi dokumentasi artikel: <strong>{{ $post->title }}</strong></span>
                            <span class="text-slate-400 shrink-0 font-medium">(Foto: Dok. Visit Sukabumi)</span>
                        </figcaption>
                    </figure>
                @endif

                {{-- ══ BODY ARTIKEL DENGAN IN-ARTICLE AD & BACA JUGA CALLOUT ══ --}}
                @php
                    $contentHtml = $post->content;
                    $paragraphs = explode('</p>', $contentHtml);

                    // 1. In-Article Ad Slot
                    $articleAd = \App\Models\Advertisement::getRandomAd('article_middle', 'blog');
                    $adMarkup = '';
                    if ($articleAd) {
                        $targetAttr = ($articleAd->open_in_new_tab || (isset($articleAd->url) && str_starts_with($articleAd->url, 'http'))) ? '_blank' : '_self';
                        $adMarkup = '
                        <div class="my-8 p-4 sm:p-5 bg-slate-50 border border-slate-200 rounded-2xl overflow-hidden not-prose shadow-xs">
                            <div class="text-[10px] font-extrabold uppercase tracking-widest text-emerald-800 mb-2">
                                <span>Sponsor Pilihan</span>
                            </div>
                            <a href="' . ($articleAd->url ?? '#') . '" target="' . $targetAttr . '" rel="noopener noreferrer" class="block w-full rounded-xl overflow-hidden">
                                <img src="' . $articleAd->image_url . '" alt="' . htmlspecialchars($articleAd->title) . '" class="w-full h-auto max-h-[280px] object-contain mx-auto rounded-xl" />
                            </a>
                        </div>';
                    }

                    // 2. In-Article "Baca juga:" Callout Box (Kompas.com style)
                    $relatedPostInline = $related->first();
                    $bacaJugaMarkup = '';
                    if ($relatedPostInline) {
                        $bacaJugaMarkup = '
                        <div class="my-6 p-4 rounded-xl bg-emerald-50/60 border-l-4 border-emerald-600 not-prose flex items-center justify-between gap-4">
                            <div class="text-sm">
                                <span class="text-[11px] font-extrabold text-emerald-800 uppercase tracking-widest block mb-1">Baca juga:</span>
                                <a href="' . route('blog.show', $relatedPostInline->slug) . '" class="font-bold text-gray-900 hover:text-emerald-700 transition leading-snug">
                                    ' . htmlspecialchars($relatedPostInline->title) . '
                                </a>
                            </div>
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </div>';
                    }

                    // Sisipkan "Baca juga:" di paragraf ke-2
                    if ($bacaJugaMarkup && count($paragraphs) > 2) {
                        array_splice($paragraphs, 2, 0, $bacaJugaMarkup);
                    }

                    // Sisipkan Sponsor Ad di paragraf ke-4 atau ke-5
                    if ($adMarkup && count($paragraphs) > 5) {
                        array_splice($paragraphs, 5, 0, $adMarkup);
                    } elseif ($adMarkup && count($paragraphs) > 3) {
                        array_splice($paragraphs, 3, 0, $adMarkup);
                    } elseif ($adMarkup) {
                        $paragraphs[] = $adMarkup;
                    }

                    $finalContentHtml = implode('</p>', $paragraphs);
                @endphp

                <article class="article-body bg-white p-6 sm:p-8 md:p-12 rounded-3xl shadow-xs border border-gray-200 mb-10 text-gray-800 text-[17px] md:text-[18px] leading-[1.85] font-normal">
                    {!! $finalContentHtml !!}
                </article>

                {{-- ══ TOPIK / TAG WISATA (CLEAN TEXT LINKS) ══ --}}
                <div class="mb-10 p-5 bg-white rounded-2xl border border-gray-200">
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-widest block mb-3">Topik Terkait:</span>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('blog.index', ['category' => $post->category]) }}" class="text-xs font-semibold text-gray-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-3 py-1.5 rounded-lg transition">
                            #{{ $post->category }}
                        </a>
                        <a href="{{ route('blog.index', ['q' => 'wisata']) }}" class="text-xs font-semibold text-gray-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-3 py-1.5 rounded-lg transition">
                            #WisataSukabumi
                        </a>
                        <a href="{{ route('blog.index', ['q' => 'kuliner']) }}" class="text-xs font-semibold text-gray-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-3 py-1.5 rounded-lg transition">
                            #KulinerSukabumi
                        </a>
                        <a href="{{ route('blog.index', ['q' => 'geopark']) }}" class="text-xs font-semibold text-gray-700 bg-slate-100 hover:bg-emerald-50 hover:text-emerald-700 px-3 py-1.5 rounded-lg transition">
                            #GeoparkCiletuh
                        </a>
                    </div>
                </div>

                {{-- ══ KOTAK PROFIL PENULIS (AUTHOR BIO) ══ --}}
                <div class="mb-10 p-6 bg-white rounded-2xl border border-gray-200 flex flex-col sm:flex-row items-center sm:items-start gap-4 text-center sm:text-left">
                    <div class="w-14 h-14 rounded-full bg-emerald-700 text-white font-black text-lg flex items-center justify-center shrink-0 shadow-sm">
                        {{ strtoupper(substr($post->author_display_name, 0, 1)) }}
                    </div>
                    <div>
                        <div class="text-xs font-bold uppercase tracking-wider text-emerald-700">Kontributor Visit Sukabumi</div>
                        <h4 class="text-base font-extrabold text-gray-900 mt-0.5">{{ $post->author_display_name }}</h4>
                        <p class="text-xs text-gray-600 mt-1 leading-relaxed">
                            Mendedikasikan ulasan informatif seputar ragam pesona alam, cagar budaya, kuliner legendaris, serta tips praktis menjelajah wilayah Sukabumi.
                        </p>
                    </div>
                </div>

                {{-- ══ DISCLAIMER REDAKSI ══ --}}
                <div class="mb-12 p-4 bg-slate-100/70 rounded-xl border border-slate-200 text-xs text-slate-500 leading-relaxed">
                    <strong class="text-slate-700">Disclaimer Redaksi:</strong> Seluruh informasi jam operasional, harga tiket, dan rute perjalanan dapat berubah sewaktu-waktu sesuai kebijakan pengelola lokasi maupun pemerintah daerah setempat. Disarankan melakukan konfirmasi sebelum keberangkatan.
                </div>

                {{-- ══ DAFTAR DESTINASI TERKAIT ($post->places) ══ --}}
                @if($post->places && $post->places->count() > 0)
                    <section class="mb-14 pt-8 border-t border-gray-200" 
                        x-data="{
                            canScrollLeft: false,
                            canScrollRight: true,
                            checkScroll() {
                                const el = this.$refs.placeSlider;
                                if (!el) return;
                                this.canScrollLeft = el.scrollLeft > 10;
                                this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 10);
                            },
                            scrollLeft() {
                                const el = this.$refs.placeSlider;
                                const card = el.querySelector('.place-slider-item');
                                const step = card ? card.offsetWidth + 20 : 280;
                                el.scrollBy({ left: -step, behavior: 'smooth' });
                            },
                            scrollRight() {
                                const el = this.$refs.placeSlider;
                                const card = el.querySelector('.place-slider-item');
                                const step = card ? card.offsetWidth + 20 : 280;
                                el.scrollBy({ left: step, behavior: 'smooth' });
                            }
                        }"
                        x-init="$nextTick(() => checkScroll())">
                        
                        <div class="flex items-center justify-between mb-6">
                            <div>
                                <h2 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight">Destinasi yang Disebutkan</h2>
                                <p class="text-xs md:text-sm text-gray-500 mt-1">
                                    {{ $post->places->count() }} lokasi wisata terkait dalam ulasan ini.
                                </p>
                            </div>

                            @if($post->places->count() > 2)
                                <div class="flex items-center gap-2">
                                    <button 
                                        @click="scrollLeft()"
                                        :disabled="!canScrollLeft"
                                        :class="{ 'opacity-40 cursor-not-allowed': !canScrollLeft, 'hover:bg-emerald-700 hover:text-white hover:border-emerald-700 cursor-pointer': canScrollLeft }"
                                        type="button" 
                                        aria-label="Geser ke kiri"
                                        title="Geser ke kiri"
                                        class="w-9 h-9 rounded-full border border-gray-200 bg-white shadow-xs flex items-center justify-center text-gray-700 transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                        </svg>
                                    </button>
                                    <button 
                                        @click="scrollRight()"
                                        :disabled="!canScrollRight"
                                        :class="{ 'opacity-40 cursor-not-allowed': !canScrollRight, 'hover:bg-emerald-700 hover:text-white hover:border-emerald-700 cursor-pointer': canScrollRight }"
                                        type="button" 
                                        aria-label="Geser ke kanan"
                                        title="Geser ke kanan"
                                        class="w-9 h-9 rounded-full border border-gray-200 bg-white shadow-xs flex items-center justify-center text-gray-700 transition-all active:scale-95">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                        </svg>
                                    </button>
                                </div>
                            @endif
                        </div>

                        <div 
                            x-ref="placeSlider"
                            @scroll.debounce.50ms="checkScroll()"
                            class="flex gap-4 overflow-x-auto scroll-smooth pb-3 snap-x snap-mandatory [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                            @foreach($post->places as $place)
                                <div class="place-slider-item w-[85%] sm:w-[calc((100%-16px)/2)] md:w-[calc((100%-32px)/3)] shrink-0 snap-start flex flex-col h-full">
                                    <x-place-card-grid :place="$place" />
                                </div>
                            @endforeach
                        </div>
                    </section>
                @endif

                {{-- ══ COMMENTS SECTION (AUTO-RESTORE DRAFT SUPPORTED) ══ --}}
                <section id="comments" class="pt-8 border-t border-gray-200">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl md:text-2xl font-black text-gray-900 tracking-tight">Komentar Pembaca</h3>
                            <p class="text-xs text-gray-500 mt-1">{{ $post->comments ? $post->comments->count() : 0 }} tanggapan pada artikel ini</p>
                        </div>
                    </div>

                    {{-- Alert Berhasil Kirim --}}
                    @if(session('comment_success'))
                        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 flex items-center gap-3 text-sm">
                            <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span>{{ session('comment_success') }}</span>
                        </div>
                    @endif

                    {{-- Form Komentar --}}
                    <div class="bg-white rounded-3xl p-6 md:p-8 shadow-xs border border-gray-200 mb-10" x-data="blogCommentComponent()">
                        <h4 class="text-sm font-bold text-gray-900 mb-4 flex items-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Tinggalkan Komentar
                        </h4>

                        <div x-show="draftRestored" class="mb-5 p-3.5 bg-emerald-50 border border-emerald-200 rounded-xl text-emerald-800 text-xs flex items-center gap-2.5" style="display: none;">
                            <svg class="w-4 h-4 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span><strong>Draf komentar Anda dipulihkan!</strong> Silakan lanjutkan atau klik Kirim.</span>
                        </div>

                        <form action="{{ route('blog.comment.store', $post->slug) }}" method="POST" @submit.prevent="submitBlogComment($event)">
                            @csrf

                            @auth
                                <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-xl mb-4 border border-gray-100">
                                    <div class="w-8 h-8 rounded-full bg-emerald-700 text-white flex items-center justify-center font-bold text-xs">
                                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                    </div>
                                    <div class="text-xs">
                                        <span class="text-gray-500">Berkomentar sebagai</span>
                                        <span class="font-bold text-gray-800 ml-1">{{ auth()->user()->name }}</span>
                                    </div>
                                </div>
                            @else
                                <div class="flex items-center gap-2.5 p-3 bg-emerald-50/70 border border-emerald-100 rounded-xl mb-4 text-xs text-emerald-900">
                                    <svg class="w-4 h-4 text-emerald-700 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span>Ketik komentar Anda. Draf akan otomatis tersimpan jika Anda belum masuk.</span>
                                </div>
                            @endauth

                            <div class="mb-4">
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Tulis Komentar <span class="text-red-500">*</span></label>
                                <textarea name="comment" x-ref="commentInput" rows="4" required placeholder="Tuliskan pandangan, tanggapan, atau pengalaman Anda..."
                                    class="w-full p-4 rounded-xl border border-gray-200 focus:border-emerald-600 focus:ring-2 focus:ring-emerald-600/20 outline-none text-sm transition resize-y">{{ old('comment') }}</textarea>
                                @error('comment')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center justify-between">
                                @guest
                                    <p class="text-xs text-gray-500">
                                        Sudah punya akun? <a href="{{ route('login') }}" class="text-emerald-700 font-bold hover:underline">Masuk</a>
                                    </p>
                                @else
                                    <div></div>
                                @endguest

                                <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-emerald-700 text-white font-bold text-sm rounded-full hover:bg-emerald-800 transition shadow-xs cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    Kirim Komentar
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- List Komentar --}}
                    @if($post->comments && $post->comments->count() > 0)
                        <div class="space-y-4">
                            @foreach($post->comments as $c)
                                <div class="bg-white rounded-2xl p-5 sm:p-6 shadow-xs border border-gray-200">
                                    <div class="flex items-start justify-between gap-4 mb-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-9 h-9 rounded-full {{ $c->is_admin ? 'bg-emerald-700 text-white ring-2 ring-emerald-200' : 'bg-slate-200 text-slate-700' }} flex items-center justify-center font-bold text-xs shrink-0">
                                                {{ $c->author_initials }}
                                            </div>
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="font-bold text-gray-900 text-sm">{{ $c->author_name }}</span>
                                                    @if($c->is_admin)
                                                        <span class="text-[10px] font-extrabold text-emerald-700 uppercase tracking-widest">
                                                            • Tim Redaksi
                                                        </span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-400">
                                                    {{ $c->created_at->diffForHumans() }}
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line pl-0 sm:pl-12">
                                        {{ $c->comment }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-white rounded-2xl p-8 border border-dashed border-gray-200 text-center">
                            <p class="font-bold text-gray-700 text-sm">Belum Ada Komentar</p>
                            <p class="text-xs text-gray-400 mt-1">Jadilah yang pertama memberikan ulasan untuk artikel ini.</p>
                        </div>
                    @endif
                </section>

            </div>

            {{-- ════════════════════════════════════════════
                 KOLOM KANAN: SIDEBAR (~32%)
                 ════════════════════════════════════════════ --}}
            <aside class="lg:col-span-4 space-y-8">

                {{-- ══ WIDGET 1: TERPOPULER (TOP 5 KOMPAS.COM STYLE) ══ --}}
                <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xs">
                    <div class="flex items-center justify-between border-b-2 border-emerald-700 pb-2.5 mb-5">
                        <h3 class="text-sm font-black uppercase tracking-wider text-gray-900">
                            TERPOPULER
                        </h3>
                        <span class="text-[11px] text-gray-400 font-medium">Banyak Dibaca</span>
                    </div>

                    <div class="divide-y divide-gray-100">
                        @forelse($popularPosts as $index => $pop)
                            <a href="{{ route('blog.show', $pop->slug) }}" class="group py-3.5 first:pt-0 last:pb-0 flex items-start gap-4">
                                {{-- Angka Peringkat 1 s/d 5 Khas Kompas --}}
                                <span class="text-2xl font-black text-slate-300 group-hover:text-emerald-700 transition w-6 shrink-0 text-center">
                                    {{ $index + 1 }}
                                </span>
                                <div class="min-w-0 flex-1">
                                    <div class="text-[10px] font-extrabold uppercase tracking-wider text-emerald-700 mb-1">
                                        {{ $pop->category }}
                                    </div>
                                    <h4 class="text-xs font-bold text-gray-900 group-hover:text-emerald-700 transition leading-snug line-clamp-2">
                                        {{ $pop->title }}
                                    </h4>
                                    <div class="text-[11px] text-gray-400 mt-1">
                                        {{ $pop->published_at ? $pop->published_at->format('d/m/Y') : '' }}
                                    </div>
                                </div>
                            </a>
                        @empty
                            <p class="text-xs text-gray-400 py-2">Belum ada artikel terpopuler lainnya.</p>
                        @endforelse
                    </div>
                </div>

                {{-- ══ WIDGET 2: SPONSOR / BANNER RESMI (JIKA ADA) ══ --}}
                @php
                    $sidebarAd = \App\Models\Advertisement::getRandomAd('sidebar', 'blog');
                @endphp
                @if($sidebarAd)
                    <div class="bg-white rounded-2xl p-5 border border-gray-200 shadow-xs">
                        <div class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400 mb-3 text-center">
                            Sponsor Resmi
                        </div>
                        <a href="{{ $sidebarAd->url ?? '#' }}" 
                           target="{{ ($sidebarAd->open_in_new_tab || (isset($sidebarAd->url) && str_starts_with($sidebarAd->url, 'http'))) ? '_blank' : '_self' }}"
                           rel="noopener noreferrer" 
                           class="block w-full rounded-xl overflow-hidden group">
                            <img src="{{ $sidebarAd->image_url }}" alt="{{ $sidebarAd->title }}" class="w-full h-auto object-cover rounded-xl group-hover:scale-[1.02] transition duration-300">
                        </a>
                    </div>
                @endif

                {{-- ══ WIDGET 3: REKOMENDASI TEMPAT WISATA UNGGULAN ══ --}}
                @if(isset($recommendedPlaces) && $recommendedPlaces->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xs">
                        <div class="flex items-center justify-between border-b-2 border-slate-900 pb-2.5 mb-5">
                            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900">
                                DESTINASI PILIHAN
                            </h3>
                            <a href="{{ route('place.index') }}" class="text-[11px] font-bold text-emerald-700 hover:underline">
                                Semua &rarr;
                            </a>
                        </div>

                        <div class="space-y-4">
                            @foreach($recommendedPlaces as $rPlace)
                                <a href="{{ route('place.show', $rPlace->slug) }}" class="group flex items-center gap-3.5">
                                    <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-gray-100">
                                        <img src="{{ $rPlace->cover_image_url }}" alt="{{ $rPlace->name }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block truncate">
                                            {{ $rPlace->category->name ?? 'Wisata' }}
                                        </span>
                                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-emerald-700 transition truncate leading-snug">
                                            {{ $rPlace->name }}
                                        </h4>
                                        <p class="text-[11px] text-gray-400 truncate mt-0.5">
                                            {{ $rPlace->district ?? 'Sukabumi' }}
                                        </p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ══ WIDGET 4: ARTIKEL TERKAIT LAINNYA ══ --}}
                @if($related->count() > 0)
                    <div class="bg-white rounded-2xl p-6 border border-gray-200 shadow-xs">
                        <div class="border-b-2 border-slate-300 pb-2.5 mb-5">
                            <h3 class="text-sm font-black uppercase tracking-wider text-gray-900">
                                ARTIKEL TERKAIT
                            </h3>
                        </div>

                        <div class="space-y-4">
                            @foreach($related as $rPost)
                                <a href="{{ route('blog.show', $rPost->slug) }}" class="group flex items-center gap-3.5">
                                    @if($rPost->image_path)
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-slate-100 shrink-0 border border-gray-100">
                                            <img src="{{ Storage::url($rPost->image_path) }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                        </div>
                                    @endif
                                    <div class="min-w-0 flex-1">
                                        <span class="text-[10px] font-bold uppercase tracking-wider text-emerald-700 block truncate">
                                            {{ $rPost->category }}
                                        </span>
                                        <h4 class="text-xs font-bold text-gray-900 group-hover:text-emerald-700 transition line-clamp-2 leading-snug">
                                            {{ $rPost->title }}
                                        </h4>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif

            </aside>

        </div>

    </main>
</div>

@include('components.footer')

<script>
    function blogCommentComponent() {
        return {
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            draftRestored: false,

            init() {
                this.checkRestoredDraft();
            },

            checkRestoredDraft() {
                try {
                    const saved = localStorage.getItem('vs_pending_blog_comment');
                    if (!saved) return;
                    const draft = JSON.parse(saved);
                    if (draft.slug === '{{ $post->slug }}') {
                        if (Date.now() - (draft.timestamp || 0) < 24 * 60 * 60 * 1000) {
                            setTimeout(() => {
                                const textarea = this.$refs.commentInput;
                                if (textarea && draft.comment) {
                                    textarea.value = draft.comment;
                                    this.draftRestored = true;
                                    const commentSec = document.getElementById('comments');
                                    if (commentSec) {
                                        commentSec.scrollIntoView({ behavior: 'smooth', block: 'start' });
                                    }
                                }
                            }, 350);
                        }
                    }
                } catch (e) {
                    console.error('Gagal memulihkan draf komentar blog:', e);
                }
            },

            submitBlogComment(e) {
                const form = e.target;
                const textarea = this.$refs.commentInput;
                const commentVal = textarea ? textarea.value.trim() : '';

                if (!commentVal) {
                    return;
                }

                if (!this.isLoggedIn) {
                    const draft = {
                        slug: '{{ $post->slug }}',
                        comment: commentVal,
                        timestamp: Date.now()
                    };
                    localStorage.setItem('vs_pending_blog_comment', JSON.stringify(draft));

                    const currentUrl = window.location.href.split('#')[0] + '#comments';
                    window.location.href = '{{ route('login') }}?redirect=' + encodeURIComponent(currentUrl);
                    return;
                }

                localStorage.removeItem('vs_pending_blog_comment');
                form.submit();
            }
        };
    }
</script>
@endsection
