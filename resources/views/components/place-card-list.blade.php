@props(['place'])

@php
    $fallbackImage = "https://images.unsplash.com/photo-1542662565-7e4fd1e56993?q=80&w=640&h=480&fit=crop";
    $image = $place->primaryImage ? Storage::url($place->primaryImage->image_path) : $fallbackImage;
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
                            <svg class="w-4 h-4 text-[#00aa6c] fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
                        @elseif($i == $fullBubbles + 1 && $halfBubble)
                            {{-- Half bubble --}}
                            <svg class="w-4 h-4 text-[#00aa6c]" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M10 2a8 8 0 000 16z"/>
                                <path fill="none" stroke="currentColor" stroke-width="2" d="M10 2a8 8 0 110 16 8 8 0 010-16z"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><circle cx="10" cy="10" r="8"/></svg>
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
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ $place->description }}
            </p>
            
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
                @if($place->price)
                    <div class="text-xs text-gray-500">Mulai dari</div>
                    <div class="font-extrabold text-gray-900 text-lg">Rp {{ number_format($place->price, 0, ',', '.') }}</div>
                @else
                    <div class="font-bold text-green-600 text-sm">Akses Gratis</div>
                @endif
            </div>
            <a href="{{ route('place.show', $place->slug) }}" class="bg-[#f9a826] hover:bg-[#e8971e] text-gray-900 text-sm font-bold px-5 py-2 rounded-full transition-colors shadow-sm">
                Lihat Detail
            </a>
        </div>
    </div>
</div>
