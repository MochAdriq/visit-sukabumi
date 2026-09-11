@props(['place'])

@php
    $image = $place->cover_image_url;
    
    // Assign a badge dynamically just for demo
    $badges = ['Top Rated', 'Special offer', 'An itinerary essential', 'Popular', 'Staff Pick'];
    $badge = $badges[$place->id % count($badges)];
@endphp

<div class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md">
    <!-- Image & Gradient Overlay -->
    <img alt="{{ $place->name }}" src="{{ $image }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>

    <!-- Stretched Link for Card Navigation -->
    <a href="{{ route('place.show', $place->slug) }}" class="absolute inset-0 z-10">
        <span class="sr-only">Lihat detail {{ $place->name }}</span>
    </a>

    @if($place->id % 3 !== 0) <!-- Randomly show badge -->
        <span class="absolute top-4 left-0 bg-[#f9a826] text-gray-900 text-[12px] font-bold px-3 py-1 z-20 rounded-r-md shadow-sm pointer-events-none">{{ $badge }}</span>
    @endif
    
    <!-- Wishlist Heart Icon (Top Right) -->
    <div class="absolute top-4 right-4 z-30">
        @auth
            @php
                $isWishlisted = auth()->user()->wishlists()->where('place_id', $place->id)->exists();
            @endphp
            <form action="{{ route('wishlist.toggle', $place->id) }}" method="POST">
                @csrf
                <button type="submit" class="bg-white/20 backdrop-blur-sm w-9 h-9 rounded-full flex items-center justify-center hover:bg-white/40 transition-colors" title="{{ $isWishlisted ? 'Hapus dari Wishlist' : 'Simpan ke Wishlist' }}">
                    <svg class="w-5 h-5 {{ $isWishlisted ? 'text-red-500 fill-red-500' : 'text-white' }} drop-shadow-md transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                    </svg>
                </button>
            </form>
        @else
            <a href="{{ route('login') }}" class="bg-white/20 backdrop-blur-sm w-9 h-9 rounded-full flex items-center justify-center hover:bg-white/40 transition-colors" title="Login untuk menyimpan ke Wishlist">
                <svg class="w-5 h-5 text-white drop-shadow-md" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z" />
                </svg>
            </a>
        @endauth
    </div>
    
    <!-- Card Content -->
    <div class="absolute inset-x-0 bottom-0 p-5 z-20 flex flex-col justify-end pointer-events-none">
        <!-- Rating & Reviews -->
        <div class="flex items-center gap-1.5 mb-1">
            <div class="flex items-center text-[#f9a826]">
                <svg class="w-4 h-4 fill-current" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <span class="text-white text-[13px] font-bold">{{ number_format($place->reviews_avg_rating ?? 0, 1) }}</span>
            <span class="text-gray-300 text-[12px]">({{ $place->reviews_count ?? 0 }})</span>
        </div>

        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">{{ $place->name }}</h3>
        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
            <p class="text-[13px] text-gray-200 line-clamp-3">
                {{ $place->description }}
            </p>
        </div>
    </div>
</div>
