@extends('layouts.app')

@php
    $waText = urlencode("Halo, saya mendapatkan informasi tempat ini (*{$place->name}*) dari website panduan wisata *Visit Sukabumi* (visitsukabumi.com).\n\nSaya ingin bertanya untuk informasi lebih lanjut.");
    $restoWaText = urlencode("Halo, saya mendapatkan informasi restoran ini (*{$place->name}*) dari website panduan wisata *Visit Sukabumi* (visitsukabumi.com).\n\nSaya ingin bertanya terkait reservasi meja.");
    $seoTitle       = $place->name . ' — ' . (optional($place->category)->name ?? 'Destinasi Wisata') . ' Sukabumi | Visit Sukabumi';
    $seoDescription = Str::limit(strip_tags($place->description ?? ''), 155) ?: 'Temukan info lengkap, harga tiket, ulasan pengunjung, dan fasilitas ' . $place->name . ' di Sukabumi.';
    $seoImage       = $place->cover_image_url;
    $seoUrl         = route('place.show', $place->slug);
    $avgRating      = round($place->reviews()->avg('rating') ?? 0, 1);
    $reviewCount    = $place->reviews()->count();
@endphp

{{-- ══ SEO META ══ --}}
@section('title', $seoTitle)
@section('meta_description', $seoDescription)
@section('canonical', $seoUrl)
@section('og_type', 'article')
@section('og_title', $place->name . ' — Visit Sukabumi')
@section('og_description', $seoDescription)
@section('og_image', $seoImage)
@section('og_image_alt', 'Foto ' . $place->name . ' di Sukabumi')

