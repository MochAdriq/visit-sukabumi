@php
    $reviews = $model->reviews()->with(['user', 'likes'])->latest()->get();
    $totalReviews = $reviews->count();
    $avgRating = $model->avgRating();
    
    $ratingCounts = [5 => 0, 4 => 0, 3 => 0, 2 => 0, 1 => 0];
    foreach ($reviews as $review) {
        if (isset($ratingCounts[$review->rating])) {
            $ratingCounts[$review->rating]++;
        }
    }
    
    $photos = $reviews->whereNotNull('image_path')->pluck('image_path');
    $storeRoute = $type === 'event' ? route('review.store.event', $model->slug) : route('review.store', $model->slug);
    
    $currentUserId = Auth::id();
    $userHasReviewed = false;
    if ($currentUserId) {
        $userHasReviewed = $reviews->where('user_id', $currentUserId)->count() > 0;
    }

    $reviewsData = $reviews->map(function ($r) use ($currentUserId) {
        return [
            'id' => $r->id,
            'user_name' => $r->user->name ?? 'Wisatawan',
            'user_initial' => strtoupper(substr($r->user->name ?? 'W', 0, 1)),
            'user_photo' => $r->user->profile_photo_url ?? null,
            'rating' => (int) $r->rating,
            'content' => $r->content,
            'visit_type' => $r->visit_type,
            'likes_count' => (int) ($r->likes_count ?? 0),
            'is_liked' => $currentUserId ? $r->likes->where('user_id', $currentUserId)->isNotEmpty() : false,
            'date_month' => $r->created_at->translatedFormat('M Y'),
            'date_full' => $r->created_at->translatedFormat('d F Y'),
            'created_at_ts' => $r->created_at->timestamp,
            'image_url' => $r->image_path ? Storage::url($r->image_path) : null,
        ];
    })->values();
@endphp

