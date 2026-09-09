@props(['place', 'rank'])

@php
    $fallbackImage = "https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&h=480&fit=crop";
    $image = $place->primaryImage ? Storage::url($place->primaryImage->image_path) : $fallbackImage;
    $rating = $place->reviews_avg_rating ?? 0;
    $fullBubbles = floor($rating);
    $halfBubble = ($rating - $fullBubbles) >= 0.5;
@endphp

<div class="group relative flex flex-col bg-white">
    {{-- Image Box --}}
    <div class="relative w-full aspect-[4/3] rounded-xl overflow-hidden cursor-pointer mb-3">
        <a href="{{ route('place.show', $place->slug) }}" class="block w-full h-full">
            <img alt="{{ $place->name }}" src="{{ $image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
        </a>
        <!-- Wishlist Heart -->
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

    {{-- Content Layout (TripAdvisor Ranked Style) --}}
    <div class="flex items-start gap-4">
        {{-- Big Rank Number --}}
        <div class="text-4xl md:text-5xl font-black text-gray-900 leading-none pt-1">
            {{ $rank }}
        </div>
        
        {{-- Details --}}
        <div class="flex-1 flex flex-col pt-1">
            <div class="text-[11px] text-gray-500 mb-0.5 uppercase tracking-wider font-semibold">
                {{ $place->district ? 'Kec. ' . $place->district : 'Sukabumi' }}
            </div>
            <a href="{{ route('place.show', $place->slug) }}" class="text-base md:text-lg font-bold text-gray-900 hover:underline leading-tight mb-1.5 line-clamp-2">
                {{ $place->name }}
            </a>
            
            {{-- Rating Bubbles --}}
            <div class="flex items-center gap-1.5 mb-2">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullBubbles)
                            <svg class="w-3.5 h-3.5 text-[#00aa6c] fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                        @elseif($i == $fullBubbles + 1 && $halfBubble)
                            {{-- Half bubble --}}
                            <svg class="w-3.5 h-3.5 text-[#00aa6c]" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 2a8 8 0 000 16z"/>
                                <path fill="none" stroke="currentColor" stroke-width="2" d="M10 2a8 8 0 110 16 8 8 0 010-16z"/>
                            </svg>
                        @else
                            <svg class="w-3.5 h-3.5 text-gray-300 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-xs text-gray-500 font-medium">({{ $place->reviews_count ?? 0 }})</span>
            </div>

            {{-- Price --}}
            <div class="mt-auto">
                @if($place->price)
                    <div class="text-xs text-gray-500">Mulai dari</div>
                    <div class="font-extrabold text-gray-900 text-sm">Rp {{ number_format($place->price, 0, ',', '.') }}</div>
                @else
                    <div class="font-bold text-green-600 text-sm mt-3">Akses Gratis</div>
                @endif
            </div>
        </div>
    </div>
</div>