{{-- ══ JSON-LD: TouristAttraction + BreadcrumbList ══ --}}
@push('structured_data')
@php
    $schemaGraph = [
        [
            '@type' => 'TouristAttraction',
            'name' => $place->name,
            'description' => Str::limit(strip_tags($place->description ?? ''), 200),
            'url' => $seoUrl,
            'image' => $seoImage,
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => $place->district ?? 'Sukabumi',
                'addressRegion' => 'Jawa Barat',
                'addressCountry' => 'ID',
            ],
            'inLanguage' => 'id',
            'isAccessibleForFree' => (!$place->has_ticket && !$place->has_general_price),
            'touristType' => 'Wisatawan Umum',
        ],
        [
            '@type' => 'BreadcrumbList',
            'itemListElement' => [
                [
                    '@type' => 'ListItem',
                    'position' => 1,
                    'name' => 'Home',
                    'item' => url('/'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 2,
                    'name' => 'Destinasi',
                    'item' => route('place.index'),
                ],
                [
                    '@type' => 'ListItem',
                    'position' => 3,
                    'name' => $place->name,
                    'item' => $seoUrl,
                ],
            ],
        ],
    ];

    if ($place->latitude && $place->longitude) {
        $schemaGraph[0]['geo'] = [
            '@type' => 'GeoCoordinates',
            'latitude' => (float) $place->latitude,
            'longitude' => (float) $place->longitude,
        ];
    }

    if ($reviewCount > 0) {
        $schemaGraph[0]['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $avgRating,
            'reviewCount' => (string) $reviewCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }

    if ($place->phone) {
        $schemaGraph[0]['telephone'] = $place->phone;
    }
@endphp
<script type="application/ld+json">
{!! json_encode(['@context' => 'https://schema.org', '@graph' => $schemaGraph], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}
</script>
@endpush

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900">
    @include('components.navbar')

    @if($place->status !== 'published')
        <div class="bg-amber-500 text-white px-4 py-2.5 shadow-md">
            <div class="max-w-7xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-3 text-xs sm:text-sm font-medium">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    <span><strong>Mode Pratinjau:</strong> Destinasi ini masih berstatus <span class="uppercase font-bold tracking-wider underline">{{ $place->status }}</span> dan tidak dapat diakses oleh publik.</span>
                </div>
                <a href="{{ url('/admin/places/' . $place->id . '/edit') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1 bg-white text-amber-800 font-bold rounded-full hover:bg-amber-50 transition text-xs shadow-sm whitespace-nowrap">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Edit di Admin
                </a>
            </div>
        </div>
    @endif

    <main class="pt-6">

        {{-- ══ BREADCRUMB ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-2">
            <nav class="flex text-xs md:text-sm text-gray-500 gap-2 items-center flex-wrap">
                <a href="{{ url('/') }}" class="hover:underline hover:text-gray-900">Visit Sukabumi</a>
                <span>›</span>
                @if($place->category)
                    <a href="{{ url('/place?category='.$place->category->slug) }}" class="hover:underline hover:text-gray-900">{{ $place->category->name }}</a>
                    <span>›</span>
                @endif
                <span class="text-gray-900 font-medium truncate">{{ $place->name }}</span>
            </nav>
        </div>

        {{-- ══ TITLE + META ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-4">
            <div class="flex flex-col md:flex-row justify-between items-start gap-4">
                <div class="flex-1">
                    <div class="flex flex-wrap items-center gap-2.5 md:gap-3 mb-2">
                        <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 leading-tight">
                            {{ $place->name }}
                        </h1>

                        @if($place->is_claimed)
                            @if(auth()->check() && auth()->id() === $place->owner_id)
                                <a href="{{ url('/kelola') }}" class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-blue-50 text-[#1a6bbf] border border-blue-200 hover:bg-blue-100 transition shadow-2xs">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                    Kelola Tempat
                                </a>
                            @else
                                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-200 shadow-2xs">
                                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                    </svg>
                                    Terverifikasi Resmi
                                </span>
                            @endif
                        @else
                            <a href="{{ route('claim.create', $place->slug) }}" 
                               title="Klaim kepemilikan destinasi ini"
                               class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-gray-100/80 hover:bg-amber-50 text-gray-600 hover:text-amber-800 border border-gray-200/90 hover:border-amber-300 transition-all duration-200 group shadow-2xs">
                                <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-amber-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                <span>Belum Diklaim</span>
                                <span class="text-xs text-[#1a6bbf] group-hover:text-amber-700 font-bold underline decoration-dotted">· Klaim Tempat</span>
                            </a>
                        @endif
                    </div>
                    <div class="flex flex-wrap items-center gap-2 md:gap-4 text-xs md:text-sm mb-3">
                        {{-- Feature badges --}}
                        @if($place->has_ticket)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-[#1a6bbf]/10 text-[#1a6bbf]">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                Tiket Online
                            </span>
                        @endif
                        @if($place->has_accommodation)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-purple-50 text-purple-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Penginapan
                            </span>
                        @endif
                        @if($place->has_restaurant)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-orange-50 text-orange-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                Kuliner
                            </span>
                        @endif
                        @if($place->has_tour_package)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-green-50 text-green-600">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                Paket Tur
                            </span>
                        @endif
                        @if($place->has_restaurant && $place->restaurant_is_halal)
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                ✓ Halal
                            </span>
                        @endif

                    </div>
                    @if($place->address)
                        <div class="text-sm text-gray-600 flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="leading-tight">{{ $place->address }}</span>
                        </div>
                    @endif
                </div>
                {{-- Share / Save Buttons --}}
                <div class="flex gap-2 mt-2 md:mt-0">
                    <x-share-modal 
                        :title="$place->name" 
                        :text="'Yuk jelajahi ' . $place->name . ' di Sukabumi! ' . ($place->meta_description ?? Str::limit(strip_tags($place->description), 120))" 
                        :url="route('place.show', $place->slug)" 
                        :image="$place->placeImages->isNotEmpty() ? Storage::url(($place->placeImages->firstWhere('is_primary', true) ?? $place->placeImages->first())->image_path) : null"
                        :category="$place->category ? $place->category->name : 'Destinasi'"
                        button-class="flex items-center px-5 py-2 border border-gray-300 rounded-full hover:bg-gray-50 font-bold text-sm transition gap-2 text-gray-700 shadow-xs"
                    />
                    <form action="{{ route('wishlist.toggle', $place->slug) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="flex items-center px-5 py-2 border rounded-full font-bold text-sm transition gap-2 {{ auth()->check() && auth()->user()->wishlists->contains($place->id) ? 'bg-[#1a6bbf] text-white border-[#1a6bbf] hover:bg-[#145299]' : 'border-gray-300 hover:bg-gray-50' }}">
                            <svg class="w-4 h-4" fill="{{ auth()->check() && auth()->user()->wishlists->contains($place->id) ? 'currentColor' : 'none' }}" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                            {{ auth()->check() && auth()->user()->wishlists->contains($place->id) ? 'Disimpan' : 'Simpan' }}
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- ══ PHOTO GALLERY ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            @php 
                $images = $place->placeImages; 
                $mainImg = $images->firstWhere('is_primary', true) ?? $images->first(); 
                $total = $images->count();
                $otherImages = $images->where('id', '!=', optional($mainImg)->id);
            @endphp
            
            {{-- 📱 MOBILE VIEW (< md) --}}
            <div class="block md:hidden">
                @if($total == 0)
                    <div class="w-full h-64 rounded-2xl flex items-center justify-center bg-gray-50 border border-gray-100">
                        <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @elseif($total == 1)
                    <div class="relative w-full h-72 rounded-2xl overflow-hidden bg-gray-100 shadow-sm group">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover"/>
                        </a>
                        <x-image-copyright :img="$mainImg" />
                    </div>
                @else
                    {{-- Interactive Slider (Swipeable + Arrow Buttons + Dots + Counter) --}}
                    <div x-data="{
                        active: 0,
                        total: {{ $total }},
                        scroll() {
                            const el = this.$refs.slider;
                            if (el) {
                                el.scrollTo({ left: this.active * el.offsetWidth, behavior: 'smooth' });
                            }
                        },
                        next() {
                            this.active = (this.active + 1) % this.total;
                            this.scroll();
                        },
                        prev() {
                            this.active = (this.active - 1 + this.total) % this.total;
                            this.scroll();
                        },
                        onScroll() {
                            const el = this.$refs.slider;
                            if (el && el.offsetWidth > 0) {
                                const index = Math.round(el.scrollLeft / el.offsetWidth);
                                if (index >= 0 && index < this.total) {
                                    this.active = index;
                                }
                            }
                        }
                    }" class="relative w-full overflow-hidden rounded-2xl bg-gray-900 shadow-sm select-none">
                        {{-- Swipeable Track --}}
                        <div x-ref="slider"
                             @scroll.debounce.50ms="onScroll()"
                             class="flex w-full overflow-x-auto snap-x snap-mandatory scroll-smooth [&::-webkit-scrollbar]:hidden"
                             style="scrollbar-width: none; -ms-overflow-style: none;">
                            @foreach($images as $img)
                                <div class="w-full shrink-0 snap-center relative h-72 sm:h-80 bg-gray-100 overflow-hidden group">
                                    <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover"/>
                                    </a>
                                    <x-image-copyright :img="$img" />
                                </div>
                            @endforeach
                        </div>

                        {{-- Left Arrow Button --}}
                        <button @click="prev()"
                                type="button"
                                aria-label="Previous image"
                                class="absolute left-2.5 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/50 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/70 active:scale-95 transition-all shadow-md z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        {{-- Right Arrow Button --}}
                        <button @click="next()"
                                type="button"
                                aria-label="Next image"
                                class="absolute right-2.5 top-1/2 -translate-y-1/2 w-9 h-9 rounded-full bg-black/50 backdrop-blur-md text-white flex items-center justify-center hover:bg-black/70 active:scale-95 transition-all shadow-md z-10">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        {{-- Photo Counter Badge (Bottom-Right) --}}
                        <div class="absolute bottom-3 right-3 bg-black/60 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-full flex items-center gap-1.5 shadow-md pointer-events-none z-10">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span x-text="(active + 1) + ' / ' + total"></span>
                        </div>

                        {{-- Bottom Dots Indicator --}}
                        @if($total <= 8)
                            <div class="absolute bottom-3.5 left-1/2 -translate-x-1/2 flex items-center gap-1.5 z-10 pointer-events-none">
                                @for($i = 0; $i < $total; $i++)
                                    <span class="h-1.5 rounded-full transition-all duration-300"
                                          :class="active === {{ $i }} ? 'w-4 bg-white shadow-sm' : 'w-1.5 bg-white/50'"></span>
                                @endfor
                            </div>
                        @endif
                    </div>
                @endif
            </div>

            {{-- 💻 DESKTOP VIEW (>= md) --}}
            <div class="hidden md:block">
                @if($total == 0)
                    <div class="w-full h-[440px] rounded-2xl flex items-center justify-center bg-gray-50 border border-gray-100">
                        <svg class="w-20 h-20 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @elseif($total == 1)
                    <div class="relative w-full h-[440px] rounded-2xl overflow-hidden bg-gray-100 group shadow-sm">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        </a>
                        <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                    </div>
                @elseif($total == 2)
                    <div class="grid grid-cols-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <div class="relative overflow-hidden bg-gray-100 group">
                            <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            </a>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </div>
                        @foreach($otherImages->take(1) as $img)
                            <div class="relative overflow-hidden bg-gray-100 group">
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                </a>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </div>
                        @endforeach
                    </div>
                @elseif($total == 3)
                    <div class="grid grid-cols-3 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <div class="col-span-2 relative overflow-hidden bg-gray-100 group">
                            <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            </a>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </div>
                        <div class="grid grid-rows-2 gap-2">
                        @foreach($otherImages->take(2) as $img)
                            <div class="relative overflow-hidden bg-gray-100 group">
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                </a>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </div>
                        @endforeach
                        </div>
                    </div>
                @elseif($total == 4)
                    <div class="grid grid-cols-3 grid-rows-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <div class="col-span-2 row-span-2 relative overflow-hidden bg-gray-100 group">
                            <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            </a>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </div>
                        @foreach($otherImages->take(2) as $img)
                            <div class="relative overflow-hidden bg-gray-100 group">
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                </a>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </div>
                        @endforeach
                    </div>
                @else
                    {{-- 5+ Images Grid --}}
                    <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <div class="col-span-2 row-span-2 relative overflow-hidden bg-gray-100 group">
                            <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            </a>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </div>
                        @foreach($otherImages->take(3) as $img)
                            @if($loop->last && $total > 5)
                                <div class="relative overflow-hidden bg-gray-100 group">
                                    <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 brightness-50"/>
                                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                            <span class="text-white text-xl md:text-2xl font-bold">+{{ $total - 4 }} Foto</span>
                                        </div>
                                    </a>
                                    <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                                </div>
                                
                                {{-- Hidden links for remaining images so they appear in lightbox --}}
                                @foreach($otherImages->slice(3) as $hiddenImg)
                                    <a href="{{ Storage::url($hiddenImg->image_path) }}" class="glightbox hidden" data-gallery="place-gallery"></a>
                                @endforeach
                            @else
                                <div class="relative overflow-hidden bg-gray-100 group">
                                    <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full h-full cursor-pointer" data-gallery="place-gallery">
                                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                    </a>
                                    <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                                </div>
                            @endif
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ══ MAIN CONTENT + SIDEBAR ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col lg:flex-row gap-10 mb-12">

            {{-- LEFT: Content --}}
            <div class="w-full lg:w-2/3 space-y-8">

                {{-- About --}}
                <div class="border-b border-gray-100 pb-8">
                    <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-4">Tentang {{ $place->name }}</h2>
                    @if($place->description)
                        <div class="prose prose-sm md:prose-base max-w-none text-gray-700 leading-relaxed mb-4">
                            {!! nl2br(e($place->description)) !!}
                        </div>
                    @else
                        <p class="text-gray-400 italic">Belum ada deskripsi untuk destinasi ini.</p>
                    @endif

                    @if(is_array($place->facilities) && count($place->facilities) > 0)
                        <div class="mt-6">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-3">Fasilitas Utama</h3>
                            <div class="flex flex-wrap gap-2">
                                @foreach($place->facilities as $facility)
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-700 border border-gray-200">
                                        <svg class="w-3.5 h-3.5 mr-1 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        {{ $facility }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- ══ DEKAT DENGAN (DESTINASI & TITIK TERDEKAT AUTO-DETECT) ══ --}}
                    @if(isset($nearbyPlaces) && $nearbyPlaces->isNotEmpty())
                        <div class="mt-8 pt-6 border-t border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <div class="flex items-center gap-2.5">
                                    <div class="w-8 h-8 rounded-xl bg-emerald-50 text-[#00aa6c] flex items-center justify-center flex-shrink-0">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-sm md:text-base font-bold text-gray-900 leading-tight">Dekat Dengan Destinasi Menarik</h3>
                                        <p class="text-xs text-gray-500">Tempat wisata dan atraksi populer di sekitar area ini</p>
                                    </div>
                                </div>
                            </div>

                            @if($place->nearby_places)
                                <div class="mb-4 text-xs text-gray-600 bg-amber-50/70 p-3 rounded-xl border border-amber-200/60 flex items-start gap-2">
                                    <svg class="w-4 h-4 text-amber-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span><strong>Catatan Akses:</strong> {{ $place->nearby_places }}</span>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
                                @foreach($nearbyPlaces as $near)
                                    @php
                                        $dist = isset($near->distance) ? round((float) $near->distance, 1) : null;
                                        $distText = $dist !== null ? ($dist < 1 ? round($dist * 1000) . ' m' : $dist . ' km') : null;
                                        $estMinutes = $dist !== null ? max(1, round($dist * 2)) : null;
                                    @endphp
                                    <a href="{{ route('place.show', $near->slug) }}" 
                                       class="group flex items-center gap-3.5 p-3 rounded-2xl bg-white border border-gray-100 hover:border-emerald-200 hover:shadow-md transition-all duration-200">
                                        
                                        {{-- Image Thumbnail --}}
                                        <div class="w-16 h-16 rounded-xl overflow-hidden bg-gray-100 flex-shrink-0 relative">
                                            <img src="{{ $near->cover_image_url }}" 
                                                 alt="{{ $near->name }}" 
                                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                        </div>

                                        {{-- Info --}}
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-1.5 mb-1">
                                                @if($distText)
                                                    <span class="inline-flex items-center text-[10px] font-bold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-md border border-emerald-100">
                                                        <svg class="w-2.5 h-2.5 mr-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                                        </svg>
                                                        {{ $distText }}
                                                    </span>
                                                    @if($estMinutes)
                                                        <span class="text-[10px] text-gray-400 font-medium">
                                                            ~{{ $estMinutes }} mnt
                                                        </span>
                                                    @endif
                                                @elseif($near->district)
                                                    <span class="inline-flex items-center text-[10px] font-medium text-gray-600 bg-gray-100 px-2 py-0.5 rounded-md">
                                                        {{ $near->district }}
                                                    </span>
                                                @endif
                                            </div>

                                            <h4 class="text-sm font-bold text-gray-900 group-hover:text-[#00aa6c] transition-colors truncate">
                                                {{ $near->name }}
                                            </h4>

                                            <div class="flex items-center gap-2 mt-1 text-xs text-gray-500">
                                                @if($near->category)
                                                    <span class="truncate">{{ $near->category->name }}</span>
                                                @endif
                                                @if($near->reviews_avg_rating)
                                                    <span class="text-gray-300">•</span>
                                                    <span class="flex items-center gap-0.5 font-bold text-amber-500 text-[11px]">
                                                        <svg class="w-3 h-3 fill-current" viewBox="0 0 20 20">
                                                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                                        </svg>
                                                        {{ round($near->reviews_avg_rating, 1) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        {{-- Arrow --}}
                                        <div class="w-8 h-8 rounded-full bg-gray-50 group-hover:bg-emerald-50 text-gray-400 group-hover:text-[#00aa6c] flex items-center justify-center flex-shrink-0 transition-colors">
                                            <svg class="w-4 h-4 transform group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Meta chips --}}
                    <div class="flex flex-wrap gap-3 mt-5">
                        @if($place->open_hours)
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $place->open_hours }}
                            </div>
                        @endif
                        @if($place->duration)
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                Durasi: {{ $place->duration }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- ══ VIDEO DOKUMENTASI & SUASANA ══ --}}
                @if($place->youtube_id)
                    <div class="border-b border-gray-100 pb-8">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-9 h-9 rounded-xl bg-red-50 flex items-center justify-center text-red-600 shadow-xs border border-red-100">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-xl md:text-2xl font-bold text-gray-900 leading-tight">{{ $place->video_title ?: 'Video Suasana & Tur' }}</h2>
                                <p class="text-xs text-gray-500">Lihat gambaran langsung dan keseruan di {{ $place->name }}</p>
                            </div>
                        </div>
                        <div class="relative w-full aspect-video rounded-2xl overflow-hidden shadow-lg bg-gray-950 border border-gray-100">
                            <iframe 
                                class="absolute inset-0 w-full h-full"
                                src="https://www.youtube-nocookie.com/embed/{{ $place->youtube_id }}?rel=0" 
                                title="{{ $place->video_title ?: ('Video ' . $place->name) }}" 
                                frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                @endif

                {{-- ══ PERINGATAN AKSESIBILITAS ══ --}}
                @if($place->has_accessibility_warning && $place->accessibility_note)
                    @php
                        $accessIcons = [
                            'vehicle_only'        => ['icon' => '🚗', 'color' => 'bg-yellow-50 border-yellow-300 text-yellow-800'],
                            'motorcycle_only'     => ['icon' => '🏍️', 'color' => 'bg-orange-50 border-orange-300 text-orange-800'],
                            'hiking'              => ['icon' => '🥾', 'color' => 'bg-amber-50 border-amber-300 text-amber-800'],
                            'wheelchair_friendly' => ['icon' => '♿', 'color' => 'bg-blue-50 border-blue-300 text-blue-800'],
                            'boat_required'       => ['icon' => '⛵', 'color' => 'bg-cyan-50 border-cyan-300 text-cyan-800'],
                        ];
                        $accessStyle = $accessIcons[$place->accessibility_type] ?? ['icon' => '⚠️', 'color' => 'bg-gray-50 border-gray-300 text-gray-800'];
                    @endphp
                    <div class="border-b border-gray-100 pb-8">
                        <div class="flex items-start gap-3 p-4 rounded-xl border-2 {{ $accessStyle['color'] }}">
                            <span class="text-2xl flex-shrink-0">{{ $accessStyle['icon'] }}</span>
                            <div>
                                <p class="font-bold text-sm mb-1">Info Akses Menuju Lokasi</p>
                                <p class="text-sm leading-relaxed">{{ $place->accessibility_note }}</p>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ══ TIKET ONLINE ══ --}}
                @if($place->has_ticket)
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-6 h-6 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                            Tiket & Harga
                        </h2>
                        <div class="bg-gradient-to-r from-[#1a6bbf]/5 to-[#1a6bbf]/10 rounded-2xl p-6 border border-[#1a6bbf]/20">
                            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Harga Tiket Masuk</p>
                                    <p class="text-3xl font-extrabold text-gray-900">
                                        @if($place->ticket_price)
                                            Rp {{ number_format($place->ticket_price, 0, ',', '.') }}
                                        @else
                                            Gratis
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-400 mt-1">per orang</p>
                                </div>
                                @if($place->ticket_booking_url)
                                    <a href="{{ $place->ticket_booking_url }}" target="_blank"
                                        class="inline-flex items-center gap-2 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-8 py-3.5 rounded-full transition shadow-md text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                        Pesan Tiket Sekarang
                                    </a>
                                @endif
                            </div>
                            @if($place->ticket_terms)
                                <div class="mt-4 pt-4 border-t border-[#1a6bbf]/20">
                                    <p class="text-xs text-gray-500 font-semibold uppercase tracking-wider mb-1">Syarat & Ketentuan</p>
                                    <p class="text-sm text-gray-600 leading-relaxed">{{ $place->ticket_terms }}</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endif

                {{-- ══ PENGINAPAN / HOTEL ══ --}}
                @if($place->has_accommodation)
                    <div id="kamar-section" class="border-b border-gray-100 pb-8 scroll-mt-24">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-6 h-6 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Info Penginapan
                        </h2>
                        <div class="bg-purple-50 rounded-2xl p-6 border border-purple-100">
                            @if($place->hotel_star)
                                <div class="flex items-center gap-1 mb-4">
                                    @for($s = 1; $s <= 5; $s++)
                                        <svg class="w-5 h-5 {{ $s <= $place->hotel_star ? 'text-[#f9a826]' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    @endfor
                                    <span class="ml-2 text-sm font-bold text-gray-700">Hotel Bintang {{ $place->hotel_star }}</span>
                                </div>
                            @endif
                            @if(is_array($place->hotel_facilities) && count($place->hotel_facilities) > 0)
                                <div class="flex flex-wrap gap-2 mb-4">
                                    @foreach($place->hotel_facilities as $fac)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-white text-purple-700 border border-purple-200">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                            {{ $fac }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif
                        @php
                            $activeRooms = $place->rooms ? $place->rooms->where('is_active', true) : collect();
                        @endphp

                        @if($activeRooms->count() > 0)
                            <div class="mt-6 pt-6 border-t border-purple-200/60">
                                <div class="flex items-center justify-between mb-4">
                                    <div>
                                        <h3 class="text-base font-bold text-gray-900">Reservasi Kamar Langsung</h3>
                                        <p class="text-xs text-gray-500">Konfirmasi instan dengan tarif resmi pengelola</p>
                                    </div>
                                    <span class="text-xs font-bold text-purple-700 bg-purple-100 px-3 py-1 rounded-full">Resmi Mitra</span>
                                </div>

                                <div class="space-y-4">
                                    @foreach($activeRooms as $room)
                                        <div class="bg-white rounded-2xl p-5 border border-purple-100 shadow-xs flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                            <div class="space-y-1">
                                                <div class="flex items-center gap-2">
                                                    <h4 class="font-bold text-gray-900 text-base">{{ $room->name }}</h4>
                                                    <span class="text-[11px] font-semibold text-gray-500 bg-gray-100 px-2 py-0.5 rounded-md">Maks. {{ $room->max_guests }} Tamu</span>
                                                </div>
                                                <p class="text-xs text-gray-600 leading-relaxed">{{ $room->description ?: 'Kamar nyaman dan lengkap dengan fasilitas standar hotel.' }}</p>
                                                <div class="pt-1">
                                                    <span class="text-xs text-gray-500">Mulai dari</span>
                                                    <span class="text-lg font-black text-gray-900 font-mono">Rp {{ number_format($room->price_per_night, 0, ',', '.') }}</span>
                                                    <span class="text-xs text-gray-500">/ malam</span>
                                                </div>
                                            </div>

                                            @auth
                                                <button type="button" 
                                                        onclick="openHotelModal({{ $room->id }}, '{{ addslashes($room->name) }}', {{ (float) $room->price_per_night }})"
                                                        class="w-full md:w-auto px-6 py-2.5 rounded-full bg-[#163766] hover:bg-[#102747] text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                                    <svg class="w-4 h-4 text-[#f8be2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                                    Pilih Kamar
                                                </button>
                                            @else
                                                <a href="{{ route('login', ['redirect' => url()->current()]) }}"
                                                   class="w-full md:w-auto px-6 py-2.5 rounded-full bg-[#163766] hover:bg-[#102747] text-white font-bold text-xs transition flex items-center justify-center gap-2 shadow-sm whitespace-nowrap">
                                                    <svg class="w-4 h-4 text-[#f8be2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                                                    </svg>
                                                    Masuk untuk Pesan
                                                </a>
                                            @endauth
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($place->hotel_booking_url)
                            <div class="mt-4 pt-4 border-t border-purple-200/60">
                                <a href="{{ $place->hotel_booking_url }}" target="_blank"
                                    class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-full transition shadow-sm text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Cek Ketersediaan Kamar
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Hotel Room Reservation Modal --}}
                <div id="hotelBookingModal" class="fixed inset-0 z-50 bg-black/60 backdrop-blur-xs flex items-center justify-center p-4 hidden">
                    <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl relative max-h-[90vh] overflow-y-auto">
                        <button type="button" onclick="closeHotelModal()" class="absolute top-5 right-5 text-gray-400 hover:text-black">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>

                        <div class="mb-4">
                            <span class="text-xs font-bold uppercase tracking-wider text-purple-700">Reservasi Kamar</span>
                            <h3 id="modalRoomName" class="text-xl font-black text-gray-900 mt-2">Pesan Kamar</h3>
                            <p class="text-xs text-gray-500">{{ $place->name }}</p>
                        </div>

                        <form action="{{ route('booking.store') }}" method="POST" id="hotelBookingForm" class="space-y-4">
                            @csrf
                            <input type="hidden" name="booking_type" value="hotel">
                            <input type="hidden" name="item_id" id="modalRoomId" value="">

                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">Check-in</label>
                                    <input type="date" name="check_in_date" id="modalCheckIn" required class="w-full text-xs px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                </div>
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">Check-out</label>
                                    <input type="date" name="check_out_date" id="modalCheckOut" required class="w-full text-xs px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] font-bold text-gray-700 uppercase mb-1">Jumlah Kamar</label>
                                <select name="rooms_count" id="modalRoomsCount" class="w-full text-xs font-bold px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                    <option value="1">1 Kamar</option>
                                    <option value="2">2 Kamar</option>
                                    <option value="3">3 Kamar</option>
                                    <option value="4">4 Kamar</option>
                                </select>
                            </div>

                            {{-- Live Breakdown Box --}}
                            <div class="bg-gray-50 border border-gray-200 rounded-2xl p-4 space-y-2 text-xs">
                                <div class="flex justify-between text-gray-600 font-medium">
                                    <span>Subtotal (<span id="modalNightsText">1</span> malam, <span id="modalRoomsText">1</span> kamar)</span>
                                    <span id="modalSubtotal" class="font-mono text-gray-900 font-bold">Rp 0</span>
                                </div>
                                <div class="flex justify-between items-center text-slate-700 bg-slate-50 p-2.5 rounded-lg border border-slate-200">
                                    <span class="flex items-center gap-1.5 font-semibold text-xs">
                                        <svg class="w-3.5 h-3.5 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        Pajak & Biaya Layanan (10%)
                                    </span>
                                    <span id="modalTax" class="font-mono font-bold text-slate-800">Rp 0</span>
                                </div>
                                <div class="pt-2 border-t border-gray-200 flex justify-between items-center text-sm font-black text-gray-900">
                                    <span>Total Tagihan</span>
                                    <span id="modalTotal" class="font-mono text-[#00aa6c] text-base font-black">Rp 0</span>
                                </div>
                            </div>

                            {{-- Data Tamu --}}
                            <div class="space-y-3 pt-2 border-t border-gray-100">
                                <div>
                                    <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Nama Tamu</label>
                                    <input type="text" name="customer_name" required placeholder="Nama Lengkap Sesuai KTP" value="{{ auth()->user()?->name ?? '' }}" class="w-full text-xs px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                </div>
                                <div class="grid grid-cols-2 gap-3">
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">Email</label>
                                        <input type="email" name="customer_email" required placeholder="email@domain.com" value="{{ auth()->user()?->email ?? '' }}" class="w-full text-xs px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                    </div>
                                    <div>
                                        <label class="block text-[11px] font-bold text-gray-600 uppercase mb-1">No. WhatsApp</label>
                                        <input type="tel" name="customer_phone" required placeholder="08xxxxxxxxxx" value="{{ auth()->user()?->phone ?? '' }}" class="w-full text-xs px-3 py-2 border rounded-xl bg-gray-50 focus:bg-white border-gray-200">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="w-full bg-[#163766] hover:bg-[#102747] text-white font-bold py-3.5 px-6 rounded-2xl transition text-sm flex items-center justify-center gap-2 shadow-lg shadow-blue-900/20">
                                <svg class="w-4 h-4 text-[#f8be2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Konfirmasi & Bayar
                            </button>
                        </form>
                    </div>
                </div>

                <script>
                let currentRoomPrice = 0;

                function openHotelModal(id, name, price) {
                    @guest
                        window.location.href = "{{ route('login', ['redirect' => url()->current()]) }}";
                        return;
                    @endguest

                    currentRoomPrice = price;
                    document.getElementById('modalRoomId').value = id;
                    document.getElementById('modalRoomName').textContent = name;

                    const today = new Date();
                    const tomorrow = new Date();
                    tomorrow.setDate(today.getDate() + 1);

                    const formatDate = d => d.toISOString().split('T')[0];
                    const checkInInput = document.getElementById('modalCheckIn');
                    const checkOutInput = document.getElementById('modalCheckOut');

                    if (!checkInInput.value) checkInInput.value = formatDate(today);
                    if (!checkOutInput.value) checkOutInput.value = formatDate(tomorrow);

                    recalcHotelModal();
                    document.getElementById('hotelBookingModal').classList.remove('hidden');
                }

                function closeHotelModal() {
                    document.getElementById('hotelBookingModal').classList.add('hidden');
                }

                function recalcHotelModal() {
                    const checkInVal = document.getElementById('modalCheckIn').value;
                    const checkOutVal = document.getElementById('modalCheckOut').value;
                    const roomsCount = parseInt(document.getElementById('modalRoomsCount').value || 1);

                    let nights = 1;
                    if (checkInVal && checkOutVal) {
                        const d1 = new Date(checkInVal);
                        const d2 = new Date(checkOutVal);
                        const diffTime = d2 - d1;
                        nights = Math.max(1, Math.ceil(diffTime / (1000 * 60 * 60 * 24)));
                    }

                    const subtotal = currentRoomPrice * nights * roomsCount;
                    const tax = Math.round(subtotal * 0.10); // PBJT 10%
                    const total = subtotal + tax;

                    document.getElementById('modalNightsText').textContent = nights;
                    document.getElementById('modalRoomsText').textContent = roomsCount;
                    document.getElementById('modalSubtotal').textContent = 'Rp ' + subtotal.toLocaleString('id-ID');
                    document.getElementById('modalTax').textContent = 'Rp ' + tax.toLocaleString('id-ID');
                    document.getElementById('modalTotal').textContent = 'Rp ' + total.toLocaleString('id-ID');
                }

                document.getElementById('modalCheckIn')?.addEventListener('change', recalcHotelModal);
                document.getElementById('modalCheckOut')?.addEventListener('change', recalcHotelModal);
                document.getElementById('modalRoomsCount')?.addEventListener('change', recalcHotelModal);
                </script>
                @endif

                {{-- ══ RESTORAN / KULINER ══ --}}
                @if($place->has_restaurant)
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-6 h-6 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            Info Kuliner & Restoran
                        </h2>
                        <div class="bg-orange-50 rounded-2xl p-6 border border-orange-100 space-y-4">
                            @if($place->restaurant_is_halal)
                                <div class="inline-flex items-center gap-2 bg-emerald-50 border border-emerald-200 text-emerald-700 text-sm font-bold px-4 py-2 rounded-full">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                    Bersertifikat Halal
                                </div>
                            @endif
                            <div class="flex flex-wrap gap-3">
                                @if($place->restaurant_menu_url)
                                    <a href="{{ $place->restaurant_menu_url }}" target="_blank"
                                        class="inline-flex items-center gap-2 bg-orange-500 hover:bg-orange-600 text-white font-bold px-5 py-2.5 rounded-full transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        Lihat Menu
                                    </a>
                                @endif
                                @if($place->restaurant_reservation_url)
                                    <a href="{{ Str::startsWith($place->restaurant_reservation_url, 'http') ? $place->restaurant_reservation_url : 'https://wa.me/' . preg_replace('/\D/', '', $place->restaurant_reservation_url) . '?text=' . $restoWaText }}" target="_blank"
                                        class="inline-flex items-center gap-2 bg-white border border-orange-300 text-orange-600 hover:bg-orange-50 font-bold px-5 py-2.5 rounded-full transition text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        Reservasi Meja
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ══ PAKET TUR & GUIDE ══ --}}
                @if($place->has_tour_package)
                    <div class="border-b border-gray-100 pb-8">
                        <h2 class="text-xl md:text-2xl font-bold text-gray-900 mb-5 flex items-center gap-2">
                            <svg class="w-6 h-6 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Paket Tur & Pemandu Wisata
                        </h2>

                        @if($place->tour_meeting_point)
                            <div class="mb-4 flex items-start gap-3 text-sm text-gray-600 bg-green-50 p-4 rounded-xl border border-green-100">
                                <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div><span class="font-bold">Titik Kumpul:</span> {{ $place->tour_meeting_point }}</div>
                            </div>
                        @endif

                        @if(is_array($place->tour_packages) && count($place->tour_packages) > 0)
                            <div class="space-y-4">
                                @foreach($place->tour_packages as $pkg)
                                    <div class="bg-white border border-gray-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                                        <div class="flex-1">
                                            <h3 class="text-base font-bold text-gray-900">{{ $pkg['name'] ?? '' }}</h3>
                                            @if(!empty($pkg['description']))
                                                <p class="text-sm text-gray-500 mt-1">{{ $pkg['description'] }}</p>
                                            @endif
                                            @if(!empty($pkg['quota']))
                                                <p class="text-xs text-red-500 font-medium mt-1">Kuota tersisa: {{ $pkg['quota'] }} orang</p>
                                            @endif
                                        </div>
                                        <div class="flex flex-col items-start md:items-end gap-2">
                                            <p class="text-xl font-extrabold text-gray-900">Rp {{ number_format($pkg['price'] ?? 0, 0, ',', '.') }}</p>
                                            @if($place->tour_guide_contact)
                                                @php
                                                    $tourMsg = "Halo, saya tertarik dengan paket *{$pkg['name']}* di *{$place->name}*. Apakah masih tersedia?";
                                                    $tourWa = 'https://wa.me/' . preg_replace('/\D/', '', $place->tour_guide_contact) . '?text=' . urlencode($tourMsg);
                                                @endphp
                                                <a href="{{ $tourWa }}" target="_blank"
                                                    class="inline-flex items-center gap-2 bg-green-500 hover:bg-green-600 text-white font-bold px-5 py-2 rounded-full transition text-sm">
                                                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                    Pesan via WA
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
            </div>
                @endif

                {{-- ══ ULASAN PENGUNJUNG ══ --}}
                @include('components.detail-review-section', ['model' => $place, 'type' => 'place'])

            </div>

            {{-- RIGHT: Sticky Sidebar --}}
            <div class="hidden lg:block w-full lg:w-1/3">
                <div class="sticky top-24 space-y-5">

                    @php
                        $activeRooms = $place->rooms ? $place->rooms->where('is_active', true) : collect();
                        $isHotel = $place->has_accommodation || ($place->category && in_array($place->category->slug, ['hotel-resort', 'penginapan', 'hotel-dan-resort'])) || $activeRooms->isNotEmpty();
                        $isResto = !$isHotel && ($place->has_restaurant || ($place->category && in_array($place->category->slug, ['kuliner', 'restoran', 'cafe'])));

                        // Pricing & Contextual Labels
                        if ($isHotel) {
                            $priceKicker = 'Tarif Menginap';
                            if ($activeRooms->isNotEmpty()) {
                                $minRoomPrice = $activeRooms->min('price_per_night');
                                $displayPrice = 'Rp ' . number_format($minRoomPrice, 0, ',', '.');
                                $priceUnit = '/ malam';
                                $priceNote = 'Tarif terendah kamar tersedia';
                            } elseif ($place->has_general_price && $place->formatted_price) {
                                $displayPrice = $place->formatted_price;
                                $priceUnit = '/ malam';
                                $priceNote = 'Estimasi tarif menginap';
                            } else {
                                $displayPrice = 'Hubungi Pengelola';
                                $priceUnit = '';
                                $priceNote = 'Sesuai ketersediaan unit';
                            }
                        } elseif ($isResto) {
                            $priceKicker = 'Estimasi Kuliner';
                            $displayPrice = $place->formatted_price ?: 'Bervariasi';
                            $priceUnit = '/ porsi';
                            $priceNote = 'Kisaran harga menu pilihan';
                        } else {
                            $priceKicker = 'Harga Tiket Masuk';
                            if ($place->has_ticket && $place->ticket_price !== null) {
                                $displayPrice = $place->ticket_price > 0 ? 'Rp ' . number_format($place->ticket_price, 0, ',', '.') : 'Gratis';
                            } elseif ($place->has_general_price && $place->formatted_price) {
                                $displayPrice = $place->formatted_price;
                            } else {
                                $displayPrice = 'Gratis';
                            }
                            $priceUnit = $displayPrice === 'Gratis' ? '' : '/ orang';
                            $priceNote = 'Akses kunjungan destinasi';
                        }

                        $hasAnyPricingOrBooking = $place->has_ticket || $place->has_general_price || $isHotel || $isResto;
                    @endphp

                    {{-- ── 1. KARTU TARIF & PEMESANAN (ANTI-SLOP) ── --}}
                    @if($hasAnyPricingOrBooking)
                    <div class="bg-white border border-slate-200/90 rounded-2xl p-6 shadow-sm">
                        {{-- Header / Eyebrow: Pure tracking typography, NO gimmicky pills --}}
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-[11px] font-bold uppercase tracking-wider text-slate-500">
                                {{ $priceKicker }}
                            </span>
                            <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Tersedia
                            </span>
                        </div>

                        {{-- Price Display --}}
                        <div class="flex items-baseline gap-1.5 flex-wrap">
                            <span class="text-2xl md:text-3xl font-extrabold text-slate-900 tracking-tight">
                                {{ $displayPrice }}
                            </span>
                            @if($priceUnit)
                                <span class="text-sm font-semibold text-slate-500">
                                    {{ $priceUnit }}
                                </span>
                            @endif
                        </div>
                        <p class="text-xs text-slate-400 mt-1">
                            {{ $priceNote }}
                        </p>

                        {{-- CTA Primary Actions based on Entity Type --}}
                        <div class="mt-5 space-y-2.5">
                            @if($isHotel && $activeRooms->isNotEmpty())
                                {{-- Hotel with direct rooms: Scroll to room selection --}}
                                <a href="#kamar-section"
                                   class="w-full flex items-center justify-center gap-2 bg-[#163766] hover:bg-[#0f274a] text-white font-bold py-3.5 px-4 rounded-xl transition duration-150 shadow-sm text-sm">
                                    <svg class="w-4 h-4 text-[#f8be2c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                                    </svg>
                                    Lihat & Pesan Kamar
                                    <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                    </svg>
                                </a>
                            @elseif($isHotel && $place->hotel_booking_url)
                                <a href="{{ $place->hotel_booking_url }}" target="_blank"
                                   class="w-full flex items-center justify-center gap-2 bg-[#163766] hover:bg-[#0f274a] text-white font-bold py-3.5 px-4 rounded-xl transition shadow-sm text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Booking Kamar Resmi
                                </a>
                            @elseif($place->has_ticket && $place->ticket_booking_url)
                                <a href="{{ $place->ticket_booking_url }}" target="_blank"
                                   class="w-full flex items-center justify-center gap-2 bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold py-3.5 px-4 rounded-xl transition shadow-sm text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                    </svg>
                                    Pesan Tiket Sekarang
                                </a>
                            @elseif($isResto && $place->restaurant_reservation_url)
                                <a href="{{ Str::startsWith($place->restaurant_reservation_url, 'http') ? $place->restaurant_reservation_url : 'https://wa.me/' . preg_replace('/\D/', '', $place->restaurant_reservation_url) . '?text=' . $restoWaText }}" target="_blank"
                                   class="w-full flex items-center justify-center gap-2 bg-[#ea580c] hover:bg-[#c2410c] text-white font-bold py-3.5 px-4 rounded-xl transition shadow-sm text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                    </svg>
                                    Reservasi Meja
                                </a>
                            @elseif($isHotel)
                                {{-- Hotel without online booking links: Informational note --}}
                                <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-600">
                                    <div class="font-bold text-slate-800 flex items-center gap-1.5 mb-1">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        Reservasi di Meja Resepsionis
                                    </div>
                                    <p class="text-slate-500 leading-relaxed">
                                        Pemesanan kamar dilayani langsung di lokasi atau dapat menghubungi kontak resmi hotel di bawah.
                                    </p>
                                </div>
                            @else
                                {{-- Attraction on-site ticket: Informative OTS note --}}
                                <div class="p-3.5 bg-slate-50 border border-slate-200/80 rounded-xl text-xs text-slate-600">
                                    <div class="font-bold text-slate-800 flex items-center gap-1.5 mb-1">
                                        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/>
                                        </svg>
                                        Tiket Tersedia di Loket (OTS)
                                    </div>
                                    <p class="text-slate-500 leading-relaxed">
                                        Pembelian tiket fisik langsung dilayani di pintu masuk saat berkunjung.
                                    </p>
                                </div>
                            @endif
                        </div>

                        {{-- Subtle Highlights & Guarantees --}}
                        <div class="mt-4 pt-4 border-t border-slate-100 space-y-2 text-xs text-slate-500">
                            @if($isHotel)
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Harga transparan tanpa biaya tersembunyi</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Layanan konfirmasi reservasi resmi</span>
                                </div>
                            @else
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Akses destinasi dan fasilitas umum</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <svg class="w-3.5 h-3.5 text-emerald-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    <span>Informasi terverifikasi pengelola</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- ── 2. KARTU PETA & LOKASI (CLEAN & EDITORIAL) ── --}}
                    @if($place->latitude && $place->longitude)
                        <div class="bg-white border border-slate-200/90 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-center justify-between mb-3">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-500 flex items-center gap-1.5">
                                    <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    Lokasi & Navigasi
                                </h4>
                            </div>

                            <div class="h-44 rounded-xl overflow-hidden border border-slate-200/80">
                                <iframe
                                    width="100%" height="100%"
                                    src="https://maps.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}&hl=id&z=15&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    class="w-full h-full filter saturate-[0.95]">
                                </iframe>
                            </div>

                            @if($place->address)
                                <div class="mt-3.5 space-y-2">
                                    <p class="text-xs text-slate-600 leading-relaxed flex items-start gap-2">
                                        <svg class="w-4 h-4 text-slate-400 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                        </svg>
                                        <span>{{ $place->address }}</span>
                                    </p>
                                    
                                    <a href="https://www.google.com/maps/dir/?api=1&destination={{ $place->latitude }},{{ $place->longitude }}" target="_blank"
                                       class="inline-flex items-center gap-1.5 text-xs font-bold text-[#1a6bbf] hover:text-[#0f4c81] transition">
                                        <span>Buka Petunjuk Arah di Maps</span>
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                        </svg>
                                    </a>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- ── 3. SALURAN KONTAK & WEBSITE RESMI ── --}}
                    <div class="space-y-2.5">
                        @if($place->phone)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}?text={{ $waText }}" target="_blank"
                               class="w-full flex items-center justify-center gap-2 py-3 px-4 bg-[#128c7e] hover:bg-[#075e54] text-white font-bold rounded-xl transition shadow-xs text-sm">
                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                    <path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/>
                                </svg>
                                <span>Hubungi via WhatsApp</span>
                            </a>
                        @endif

                        @if($place->website)
                            <a href="{{ $place->website }}" target="_blank"
                               class="w-full flex items-center justify-between py-2.5 px-4 bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold rounded-xl transition text-xs shadow-2xs">
                                <div class="flex items-center gap-2">
                                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                    </svg>
                                    <span>Kunjungi Website Resmi</span>
                                </div>
                                <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                </svg>
                            </a>
                        @endif
                    </div>

                    {{-- Banner Iklan Sidebar (Khusus Format Portrait) --}}
                    @php
                        $ad = \App\Models\Advertisement::getRandomAd('place_sidebar', 'place_detail', 'portrait');
                    @endphp
                    
                    @if($ad)
                    <div class="mt-6 rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-md transition bg-slate-50">
                        <a href="{{ $ad->url ?? '#' }}" target="{{ ($ad->open_in_new_tab || (isset($ad->url) && str_starts_with($ad->url, 'http'))) ? '_blank' : '_self' }}" class="block w-full h-full">
                            <img src="{{ $ad->image_url }}" alt="{{ $ad->title }}" class="w-full h-auto object-contain mx-auto">
                        </a>
                    </div>
                    @endif

                </div>
            </div>
        </div>

        {{-- ══ RELATED PLACES ══ --}}
        @if($related->isNotEmpty())
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-12">
                <hr class="border-gray-100 mb-10">
                <h3 class="text-xl md:text-2xl font-bold text-gray-900 mb-5">
                    Destinasi serupa di {{ optional($place->category)->name ?? 'Sukabumi' }}
                </h3>
                <div class="flex gap-4 overflow-x-auto pb-4 -mx-4 px-4 md:mx-0 md:px-0 md:grid md:grid-cols-4 md:gap-5 scrollbar-hide">
                    @foreach($related as $rel)
                        <div class="min-w-[280px] md:min-w-0 shrink-0">
                            <x-place-card :place="$rel" />
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Mobile sticky CTA --}}
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-4 z-50 lg:hidden flex justify-between items-center shadow-[0_-4px_12px_rgba(0,0,0,0.06)]">
            <div>
                <p class="text-[11px] font-bold text-gray-500 uppercase tracking-wider">{{ $priceKicker ?? 'Harga' }}</p>
                <p class="text-base sm:text-lg font-extrabold text-gray-900 leading-tight">
                    {{ $displayPrice ?? 'Gratis' }}
                    @if(!empty($priceUnit))
                        <span class="text-xs font-semibold text-gray-500">{{ $priceUnit }}</span>
                    @endif
                </p>
            </div>
            @if(isset($isHotel) && $isHotel && $activeRooms->isNotEmpty())
                <a href="#kamar-section"
                    class="bg-[#163766] hover:bg-[#0f274a] text-white font-bold px-6 py-3 rounded-xl transition shadow-md text-sm">
                    Pilih Kamar
                </a>
            @elseif($place->has_ticket && $place->ticket_booking_url)
                <a href="{{ $place->ticket_booking_url }}" target="_blank"
                    class="bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-6 py-3 rounded-xl transition shadow-md text-sm">
                    Pesan Tiket
                </a>
            @elseif($place->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}?text={{ $waText }}" target="_blank"
                    class="bg-[#128c7e] hover:bg-[#075e54] text-white font-bold px-6 py-3 rounded-xl transition shadow-md text-sm flex items-center gap-1.5">
                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                    Chat WA
                </a>
            @else
                <button class="bg-[#163766] hover:bg-[#0f274a] text-white font-bold px-6 py-3 rounded-xl transition shadow-md text-sm">
                    Cek Ketersediaan
                </button>
            @endif
        </div>

    {{-- ══ BANNER KLAIM DESTINASI ══ --}}
    @if(!$place->is_claimed)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="bg-gradient-to-r from-[#0f4c81] to-[#1a6bbf] rounded-2xl p-6 md:p-8 flex flex-col md:flex-row items-center gap-6 text-white">
            <div class="w-14 h-14 rounded-2xl bg-white/10 flex items-center justify-center flex-shrink-0">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                </svg>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h3 class="font-extrabold text-lg">Apakah Anda pengelola destinasi ini?</h3>
                <p class="text-blue-200 text-sm mt-1">
                    Klaim kepemilikan {{ $place->name }} untuk memperbarui informasi, jam operasional, dan merespons ulasan pengunjung secara resmi.
                </p>
            </div>
            @auth
            <a href="{{ route('claim.create', $place->slug) }}"
               class="flex-shrink-0 px-6 py-3 bg-white text-[#1a6bbf] font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">
                Klaim Destinasi Ini
            </a>
            @else
            <a href="{{ route('login') }}?redirect={{ urlencode(route('claim.create', $place->slug)) }}"
               class="flex-shrink-0 px-6 py-3 bg-white text-[#1a6bbf] font-bold rounded-xl hover:shadow-lg hover:-translate-y-0.5 transition-all text-sm">
                Login untuk Klaim
            </a>
            @endauth
        </div>
    </div>
    @elseif($place->is_claimed && $place->owner)
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pb-6">
        <div class="bg-green-50 border border-green-200 rounded-2xl px-5 py-3 flex items-center gap-3">
            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-green-800">
                <span class="font-bold">Destinasi Terverifikasi</span> — Dikelola secara resmi oleh <strong>{{ $place->owner->name }}</strong>.
            </p>
        </div>
    </div>
    @endif

    </main>

    @include('components.footer')
</div>

@push('scripts')
<script>
    function setRating(rating) {
        document.getElementById('rating-input').value = rating;
        const stars = document.querySelectorAll('.star-btn svg');
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-300');
                star.classList.add('text-yellow-400');
            } else {
                star.classList.remove('text-yellow-400');
                star.classList.add('text-gray-300');
            }
        });
    }
    // Initialize rating
    if (document.getElementById('rating-input')) {
        setRating(5);
    }
</script>
@endpush

@endsection
