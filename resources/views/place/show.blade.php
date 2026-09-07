@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-white font-sans text-gray-900">
    @include('components.navbar')

    <main class="pt-20">

        {{-- ══ BREADCRUMB ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-6 pb-2">
            <nav class="hidden md:flex text-sm text-gray-500 gap-2 items-center">
                <a href="{{ url('/') }}" class="hover:underline hover:text-gray-900">Home</a>
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
                        {{-- Rating --}}
                        @php $avg = $place->avgRating(); $full = floor($avg); @endphp
                        <div class="flex items-center gap-1">
                            @for($i = 1; $i <= 5; $i++)
                                <svg class="w-4 h-4 {{ $i <= $full ? 'text-green-500' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9"/></svg>
                            @endfor
                            <span class="ml-2 font-bold underline text-gray-900">{{ $place->reviews->count() }} ulasan</span>
                        </div>
                        <span class="text-gray-300">|</span>
                        @if($place->category)
                            <span class="text-gray-600">{{ $place->category->name }}</span>
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
                    <button class="flex items-center px-5 py-2 border border-gray-300 rounded-full hover:bg-gray-50 font-bold text-sm transition gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/></svg>
                        Share
                    </button>
                    <button class="flex items-center px-5 py-2 border border-gray-300 rounded-full hover:bg-gray-50 font-bold text-sm transition gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                        Simpan
                    </button>
                </div>
            </div>
        </div>

        {{-- ══ PHOTO GALLERY ══ --}}
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-8">
            @php $images = $place->placeImages; $mainImg = $images->firstWhere('is_primary', true) ?? $images->first(); @endphp
            <div class="grid grid-cols-1 md:grid-cols-4 md:grid-rows-2 gap-2 h-64 md:h-[440px] rounded-2xl overflow-hidden">
                {{-- Main large image --}}
                <div class="col-span-1 md:col-span-2 md:row-span-2 relative overflow-hidden bg-gray-100 group cursor-pointer">
                    @if($mainImg)
                        <img src="{{ Storage::url($mainImg->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-[#1a6bbf]/20 to-[#1a6bbf]/5">
                            <svg class="w-20 h-20 text-[#1a6bbf]/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        </div>
                    @endif
                </div>
                {{-- Thumbnail grid (4 small) --}}
                @foreach($images->where('id', '!=', optional($mainImg)->id)->take(4) as $img)
                    <div class="hidden md:block relative overflow-hidden bg-gray-100 group cursor-pointer">
                        <img src="{{ Storage::url($img->image_path) }}" alt="{{ $place->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                    </div>
                @endforeach
                {{-- Placeholder slots if < 4 thumbnails --}}
                @for($i = $images->where('id', '!=', optional($mainImg)->id)->count(); $i < 4; $i++)
                    <div class="hidden md:flex items-center justify-center bg-gray-50 border border-dashed border-gray-200">
                        <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                @endfor
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
                        @if($place->ticket_info)
                            <div class="flex items-center gap-2 bg-gray-50 px-4 py-2 rounded-lg text-sm text-gray-700">
                                <svg class="w-4 h-4 text-[#1a6bbf]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"/></svg>
                                {{ $place->ticket_info }}
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Reviews --}}
                <div id="reviews" class="pb-8">
                    <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-6 gap-4">
                        <h2 class="text-xl font-bold text-gray-900">Ulasan ({{ $place->reviews->count() }})</h2>
                        <button class="px-5 py-2 border-2 border-[#1a6bbf] text-[#1a6bbf] rounded-full font-bold text-sm hover:bg-[#1a6bbf] hover:text-white transition">
                            Tulis ulasan
                        </button>
                    </div>

                    @if($place->reviews->isEmpty())
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-12 h-12 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/></svg>
                            <p class="text-sm">Belum ada ulasan. Jadilah yang pertama!</p>
                        </div>
                    @else
                        <div class="space-y-6">
                            @foreach($place->reviews as $review)
                                <div class="flex gap-4 border-b border-gray-100 pb-6 last:border-0">
                                    <div class="flex-shrink-0">
                                        <div class="w-10 h-10 bg-[#1a6bbf]/10 rounded-full flex items-center justify-center text-[#1a6bbf] font-bold text-xs">
                                            {{ strtoupper(substr(optional($review->user)->name ?? 'U', 0, 2)) }}
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <div class="flex items-center gap-2 mb-1">
                                            @for($i=1;$i<=5;$i++)
                                                <svg class="w-3 h-3 {{ $i <= $review->rating ? 'text-green-500' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9"/></svg>
                                            @endfor
                                            <span class="text-xs text-gray-400">{{ $review->created_at->diffForHumans() }}</span>
                                        </div>
                                        <p class="text-sm font-bold text-gray-900 mb-1">{{ optional($review->user)->name ?? 'Pengunjung' }}</p>
                                        @if($review->content)
                                            <p class="text-gray-700 text-sm leading-relaxed">{{ $review->content }}</p>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>

            {{-- RIGHT: Sticky Sidebar --}}
            <div class="hidden lg:block w-full lg:w-1/3">
                <div class="sticky top-24 space-y-5">

                    {{-- Pricing Card --}}
                    <div class="bg-white border border-gray-200 rounded-2xl shadow-lg p-6">
                        <div class="flex justify-between items-center mb-5">
                            <div>
                                <div class="text-2xl font-extrabold text-gray-900">
                                    @if($place->price)
                                        Rp {{ number_format($place->price, 0, ',', '.') }}
                                    @else
                                        Gratis
                                    @endif
                                </div>
                                <div class="text-xs text-gray-400 mt-0.5">per orang</div>
                            </div>
                            @if($place->price)
                                <span class="text-xs bg-green-50 text-green-700 font-bold px-3 py-1 rounded-full">Tersedia</span>
                            @endif
                        </div>
                        <button class="w-full bg-[#f9a826] hover:bg-[#e8971e] text-gray-900 font-bold py-3 rounded-full transition shadow-sm mb-2">
                            Cek Ketersediaan
                        </button>
                        <p class="text-center text-xs text-gray-400">Pembatalan gratis</p>
                    </div>

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
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', $place->phone) }}" target="_blank"
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
                        <a href="{{ route('place.show', $rel->slug) }}"
                            class="block min-w-[240px] md:min-w-0 bg-white border border-gray-200 rounded-xl overflow-hidden hover:shadow-lg transition group cursor-pointer">
                            <div class="h-36 md:h-44 bg-gray-100 relative overflow-hidden">
                                @if($rel->primaryImage)
                                    <img src="{{ Storage::url($rel->primaryImage->image_path) }}" alt="{{ $rel->name }}" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"/>
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gray-50">
                                        <svg class="w-10 h-10 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    </div>
                                @endif
                                <div class="absolute top-2 right-2 bg-white rounded-full p-1.5 shadow">
                                    <svg class="w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                                </div>
                            </div>
                            <div class="p-3">
                                <h4 class="font-bold text-gray-900 text-sm mb-1 line-clamp-1 group-hover:text-[#1a6bbf] transition">{{ $rel->name }}</h4>
                                <div class="flex items-center text-xs mb-2 gap-1">
                                    @php $rRating = $rel->avgRating(); @endphp
                                    @for($i=1;$i<=5;$i++)
                                        <svg class="w-3 h-3 {{ $i <= $rRating ? 'text-green-500' : 'text-gray-200' }} fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="9"/></svg>
                                    @endfor
                                    <span class="text-gray-400 ml-1">({{ $rel->reviews()->count() }})</span>
                                </div>
                                <div class="flex justify-between items-center">
                                    <p class="font-bold text-gray-900 text-xs">
                                        @if($rel->price) Rp {{ number_format($rel->price,0,',','.') }} @else Gratis @endif
                                    </p>
                                    @if($rel->category)
                                        <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded text-gray-600 truncate max-w-[90px]">{{ $rel->category->name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Mobile sticky CTA --}}
        <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-200 p-4 z-50 lg:hidden flex justify-between items-center shadow-[0_-4px_12px_rgba(0,0,0,0.06)]">
            <div>
                <p class="text-xs text-gray-400">Harga per orang</p>
                <p class="text-lg font-extrabold text-gray-900">
                    @if($place->price) Rp {{ number_format($place->price,0,',','.') }} @else Gratis @endif
                </p>
            </div>
            <button class="bg-[#1a6bbf] hover:bg-[#145299] text-white font-bold px-6 py-3 rounded-full transition shadow-md">
                Cek Ketersediaan
            </button>
        </div>

    </main>

    @include('components.footer')
</div>
@endsection
