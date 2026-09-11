@props(['place'])

@php
    $image = $place->cover_image_url;
    $rating = $place->reviews_avg_rating ?? 0;
    $fullBubbles = floor($rating);
    $halfBubble = ($rating - $fullBubbles) >= 0.5;
@endphp

<div class="group flex flex-col bg-white rounded-2xl overflow-hidden hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] transition-shadow duration-300 border border-gray-100">
    {{-- Image --}}
    <div class="relative w-full aspect-[4/3] flex-shrink-0 cursor-pointer overflow-hidden bg-gray-100">
        <a href="{{ route('place.show', $place->slug) }}" class="block w-full h-full">
            <img alt="{{ $place->name }}" src="{{ $image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
        </a>
        
        {{-- Popular Badge --}}
        @if($rating >= 4.5 && ($place->reviews_count ?? 0) >= 10)
            <div class="absolute top-3 left-3 bg-[#f9a826] text-gray-900 text-[10px] uppercase tracking-wider font-extrabold px-2.5 py-1 rounded-full shadow-sm z-10">
                Pilihan Populer
            </div>
        @endif

        <!-- Wishlist Icon -->
        <div class="absolute top-3 right-3 z-20">
            @auth
                @php
                    $isWishlisted = auth()->user()->wishlists()->where('place_id', $place->id)->exists();
                @endphp
                <form action="{{ route('wishlist.toggle', $place->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white/90 backdrop-blur-sm w-8 h-8 rounded-full flex items-center justify-center shadow-sm hover:bg-white transition-colors" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Simpan ke Wishlist' }}">
                        <svg class="w-4 h-4 {{ $isWishlisted ? 'text-red-500 fill-red-500' : 'text-gray-900' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white/90 backdrop-blur-sm w-8 h-8 rounded-full flex items-center justify-center shadow-sm hover:bg-white transition-colors" title="Login untuk menyimpan ke Wishlist">
                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </a>
            @endauth
        </div>
    </div>

    {{-- Content --}}
    <div class="p-4 flex flex-col flex-grow justify-between">
        <div>
            <h3 class="font-bold text-gray-900 text-lg mb-1 leading-snug group-hover:underline">
                <a href="{{ route('place.show', $place->slug) }}">{{ $place->name }}</a>
            </h3>
            
            {{-- Rating Bubbles --}}
            <div class="flex items-center gap-1.5 mb-2">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullBubbles)
                            <svg class="w-3.5 h-3.5 text-[#00aa6c] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @elseif($i == $fullBubbles + 1 && $halfBubble)
                            <svg class="w-3.5 h-3.5 text-[#00aa6c]" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 2a8 8 0 000 16z"/>
                                <path fill="none" stroke="currentColor" stroke-width="2" d="M10 2a8 8 0 110 16 8 8 0 010-16z"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-xs text-gray-500 font-medium">{{ $place->reviews_count ?? 0 }} ulasan</span>
            </div>

            @if($place->district)
                <div class="flex items-center text-xs text-gray-600 mb-2 truncate">
                    <svg class="w-3.5 h-3.5 mr-1 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                    Kec. {{ $place->district }}
                </div>
            @endif
            <p class="text-[13px] text-gray-600 line-clamp-2">
                {{ strip_tags($place->description) }}
            </p>
        </div>
        
        <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between">
            <div>
                @if($place->has_general_price && $place->formatted_price)
                    @if($place->price > 0)
                        <div class="font-extrabold text-[#1a6bbf] text-sm leading-tight">{{ $place->formatted_price }}</div>
                    @else
                        <div class="font-bold text-[#00aa6c] text-sm">Gratis</div>
                    @endif
                @elseif($place->has_ticket && $place->ticket_price)
                    <div class="font-extrabold text-[#1a6bbf] text-sm leading-tight">Rp {{ number_format($place->ticket_price, 0, ',', '.') }}</div>
                @else
                    <div class="font-bold text-[#00aa6c] text-sm">Gratis</div>
                @endif
            </div>
            <a href="{{ route('place.show', $place->slug) }}" class="text-[#1a6bbf] font-bold text-sm hover:underline">Detail ›</a>
        </div>
    </div>
</div>
