@props(['place'])

@php
    $image = $place->cover_image_url;
    $rating = $place->reviews_avg_rating ?? 0;
    $fullBubbles = floor($rating);
    $halfBubble = ($rating - $fullBubbles) >= 0.5;
@endphp

<div class="group flex flex-col md:flex-row bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
    {{-- Image Section --}}
    <div class="relative w-full md:w-64 h-56 md:h-auto flex-shrink-0 cursor-pointer overflow-hidden">
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
                    <button type="submit" class="bg-white w-8 h-8 rounded-full flex items-center justify-center shadow-sm hover:bg-gray-50 transition-colors" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Simpan ke Wishlist' }}">
                        <svg class="w-4 h-4 {{ $isWishlisted ? 'text-red-500 fill-red-500' : 'text-gray-900' }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                        </svg>
                    </button>
                </form>
            @else
                <a href="{{ route('login') }}" class="bg-white w-8 h-8 rounded-full flex items-center justify-center shadow-sm hover:bg-gray-50 transition-colors" title="Login untuk menyimpan ke Wishlist">
                    <svg class="w-4 h-4 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </a>
            @endauth
        </div>
    </div>

    {{-- Content Section --}}
    <div class="flex-1 p-4 md:p-5 flex flex-col justify-between">
        <div>
            {{-- Title & Category --}}
            <div class="flex justify-between items-start mb-1">
                <a href="{{ route('place.show', $place->slug) }}" class="text-xl font-bold text-gray-900 hover:underline">
                    {{ $place->name }}
                </a>
            </div>

            {{-- Rating Bubbles --}}
            <div class="flex items-center gap-1.5 mb-3">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullBubbles)
                            <svg class="w-4 h-4 text-[#00aa6c] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @elseif($i == $fullBubbles + 1 && $halfBubble)
                            {{-- Half bubble --}}
                            <svg class="w-4 h-4 text-[#00aa6c]" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 2a8 8 0 000 16z"/>
                                <path fill="none" stroke="currentColor" stroke-width="2" d="M10 2a8 8 0 110 16 8 8 0 010-16z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-sm text-gray-500 font-medium">{{ $place->reviews_count ?? 0 }} ulasan</span>
            </div>

            {{-- Meta info (District / Category) --}}
            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 mb-3">
                @if($place->category)
                    <span class="font-medium text-gray-800">{{ $place->category->name }}</span>
                @endif
                @if($place->district)
                    <span class="text-gray-300">•</span>
                    <span>Kec. {{ $place->district }}</span>
                @endif
            </div>

            {{-- Description Snippet --}}
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed mb-3">
                {{ $place->description }}
            </p>

            {{-- Best Review Snippet (TripAdvisor Style) --}}
            @if(isset($place->reviews) && $place->reviews->count() > 0)
                @php $bestReview = $place->reviews->first(); @endphp
                <div class="bg-[#f8f9fa] rounded-lg p-3 text-sm italic text-gray-700 border-l-4 border-[#00aa6c] relative">
                    <svg class="absolute top-2 right-2 w-6 h-6 text-gray-200" fill="currentColor" viewBox="0 0 24 24"><path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/></svg>
                    <p class="line-clamp-2 pr-6">"{{ $bestReview->content }}"</p>
                    <div class="mt-1 font-semibold text-gray-500 text-[11px] not-italic">— {{ explode(' ', $bestReview->user->name)[0] }}</div>
                </div>
            @endif
            
            {{-- Facilities tags (if any) --}}
            @if(is_array($place->facilities) && count($place->facilities) > 0)
                <div class="mt-3 flex gap-2 flex-wrap">
                    @foreach(array_slice($place->facilities, 0, 3) as $fac)
                        <span class="text-[11px] font-semibold text-gray-600 bg-gray-100 px-2 py-0.5 rounded">{{ $fac }}</span>
                    @endforeach
                    @if(count($place->facilities) > 3)
                        <span class="text-[11px] font-semibold text-gray-500">+{{ count($place->facilities) - 3 }}</span>
                    @endif
                </div>
            @endif
        </div>

        {{-- Action Button --}}
        <div class="mt-4 flex items-end justify-between border-t border-gray-100 pt-3">
            <div>
                @if($place->has_general_price && $place->formatted_price)
                    @if($place->price > 0)
                        <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">{{ $place->is_price_range ? 'Rentang Harga' : 'Mulai dari' }}</div>
                        <div class="font-extrabold text-[#1a6bbf] text-base md:text-lg leading-tight">{{ $place->formatted_price }}</div>
                    @else
                        <div class="font-bold text-[#00aa6c] text-sm flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Gratis Masuk
                        </div>
                    @endif
                @elseif($place->has_ticket && $place->ticket_price)
                    <div class="text-[11px] font-bold text-gray-400 uppercase tracking-wide">Tiket Online</div>
                    <div class="font-extrabold text-[#1a6bbf] text-base md:text-lg leading-tight">Rp {{ number_format($place->ticket_price, 0, ',', '.') }}</div>
                @else
                    <div class="font-bold text-[#00aa6c] text-sm flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Gratis Masuk
                    </div>
                @endif
            </div>
            <a href="{{ route('place.show', $place->slug) }}" class="bg-gray-900 hover:bg-[#1a6bbf] text-white text-sm font-bold px-6 py-2.5 rounded-xl transition-colors shadow-sm">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