<div id="reviews" class="scroll-mt-32 section-block py-10" x-data="reviewSectionComponent()">
    
    {{-- Header & Write Review Button --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Ulasan</h2>
        <div class="flex flex-wrap items-center gap-4">
            <button @click="scrollToReviews()" class="text-sm font-semibold text-gray-700 underline cursor-pointer hover:text-black">
                Semua ulasan ({{ number_format($totalReviews) }})
            </button>
            @auth
                @if(!$userHasReviewed)
                    <button @click="showReviewModal = true" class="bg-[#002f20] hover:bg-[#001e14] text-white font-bold py-2.5 px-5 rounded-full flex items-center gap-2 transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Tulis ulasan
                    </button>
                @endif
            @else
                <a href="{{ route('login') }}" class="bg-[#002f20] hover:bg-[#001e14] text-white font-bold py-2.5 px-5 rounded-full flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                    Tulis ulasan
                </a>
            @endauth
        </div>
    </div>

    {{-- Session Alerts --}}
    @if(session('success'))
        <div class="mb-6 bg-emerald-50 text-emerald-700 p-4 rounded-xl border border-emerald-200 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 bg-red-50 text-red-700 p-4 rounded-xl border border-red-200 font-medium text-sm flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- TOP BLOCK: Rating Chart --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6">
        <div class="flex flex-col md:flex-row gap-8 lg:gap-16">
            {{-- Big Score --}}
            <div class="flex flex-col items-center justify-center flex-shrink-0">
                <div class="text-[52px] font-black text-gray-900 leading-none mb-1">{{ number_format($avgRating, 1) }}</div>
                <div class="font-bold text-gray-900 mb-1">
                    @if($avgRating >= 4.5) Luar Biasa
                    @elseif($avgRating >= 4) Sangat Bagus
                    @elseif($avgRating >= 3) Biasa
                    @elseif($avgRating >= 2) Buruk
                    @else Sangat Buruk @endif
                </div>
                <div class="flex text-[#00aa6c] mb-1 gap-0.5">
                    @for($i=1; $i<=5; $i++)
                        <svg class="w-4 h-4 {{ $i <= round($avgRating) ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    @endfor
                </div>
                <div class="text-xs text-gray-500 font-medium">{{ number_format($totalReviews) }} ulasan</div>
            </div>
            
            {{-- Distribution Bars --}}
            <div class="flex-1 max-w-sm">
                @foreach(['Luar Biasa' => 5, 'Bagus' => 4, 'Biasa' => 3, 'Buruk' => 2, 'Sangat Buruk' => 1] as $label => $stars)
                    @php 
                        $count = $ratingCounts[$stars];
                        $percentage = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
                    @endphp
                    <div @click="filterByStar({{ $stars }})" class="flex items-center gap-3 mb-2 text-sm group cursor-pointer hover:opacity-80 transition">
                        <div class="w-16 text-gray-900 font-medium group-hover:underline">{{ $label }}</div>
                        <div class="flex-1 h-3.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#00aa6c] rounded-full transition-all duration-500" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="w-8 text-right text-gray-500 font-medium text-xs">{{ number_format($count) }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    {{-- SECOND BLOCK: AI Summary Dummy --}}
    <div class="bg-white border border-gray-200 rounded-xl p-6 mb-6 relative overflow-hidden">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-lg font-bold text-gray-900">Ringkasan ulasan</h3>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    Ringkasan ini dirangkum oleh AI berdasarkan ulasan wisatawan terbaru.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                    <div class="w-6 h-6 rounded-full bg-blue-100 border border-white"></div>
                    <div class="w-6 h-6 rounded-full bg-red-100 border border-white"></div>
                    <div class="w-6 h-6 rounded-full bg-green-100 border border-white"></div>
                </div>
                <span class="text-xs font-bold text-gray-900 inline-flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-amber-500 fill-current" viewBox="0 0 24 24"><path d="M12 2l2.4 7.2h7.6l-6 4.8 2.4 7.2-6.4-4.8-6.4 4.8 2.4-7.2-6-4.8h7.6z"/></svg>
                    Didukung oleh AI
                </span>
            </div>
        </div>
        
        <div class="flex flex-col lg:flex-row gap-8">
            <div class="lg:w-2/3 text-sm text-gray-700 leading-relaxed space-y-4">
                <p>Visit Sukabumi menghadirkan suasana menarik dan menyegarkan yang digambarkan oleh banyak wisatawan sebagai pengalaman memukau dan berkesan mendalam, menyempurnakan liburan Anda. Mayoritas pengunjung menilai pemandu lokal sangat ramah, sigap, dan penuh perhatian.</p>
                <p>Destinasi alam mendapatkan banyak apresiasi positif berkat keasriannya yang terjaga dan panorama alami yang menakjubkan, dengan catatan kecil agar pengunjung memperhatikan perkiraan cuaca.</p>
                <button @click="scrollToReviews()" class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-900 text-gray-900 font-bold text-sm hover:bg-gray-50 transition-colors mt-2">
                    Lihat semua ulasan 
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                </button>
            </div>
            <div class="lg:w-1/3 grid grid-cols-2 gap-3">
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="text-gray-900 mb-1"><svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>Suasana</div>
                    <div class="font-bold text-sm">Menyegarkan</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="text-gray-900 mb-1"><svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>Pelayanan</div>
                    <div class="font-bold text-sm">Ramah & Sigap</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="text-gray-900 mb-1"><svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>Waktu tunggu</div>
                    <div class="font-bold text-sm">Fleksibel</div>
                </div>
                <div class="border border-gray-200 rounded-lg p-3">
                    <div class="text-gray-900 mb-1"><svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>Kualitas</div>
                    <div class="font-bold text-sm">Sangat Sepadan</div>
                </div>
            </div>
        </div>
    </div>

    {{-- THIRD BLOCK: Traveler Photos --}}
    @if($photos->count() > 0)
    <div class="mb-10">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-bold text-gray-900">Foto Wisatawan ({{ $photos->count() }})</h3>
        </div>
        <div class="flex gap-2 overflow-x-auto pb-4 hide-scrollbar snap-x">
            @foreach($photos as $photo)
                <div class="w-48 h-32 flex-shrink-0 rounded-lg overflow-hidden snap-start relative group cursor-pointer">
                    <img src="{{ Storage::url($photo) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- FOURTH BLOCK: All Reviews List with Filters, Pagination & Likes --}}
    <div id="all-reviews-section" class="scroll-mt-36">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-3">
            <h3 class="text-xl font-bold text-gray-900">
                Semua ulasan (<span x-text="filteredReviews.length"></span>)
            </h3>
            @auth
                @if(!$userHasReviewed)
                    <button @click="showReviewModal = true" class="bg-[#002f20] hover:bg-[#001e14] text-white font-bold py-2 px-5 rounded-full flex items-center gap-2 text-sm transition-colors self-start sm:self-auto">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Tulis ulasan
                    </button>
                @endif
            @endauth
        </div>
        
        <p class="text-xs text-gray-500 mb-6">Ulasan merupakan opini subjektif dari wisatawan anggota komunitas Visit Sukabumi. Kami melakukan verifikasi untuk memastikan ulasan tetap informatif dan terpercaya.</p>

        {{-- Filter & Search Toolbar --}}
        <div class="flex flex-wrap items-center gap-3 mb-6 relative">
            
            {{-- Filter Dropdown Toggle --}}
            <div class="relative">
                <button @click="showFilterDropdown = !showFilterDropdown" 
                        class="flex items-center gap-2 px-4 py-2 border rounded-full text-sm font-semibold transition"
                        :class="activeFilterCount > 0 ? 'bg-[#002f20] text-white border-[#002f20]' : 'bg-white border-gray-300 text-gray-900 hover:bg-gray-50'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                    <span>Filter (<span x-text="activeFilterCount"></span>)</span>
                    <svg class="w-3.5 h-3.5 transition-transform" :class="showFilterDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                {{-- Filter Modal/Dropdown Content --}}
                <div x-show="showFilterDropdown" 
                     @click.away="showFilterDropdown = false"
                     x-transition
                     class="absolute left-0 mt-2 w-72 sm:w-80 bg-white border border-gray-200 rounded-2xl shadow-xl p-5 z-40"
                     style="display: none;">
                    <div class="flex items-center justify-between pb-3 border-b border-gray-100 mb-4">
                        <span class="font-bold text-gray-900 text-sm">Filter Ulasan</span>
                        <button @click="resetFilters()" class="text-xs font-semibold text-emerald-700 hover:underline">Reset Semua</button>
                    </div>

                    {{-- Star Rating Filter --}}
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-2">Nilai Rating</label>
                        <div class="grid grid-cols-2 gap-2">
                            <button @click="selectedRating = ''; currentPage = 1" 
                                    class="px-3 py-1.5 rounded-lg border text-xs font-medium transition"
                                    :class="selectedRating === '' ? 'bg-[#002f20] text-white border-[#002f20]' : 'border-gray-200 text-gray-700 hover:bg-gray-50'">
                                Semua
                            </button>
                            <button @click="selectedRating = 5; currentPage = 1" 
                                    class="px-3 py-1.5 rounded-lg border text-xs font-medium transition flex items-center justify-center gap-1"
                                    :class="selectedRating === 5 ? 'bg-[#002f20] text-white border-[#002f20]' : 'border-gray-200 text-gray-700 hover:bg-gray-50'">
                                <span>5 Bintang</span>
                                <svg class="w-3 h-3 fill-current text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </button>
                            <button @click="selectedRating = 4; currentPage = 1" 
                                    class="px-3 py-1.5 rounded-lg border text-xs font-medium transition flex items-center justify-center gap-1"
                                    :class="selectedRating === 4 ? 'bg-[#002f20] text-white border-[#002f20]' : 'border-gray-200 text-gray-700 hover:bg-gray-50'">
                                <span>4 Bintang</span>
                                <svg class="w-3 h-3 fill-current text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </button>
                            <button @click="selectedRating = 3; currentPage = 1" 
                                    class="px-3 py-1.5 rounded-lg border text-xs font-medium transition flex items-center justify-center gap-1"
                                    :class="selectedRating === 3 ? 'bg-[#002f20] text-white border-[#002f20]' : 'border-gray-200 text-gray-700 hover:bg-gray-50'">
                                <span>3 Bintang</span>
                                <svg class="w-3 h-3 fill-current text-amber-400" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                            </button>
                        </div>
                    </div>

                    {{-- Visit Type Filter --}}
                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 mb-2">Tipe Kunjungan</label>
                        <select x-model="selectedVisitType" @change="currentPage = 1" class="w-full text-xs rounded-xl border-gray-300 py-2 px-3 focus:ring-[#002f20] focus:border-[#002f20]">
                            <option value="">Semua Tipe Kunjungan</option>
                            <option value="Keluarga">Keluarga</option>
                            <option value="Pasangan">Pasangan</option>
                            <option value="Teman">Teman</option>
                            <option value="Solo">Sendiri (Solo)</option>
                            <option value="Bisnis">Bisnis</option>
                        </select>
                    </div>

                    <div class="pt-3 border-t border-gray-100 flex justify-end">
                        <button @click="showFilterDropdown = false" class="bg-[#002f20] hover:bg-[#001e14] text-white text-xs font-bold px-4 py-2 rounded-xl transition">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>

            {{-- Sort Dropdown --}}
            <div class="relative">
                <button @click="showSortDropdown = !showSortDropdown" 
                        class="flex items-center gap-1.5 px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-semibold text-gray-900 hover:bg-gray-50 transition">
                    <span x-text="sortLabels[selectedSort]"></span>
                    <svg class="w-4 h-4 ml-1 transition-transform" :class="showSortDropdown ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>

                <div x-show="showSortDropdown" 
                     @click.away="showSortDropdown = false"
                     x-transition
                     class="absolute left-0 mt-2 w-52 bg-white border border-gray-200 rounded-2xl shadow-xl py-2 z-40 text-xs font-semibold text-gray-800"
                     style="display: none;">
                    <button @click="selectedSort = 'latest'; showSortDropdown = false; currentPage = 1" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 flex items-center justify-between" :class="selectedSort === 'latest' ? 'text-emerald-700 bg-emerald-50' : ''">
                        <span>Urutkan: Terbaru</span>
                        <svg x-show="selectedSort === 'latest'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                    <button @click="selectedSort = 'highest'; showSortDropdown = false; currentPage = 1" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 flex items-center justify-between" :class="selectedSort === 'highest' ? 'text-emerald-700 bg-emerald-50' : ''">
                        <span>Rating Tertinggi (5 ke 1)</span>
                        <svg x-show="selectedSort === 'highest'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                    <button @click="selectedSort = 'lowest'; showSortDropdown = false; currentPage = 1" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 flex items-center justify-between" :class="selectedSort === 'lowest' ? 'text-emerald-700 bg-emerald-50' : ''">
                        <span>Rating Terendah (1 ke 5)</span>
                        <svg x-show="selectedSort === 'lowest'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                    <button @click="selectedSort = 'popular'; showSortDropdown = false; currentPage = 1" class="w-full text-left px-4 py-2.5 hover:bg-gray-50 flex items-center justify-between" :class="selectedSort === 'popular' ? 'text-emerald-700 bg-emerald-50' : ''">
                        <span>Paling Banyak Disukai</span>
                        <svg x-show="selectedSort === 'popular'" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </button>
                </div>
            </div>

            {{-- Live Search Input --}}
            <div class="relative flex-1 min-w-[220px]">
                <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" 
                       x-model.debounce.250ms="searchQuery"
                       @input="currentPage = 1"
                       placeholder="Cari kata kunci atau nama wisatawan..." 
                       class="w-full pl-9 pr-8 py-2 bg-white border border-gray-300 rounded-full text-sm focus:ring-[#002f20] focus:border-[#002f20] transition-colors">
                <button x-show="searchQuery.length > 0" 
                        @click="searchQuery = ''; currentPage = 1"
                        class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400 hover:text-gray-600"
                        style="display: none;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>

        {{-- Popular Mentions Tags --}}
        <div class="mb-8">
            <div class="flex items-center justify-between mb-3">
                <h4 class="text-sm font-bold text-gray-900">Sering disebut</h4>
                <button x-show="selectedTag" @click="selectedTag = ''; currentPage = 1" class="text-xs text-emerald-700 font-semibold hover:underline" style="display: none;">
                    Hapus Filter Kata Kunci
                </button>
            </div>
            <div class="flex flex-wrap gap-2">
                @foreach(['Pemandangan', 'Keluarga', 'Suasana', 'Sejuk', 'Bersih', 'Spot foto', 'Healing', 'Curug', 'Sunset', 'Ramah'] as $tag)
                <button type="button" 
                        @click="filterByTag('{{ $tag }}')"
                        class="px-3.5 py-1.5 border rounded-full text-xs sm:text-sm font-medium transition-colors"
                        :class="selectedTag === '{{ $tag }}' ? 'bg-[#002f20] text-white border-[#002f20]' : 'bg-white border-gray-200 text-gray-700 hover:bg-gray-50'">
                    {{ $tag }}
                </button>
                @endforeach
            </div>
        </div>

        {{-- Interactive Reviews List (Paginated) --}}
        <div x-show="filteredReviews.length > 0" class="space-y-6">
            <template x-for="review in paginatedReviews" :key="review.id">
                <div class="bg-white border border-gray-200 rounded-xl p-5 md:p-6 shadow-sm transition-all hover:border-gray-300">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-emerald-50 text-emerald-800 overflow-hidden flex items-center justify-center flex-shrink-0 border border-gray-200 font-bold text-lg">
                                <template x-if="review.user_photo">
                                    <img :src="review.user_photo" class="w-full h-full object-cover">
                                </template>
                                <template x-if="!review.user_photo">
                                    <span x-text="review.user_initial"></span>
                                </template>
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-[15px]" x-text="review.user_name"></div>
                                <div class="text-xs text-gray-500">
                                    Sukabumi, Indonesia
                                    <span x-show="review.visit_type"> &middot; <span x-text="review.visit_type"></span></span>
                                </div>
                            </div>
                        </div>

                        {{-- Like Button with DB Sync --}}
                        <div class="flex items-center gap-2">
                            <button type="button" 
                                    @click="toggleLike(review)"
                                    title="Sukai ulasan ini"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-full border transition-all text-xs font-semibold"
                                    :class="review.is_liked ? 'border-emerald-600 bg-emerald-50 text-emerald-700 shadow-sm' : 'border-gray-200 text-gray-600 hover:border-gray-400 hover:text-gray-900 bg-white'">
                                <svg class="w-4 h-4 transition-transform active:scale-125" 
                                     :class="review.is_liked ? 'fill-emerald-600 text-emerald-600' : 'fill-none text-current'" 
                                     stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                                </svg>
                                <span x-text="review.likes_count"></span>
                            </button>
                        </div>
                    </div>

                    {{-- Rating Stars --}}
                    <div class="flex items-center gap-1 mb-2 text-[#00aa6c]">
                        <template x-for="i in 5" :key="i">
                            <svg class="w-4 h-4 fill-current" 
                                 :class="i <= review.rating ? 'text-[#00aa6c]' : 'text-gray-200'" 
                                 viewBox="0 0 20 20">
                                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                            </svg>
                        </template>
                    </div>

                    <h4 class="font-bold text-gray-900 mb-1">
                        <span x-text="review.rating === 5 ? 'Pengalaman Luar Biasa!' : (review.rating === 4 ? 'Kunjungan yang Sangat Menyenangkan' : 'Cukup Berkesan')"></span>
                    </h4>
                    <div class="text-xs text-gray-500 mb-3 font-medium">
                        <span x-text="review.date_month"></span>
                    </div>

                    <p class="text-[15px] text-gray-800 leading-relaxed" x-text="review.content"></p>

                    <template x-if="review.image_url">
                        <div class="mt-4">
                            <img :src="review.image_url" class="rounded-lg max-h-48 object-cover border border-gray-200">
                        </div>
                    </template>
                    <div class="mt-4 text-xs text-gray-400">
                        Ditulis pada <span x-text="review.date_full"></span>
                    </div>
                </div>
            </template>
        </div>

        {{-- Empty State when filter yields 0 results --}}
        <div x-show="filteredReviews.length === 0" class="text-center py-12 border border-gray-200 rounded-2xl bg-gray-50 p-6" style="display: none;">
            <div class="w-12 h-12 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-3 text-gray-400">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h4 class="font-bold text-gray-900 mb-1">Tidak ada ulasan yang sesuai</h4>
            <p class="text-gray-500 text-xs mb-4">Coba sesuaikan kata kunci pencarian atau ubah pilihan filter Anda.</p>
            <button @click="resetFilters()" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-full bg-[#002f20] hover:bg-[#001e14] text-white text-xs font-bold transition">
                Reset Semua Filter
            </button>
        </div>

        {{-- Pagination Controls (5 per page) --}}
        <div x-show="totalPages > 1" class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-gray-200 mt-8" style="display: none;">
            <div class="text-xs text-gray-500 font-medium">
                Menampilkan <span class="font-bold text-gray-900" x-text="((currentPage - 1) * perPage) + 1"></span> - <span class="font-bold text-gray-900" x-text="Math.min(currentPage * perPage, filteredReviews.length)"></span> dari <span class="font-bold text-gray-900" x-text="filteredReviews.length"></span> ulasan
            </div>
            <div class="flex items-center gap-1.5">
                <button type="button" 
                        @click="setPage(currentPage - 1)" 
                        :disabled="currentPage === 1" 
                        class="px-3.5 py-2 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Sebelumnya
                </button>
                <div class="flex items-center gap-1">
                    <template x-for="p in visiblePages" :key="p">
                        <button type="button" 
                                @click="setPage(p)" 
                                :class="currentPage === p ? 'bg-[#002f20] text-white font-black' : 'bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 font-semibold'"
                                class="w-9 h-9 rounded-xl text-xs flex items-center justify-center transition"
                                x-text="p">
                        </button>
                    </template>
                </div>
                <button type="button" 
                        @click="setPage(currentPage + 1)" 
                        :disabled="currentPage === totalPages" 
                        class="px-3.5 py-2 rounded-xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-50 disabled:opacity-30 disabled:cursor-not-allowed transition flex items-center gap-1">
                    Selanjutnya
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>

    </div>

    {{-- MODAL: Login Required for Like Notification --}}
    <div x-show="showLoginNotice" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         style="display: none;">
         
        <div @click.away="showLoginNotice = false" 
             class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-6 relative text-center">
            <div class="w-14 h-14 bg-emerald-50 text-[#00aa6c] rounded-full flex items-center justify-center mx-auto mb-4 border border-emerald-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/>
                </svg>
            </div>
            <h3 class="text-lg font-bold text-gray-900 mb-1">Masuk untuk Menyukai Ulasan</h3>
            <p class="text-xs text-gray-500 mb-6 leading-relaxed">
                Anda harus masuk ke akun Visit Sukabumi terlebih dahulu untuk memberikan apresiasi dan menyukai ulasan ini.
            </p>
            <div class="flex gap-3">
                <button type="button" @click="showLoginNotice = false" class="w-1/2 py-2.5 px-4 rounded-xl border border-gray-300 font-bold text-gray-700 hover:bg-gray-50 text-xs transition">
                    Batal
                </button>
                <a href="{{ route('login') }}" class="w-1/2 py-2.5 px-4 rounded-xl bg-[#002f20] hover:bg-[#001e14] text-white font-bold text-xs text-center flex items-center justify-center transition shadow-sm">
                    Masuk Sekarang
                </a>
            </div>
        </div>
    </div>

    {{-- WRITE REVIEW MODAL --}}
    @auth
    @if(!$userHasReviewed)
    <div x-show="showReviewModal" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/60 backdrop-blur-sm"
         style="display: none;">
         
         <div @click.away="showReviewModal = false" 
              x-transition:enter="transition ease-out duration-300"
              x-transition:enter-start="opacity-0 scale-95 translate-y-4"
              x-transition:enter-end="opacity-100 scale-100 translate-y-0"
              x-transition:leave="transition ease-in duration-200"
              x-transition:leave-start="opacity-100 scale-100 translate-y-0"
              x-transition:leave-end="opacity-0 scale-95 translate-y-4"
              class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl overflow-hidden relative max-h-[90vh] flex flex-col">
              
            {{-- Modal Header --}}
            <div class="flex items-center justify-between p-6 border-b border-gray-100">
                <h3 class="text-xl font-bold text-gray-900">Ceritakan pengalaman Anda</h3>
                <button type="button" @click="showReviewModal = false" class="text-gray-400 hover:text-gray-900 p-1 rounded-full hover:bg-gray-100 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>

            {{-- Modal Body (Scrollable) --}}
            <div class="p-6 overflow-y-auto">
                <form action="{{ $storeRoute }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <h4 class="font-bold text-gray-900 mb-6 text-xl">{{ $type === 'event' ? $model->title : $model->name }}</h4>
                    
                    <div class="mb-8">
                        <label class="block text-sm font-bold text-gray-900 mb-3">Bagaimana Anda menilai pengalaman berkunjung?</label>
                        <div class="flex items-center gap-1" id="modal-star-container">
                            @for($i=1; $i<=5; $i++)
                                <button type="button" onclick="setModalRating({{ $i }})" class="modal-star-btn focus:outline-none group p-1" data-rating="{{ $i }}">
                                    <svg class="w-10 h-10 text-gray-200 group-hover:text-[#00aa6c] transition-colors duration-200 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                </button>
                            @endfor
                        </div>
                        <input type="hidden" name="rating" id="modal-rating-input" required value="5">
                    </div>

                    <div class="mb-6">
                        <label class="block text-sm font-bold text-gray-900 mb-2">Tulis ulasan Anda</label>
                        <textarea name="content" rows="5" class="w-full rounded-xl border border-gray-300 focus:border-[#002f20] focus:ring focus:ring-[#002f20]/20 text-gray-900 p-4 transition-all resize-none text-[15px]" placeholder="Apa momen paling berkesan dari kunjungan Anda? Bagikan cerita dan tips untuk wisatawan lainnya." required></textarea>
                        <div class="text-right text-xs text-gray-500 mt-2">Minimal 100 karakter</div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Dengan siapa Anda berkunjung? (Opsional)</label>
                            <select name="visit_type" class="w-full rounded-xl border border-gray-300 focus:border-[#002f20] focus:ring focus:ring-[#002f20]/20 text-gray-900 p-3.5 transition-all appearance-none bg-[url('data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20width%3D%22292.4%22%20height%3D%22292.4%22%3E%3Cpath%20fill%3D%22%23131313%22%20d%3D%22M287%2069.4a17.6%2017.6%200%200%200-13-5.4H18.4c-5%200-9.3%201.8-12.9%205.4A17.6%2017.6%200%200%200%200%2082.2c0%205%201.8%209.3%205.4%2012.9l128%20127.9c3.6%203.6%207.8%205.4%2012.8%205.4s9.2-1.8%2012.8-5.4L287%2095c3.5-3.5%205.4-7.8%205.4-12.8%200-5-1.9-9.2-5.5-12.8z%22%2F%3E%3C%2Fsvg%3E')] bg-[length:12px_12px] bg-no-repeat bg-[position:right_1rem_center]">
                                <option value="">Pilih salah satu...</option>
                                <option value="Keluarga">Keluarga</option>
                                <option value="Pasangan">Pasangan</option>
                                <option value="Teman">Teman</option>
                                <option value="Solo">Sendiri (Solo)</option>
                                <option value="Bisnis">Bisnis</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-gray-900 mb-2">Unggah foto (Opsional)</label>
                            <div class="relative w-full h-[52px]">
                                <input type="file" name="image" id="modal-review-image" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" onchange="document.getElementById('modal-file-name').textContent = this.files[0] ? this.files[0].name : 'Pilih file foto'"/>
                                <div class="w-full h-full rounded-xl border border-gray-300 bg-white flex items-center justify-center gap-2 p-3 text-gray-900 font-semibold text-sm transition-colors group-hover:border-[#002f20]">
                                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <span id="modal-file-name" class="truncate">Pilih foto</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <p class="text-[11px] text-gray-500 mb-6 leading-relaxed">
                        Saya menyatakan bahwa ulasan ini adalah pengalaman pribadi dan opini murni saya, tanpa ada hubungan bisnis atau imbalan dari pihak pengelola untuk menulis ulasan ini.
                    </p>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-[#002f20] hover:bg-[#001e14] text-white font-bold px-8 py-3.5 rounded-full transition-colors w-full sm:w-auto">
                            Kirim Ulasan
                        </button>
                    </div>
                </form>
            </div>
         </div>
    </div>
    @endif
    @endauth

</div>

<script>
    function reviewSectionComponent() {
        return {
            showReviewModal: false,
            showLoginNotice: false,
            isLoggedIn: {{ Auth::check() ? 'true' : 'false' }},
            likeRouteBase: '{{ url('/review') }}',
            csrfToken: '{{ csrf_token() }}',

            allReviews: @json($reviewsData),
            searchQuery: '',
            selectedRating: '',
            selectedVisitType: '',
            selectedSort: 'latest',
            selectedTag: '',

            showFilterDropdown: false,
            showSortDropdown: false,

            sortLabels: {
                latest: 'Urutkan: Terbaru',
                highest: 'Rating Tertinggi',
                lowest: 'Rating Terendah',
                popular: 'Paling Disukai'
            },

            currentPage: 1,
            perPage: 5,

            get filteredReviews() {
                let list = [...this.allReviews];

                // 1. Text Search Filter
                if (this.searchQuery.trim()) {
                    const q = this.searchQuery.toLowerCase();
                    list = list.filter(r => 
                        (r.content && r.content.toLowerCase().includes(q)) || 
                        (r.user_name && r.user_name.toLowerCase().includes(q))
                    );
                }

                // 2. Tag Filter
                if (this.selectedTag) {
                    const t = this.selectedTag.toLowerCase();
                    list = list.filter(r => r.content && r.content.toLowerCase().includes(t));
                }

                // 3. Star Rating Filter
                if (this.selectedRating !== '') {
                    list = list.filter(r => r.rating === parseInt(this.selectedRating));
                }

                // 4. Visit Type Filter
                if (this.selectedVisitType) {
                    list = list.filter(r => r.visit_type === this.selectedVisitType);
                }

                // 5. Sorting
                if (this.selectedSort === 'latest') {
                    list.sort((a, b) => b.created_at_ts - a.created_at_ts);
                } else if (this.selectedSort === 'highest') {
                    list.sort((a, b) => b.rating - a.rating || b.created_at_ts - a.created_at_ts);
                } else if (this.selectedSort === 'lowest') {
                    list.sort((a, b) => a.rating - b.rating || b.created_at_ts - a.created_at_ts);
                } else if (this.selectedSort === 'popular') {
                    list.sort((a, b) => b.likes_count - a.likes_count || b.created_at_ts - a.created_at_ts);
                }

                return list;
            },

            get totalPages() {
                return Math.max(1, Math.ceil(this.filteredReviews.length / this.perPage));
            },

            get paginatedReviews() {
                const start = (this.currentPage - 1) * this.perPage;
                return this.filteredReviews.slice(start, start + this.perPage);
            },

            get visiblePages() {
                const total = this.totalPages;
                const current = this.currentPage;
                if (total <= 5) {
                    return Array.from({ length: total }, (_, i) => i + 1);
                }
                let start = Math.max(1, current - 2);
                let end = Math.min(total, start + 4);
                if (end - start < 4) {
                    start = Math.max(1, end - 4);
                }
                return Array.from({ length: end - start + 1 }, (_, i) => start + i);
            },

            get activeFilterCount() {
                let count = 0;
                if (this.selectedRating !== '') count++;
                if (this.selectedVisitType) count++;
                if (this.selectedTag) count++;
                return count;
            },

            scrollToReviews() {
                const el = document.getElementById('all-reviews-section');
                if (el) {
                    el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                }
            },

            setPage(p) {
                if (p >= 1 && p <= this.totalPages) {
                    this.currentPage = p;
                    this.scrollToReviews();
                }
            },

            filterByStar(stars) {
                if (this.selectedRating === stars) {
                    this.selectedRating = '';
                } else {
                    this.selectedRating = stars;
                }
                this.currentPage = 1;
                this.scrollToReviews();
            },

            filterByTag(tag) {
                if (this.selectedTag === tag) {
                    this.selectedTag = '';
                } else {
                    this.selectedTag = tag;
                }
                this.currentPage = 1;
                this.scrollToReviews();
            },

            resetFilters() {
                this.searchQuery = '';
                this.selectedRating = '';
                this.selectedVisitType = '';
                this.selectedTag = '';
                this.selectedSort = 'latest';
                this.currentPage = 1;
            },

            toggleLike(review) {
                if (!this.isLoggedIn) {
                    this.showLoginNotice = true;
                    return;
                }

                const wasLiked = review.is_liked;
                // Optimistic UI toggle
                review.is_liked = !wasLiked;
                review.likes_count = Math.max(0, review.likes_count + (wasLiked ? -1 : 1));

                fetch(`${this.likeRouteBase}/${review.id}/like`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': this.csrfToken,
                        'Accept': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data && data.success) {
                        review.is_liked = data.liked;
                        review.likes_count = data.likes_count;
                    }
                })
                .catch(() => {
                    // Revert on error
                    review.is_liked = wasLiked;
                    review.likes_count = Math.max(0, review.likes_count + (wasLiked ? 1 : -1));
                });
            }
        };
    }

    // Review Star Rating Logic inside Modal
    function setModalRating(rating) {
        const input = document.getElementById('modal-rating-input');
        if (input) input.value = rating;
        const stars = document.querySelectorAll('#modal-star-container .modal-star-btn svg');
        
        stars.forEach((star, index) => {
            if (index < rating) {
                star.classList.remove('text-gray-200');
                star.classList.add('text-[#00aa6c]');
            } else {
                star.classList.remove('text-[#00aa6c]');
                star.classList.add('text-gray-200');
            }
        });
    }

    document.addEventListener('DOMContentLoaded', () => {
        const ratingInput = document.getElementById('modal-rating-input');
        if (ratingInput) {
            setModalRating(5);
        }
    });
</script>
