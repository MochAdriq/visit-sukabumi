<x-filament-panels::page>
    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Ulasan --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-blue-50 flex items-center justify-center text-[#1a6bbf]">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Total Ulasan</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $this->totalReviews }}</p>
            </div>
        </div>

        {{-- Rating Rata-Rata --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-500">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Rating Rata-Rata</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $this->avgRating }} <span class="text-base text-gray-400">/ 5</span></p>
            </div>
        </div>

        {{-- Wishlist --}}
        <div class="bg-white rounded-2xl border border-gray-100 p-6 shadow-sm flex items-center gap-4">
            <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-400">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Ditambahkan ke Wishlist</p>
                <p class="text-2xl font-extrabold text-gray-900">{{ $this->wishlistCount }}</p>
            </div>
        </div>
    </div>

    {{-- Daftar Destinasi --}}
    @if($this->places->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm mb-8">
        <div class="p-6 border-b border-gray-100">
            <h2 class="font-bold text-gray-900">Destinasi yang Dikelola</h2>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($this->places as $place)
            <div class="p-5 flex items-center gap-4">
                <div class="w-14 h-14 rounded-xl overflow-hidden flex-shrink-0 bg-gray-100">
                    <img src="{{ $place->cover_image_url }}" alt="{{ $place->name }}" class="w-full h-full object-cover">
                </div>
                <div class="flex-1">
                    <h3 class="font-bold text-gray-900">{{ $place->name }}</h3>
                    <p class="text-sm text-gray-500">{{ $place->district }}</p>
                </div>
                <a href="{{ route('place.show', $place->slug) }}" target="_blank"
                   class="text-xs font-bold text-[#1a6bbf] hover:underline flex items-center gap-1">
                    Lihat Halaman Publik
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Ulasan Terbaru --}}
    @if($this->recentReviews->count() > 0)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm">
        <div class="p-6 border-b border-gray-100 flex items-center justify-between">
            <h2 class="font-bold text-gray-900">Ulasan Terbaru</h2>
            <a href="{{ \App\Filament\Kelola\Resources\ReviewManagementResource::getUrl() }}"
               class="text-xs font-bold text-[#1a6bbf] hover:underline">Kelola Semua Ulasan</a>
        </div>
        <div class="divide-y divide-gray-50">
            @foreach($this->recentReviews as $review)
            <div class="p-5">
                <div class="flex items-start gap-3">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($review->user->name) }}&background=e5e7eb&color=374151&size=40"
                         class="w-9 h-9 rounded-full flex-shrink-0">
                    <div class="flex-1">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="font-bold text-sm text-gray-900">{{ $review->user->name }}</span>
                            <span class="text-xs text-gray-400">→ {{ $review->place->name }}</span>
                            <div class="inline-flex items-center gap-0.5 text-yellow-400">
                                @for($i = 1; $i <= 5; $i++)
                                    <svg class="w-3.5 h-3.5 {{ $i <= $review->rating ? 'text-yellow-400' : 'text-gray-200' }}" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                                    </svg>
                                @endfor
                            </div>
                        </div>
                        <p class="text-sm text-gray-600">{{ $review->content }}</p>
                        @if($review->official_response)
                        <div class="mt-2 pl-3 border-l-2 border-[#1a6bbf] text-xs text-gray-500">
                            <span class="font-bold text-[#1a6bbf]">Respons Anda:</span> {{ $review->official_response }}
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</x-filament-panels::page>
