@extends('layouts.app')

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
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
            <nav class="hidden md:flex text-sm text-gray-500 gap-2 items-center">
                <a href="{{ url('/') }}" class="hover:underline hover:text-gray-900">Beranda</a>
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
                    <h1 class="text-2xl md:text-4xl font-extrabold text-gray-900 mb-2 leading-tight">
                        {{ $place->name }}
                    </h1>
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
                        @if($place->category)
                            <span class="text-gray-400">|</span>
                            <span class="text-gray-600">{{ $place->category->name }}</span>
                        @endif
                    </div>
                    @if($place->address)
                        <div class="text-sm text-gray-600 flex items-start gap-2">
                            <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            <span class="leading-tight">{{ $place->address }}{{ $place->district ? ', Kec. ' . $place->district : '' }}</span>
                        </div>
                    @endif
                </div>
                {{-- Share / Save Buttons --}}
                <div class="flex gap-2 mt-2 md:mt-0">
                    <button class="flex items-center px-5 py-2 border border-gray-300 rounded-full hover:bg-gray-50 font-bold text-sm transition gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Bagikan
                    </button>
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
            
            {{-- 📱 MOBILE VIEW (< md) --}}
            <div class="block md:hidden">
                @if($total == 0)
                    <div class="w-full h-64 rounded-2xl flex items-center justify-center bg-gray-50 border border-gray-100">
                        <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @elseif($total == 1)
                    <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-72 rounded-2xl overflow-hidden relative bg-gray-100 shadow-sm" data-gallery="place-gallery">
                        <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover"/>
                        <x-image-copyright :img="$mainImg" />
                    </a>
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
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox block w-full shrink-0 snap-center relative h-72 sm:h-80 bg-gray-100 overflow-hidden" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover"/>
                                    <x-image-copyright :img="$img" />
                                </a>
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
                    <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox block w-full h-[440px] rounded-2xl overflow-hidden relative bg-gray-100 group cursor-pointer shadow-sm" data-gallery="place-gallery">
                        <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                        <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                    </a>
                @elseif($total == 2)
                    <div class="grid grid-cols-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </a>
                        @foreach($otherImages->take(1) as $img)
                            <a href="{{ Storage::url($img->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </a>
                        @endforeach
                    </div>
                @elseif($total == 3)
                    <div class="grid grid-cols-3 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox col-span-2 relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </a>
                        <div class="grid grid-rows-2 gap-2">
                        @foreach($otherImages->take(2) as $img)
                            <a href="{{ Storage::url($img->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </a>
                        @endforeach
                        </div>
                    </div>
                @elseif($total == 4)
                    <div class="grid grid-cols-3 grid-rows-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox col-span-2 row-span-2 relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </a>
                        @foreach($otherImages->take(2) as $img)
                            <a href="{{ Storage::url($img->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                                <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                            </a>
                        @endforeach
                    </div>
                @else
                    {{-- 5+ Images Grid --}}
                    <div class="grid grid-cols-4 grid-rows-2 gap-2 h-[440px] rounded-2xl overflow-hidden shadow-sm">
                        <a href="{{ Storage::url($mainImg->image_path) }}" class="glightbox col-span-2 row-span-2 relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                            <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                            <x-image-copyright :img="$mainImg" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                        </a>
                        @foreach($otherImages->take(3) as $img)
                            @if($loop->last && $total > 5)
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105 brightness-50"/>
                                    <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                                        <span class="text-white text-xl md:text-2xl font-bold">+{{ $total - 4 }} Foto</span>
                                    </div>
                                    <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                                </a>
                                
                                {{-- Hidden links for remaining images so they appear in lightbox --}}
                                @foreach($otherImages->slice(3) as $hiddenImg)
                                    <a href="{{ Storage::url($hiddenImg->image_path) }}" class="glightbox hidden" data-gallery="place-gallery"></a>
                                @endforeach
                            @else
                                <a href="{{ Storage::url($img->image_path) }}" class="glightbox relative overflow-hidden bg-gray-100 group cursor-pointer" data-gallery="place-gallery">
                                    <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                    <x-image-copyright :img="$img" className="bottom-3 left-3 text-[11px] px-2.5 py-1.5" />
                                </a>
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

                    @if($place->nearby_places)
                        <div class="mt-6">
                            <h3 class="text-sm font-bold text-gray-900 uppercase tracking-wider mb-2">Dekat Dengan</h3>
                            <div class="text-sm text-gray-700 bg-[#f9a826]/10 p-4 rounded-xl border border-[#f9a826]/20 leading-relaxed flex gap-3 items-start">
                                <svg class="w-5 h-5 text-[#f9a826] flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <div>{{ $place->nearby_places }}</div>
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
                    <div class="border-b border-gray-100 pb-8">
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
                            @if($place->hotel_booking_url)
                                <a href="{{ $place->hotel_booking_url }}" target="_blank"
                                    class="inline-flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white font-bold px-6 py-3 rounded-full transition shadow-sm text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    Cek Ketersediaan Kamar
                                </a>
                            @endif
                        </div>
                    </div>
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

                    {{-- Pricing / CTA Card --}}
                    @php
                        $hasPriceOrTicket = $place->has_ticket || $place->has_general_price;
                        $hasContactCTA = ($place->has_ticket && $place->ticket_booking_url) ||
                                         ($place->has_accommodation && $place->hotel_booking_url) ||
                                         ($place->has_restaurant && $place->restaurant_reservation_url) ||
                                         $place->phone;
                        $shouldShowCard = $hasPriceOrTicket || $hasContactCTA;
                    @endphp

                    @if($shouldShowCard)
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6">
                        @if($hasPriceOrTicket)
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <div class="text-2xl font-extrabold text-gray-900">
                                    @if($place->has_ticket && $place->ticket_price !== null)
                                        Rp {{ number_format($place->ticket_price, 0, ',', '.') }}
                                    @elseif($place->has_general_price && $place->price !== null)
                                        Rp {{ number_format($place->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">per orang</div>
                            </div>
                            <span class="text-xs bg-green-50 text-green-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                        </div>
                        @endif

                        {{-- Dynamic CTA buttons based on active toggles --}}
                        @if($place->has_ticket && $place->ticket_booking_url)
                            <a href="{{ $place->ticket_booking_url }}" target="_blank"
                                class="block w-full text-center bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold py-3 rounded-full transition shadow-sm mb-2">
                                Pesan Tiket Sekarang
                            </a>
                        @elseif($place->has_accommodation && $place->hotel_booking_url)
                            <a href="{{ $place->hotel_booking_url }}" target="_blank"
                                class="block w-full text-center bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 rounded-full transition shadow-sm mb-2">
                                Booking Kamar
                            </a>
                        @elseif($place->has_restaurant && $place->restaurant_reservation_url)
                            <a href="{{ Str::startsWith($place->restaurant_reservation_url, 'http') ? $place->restaurant_reservation_url : 'https://wa.me/' . preg_replace('/\D/', '', $place->restaurant_reservation_url) . '?text=' . $restoWaText }}" target="_blank"
                                class="block w-full text-center bg-orange-500 hover:bg-orange-600 text-white font-bold py-3 rounded-full transition shadow-sm mb-2">
                                Reservasi Meja
                            </a>
                        @elseif($place->phone)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}?text={{ $waText }}" target="_blank"
                                class="block w-full text-center bg-[#f9a826] hover:bg-[#e8971e] text-gray-900 font-bold py-3 rounded-full transition shadow-sm mb-2">
                                Hubungi via WhatsApp
                            </a>
                        @endif
                        
                        @if($hasPriceOrTicket && !$hasContactCTA)
                            <button class="w-full bg-[#f9a826] hover:bg-[#e8971e] text-gray-900 font-bold py-3 rounded-full transition shadow-sm mb-2 cursor-not-allowed opacity-80" disabled>
                                Tiket Tersedia di Lokasi
                            </button>
                        @endif
                        
                        @if($hasPriceOrTicket)
                        <p class="text-center text-xs text-gray-400">Silakan cek info lebih lanjut saat berkunjung</p>
                        @endif
                    </div>
                    @endif

                    {{-- Map --}}
                    @if($place->latitude && $place->longitude)
                        <div class="border border-gray-200 rounded-2xl overflow-hidden">
                            <div class="h-48">
                                <iframe
                                    width="100%" height="100%"
                                    src="https://maps.google.com/maps?q={{ $place->latitude }},{{ $place->longitude }}&hl=id&z=15&output=embed"
                                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0"
                                    class="w-full h-full">
                                </iframe>
                            </div>
                            @if($place->address)
                                <div class="p-4">
                                    <p class="text-sm text-gray-600">{{ $place->address }}</p>
                                </div>
                            @endif
                        </div>
                    @endif

                    {{-- Contact Buttons --}}
                    <div class="space-y-3">
                        @if($place->phone)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}?text={{ $waText }}" target="_blank"
                                class="flex items-center justify-center w-full py-3 px-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-xl transition shadow-sm gap-2">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                Chat WhatsApp
                            </a>
                        @endif
                        @if($place->website)
                            <div class="text-center">
                                <a href="{{ $place->website }}" target="_blank" class="text-sm text-[#1a6bbf] hover:underline font-medium">
                                    Kunjungi Website Resmi →
                                </a>
                            </div>
                        @endif
                    </div>

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
                <p class="text-xs text-gray-400">Harga per orang</p>
                <p class="text-lg font-extrabold text-gray-900">
                    @if($place->has_ticket && $place->ticket_price)
                        Rp {{ number_format($place->ticket_price, 0, ',', '.') }}
                    @elseif($place->price)
                        Rp {{ number_format($place->price, 0, ',', '.') }}
                    @else
                        Gratis
                    @endif
                </p>
            </div>
            @if($place->has_ticket && $place->ticket_booking_url)
                <a href="{{ $place->ticket_booking_url }}" target="_blank"
                    class="bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-6 py-3 rounded-full transition shadow-md">
                    Pesan Tiket
                </a>
            @elseif($place->phone)
                <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}?text={{ $waText }}" target="_blank"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-3 rounded-full transition shadow-md">
                    Chat WA
                </a>
            @else
                <button class="bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-6 py-3 rounded-full transition shadow-md">
                    Cek Ketersediaan
                </button>
            @endif
        </div>

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
