@php
    $reviews = $model->reviews()->with('user')->latest()->get();
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
    
    $userHasReviewed = false;
    if (Auth::check()) {
        $userHasReviewed = $reviews->where('user_id', Auth::id())->count() > 0;
    }
@endphp

<div id="reviews" class="scroll-mt-32 section-block py-10" x-data="{ showReviewModal: false }">
    
    {{-- Header & Write Review Button --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">
        <h2 class="text-2xl font-bold text-gray-900 tracking-tight">Ulasan</h2>
        <div class="flex flex-wrap items-center gap-4">
            <div class="text-sm font-semibold text-gray-700 underline cursor-pointer hover:text-black">Semua ulasan ({{ number_format($totalReviews) }})</div>
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
                    <div class="flex items-center gap-3 mb-2 text-sm group cursor-pointer">
                        <div class="w-16 text-gray-900 font-medium group-hover:underline">{{ $label }}</div>
                        <div class="flex-1 h-3.5 bg-gray-100 rounded-full overflow-hidden">
                            <div class="h-full bg-[#00aa6c] rounded-full" style="width: {{ $percentage }}%"></div>
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
                <button class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border border-gray-900 text-gray-900 font-bold text-sm hover:bg-gray-50 transition-colors mt-2">
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
            <span class="text-sm font-semibold text-gray-900 underline cursor-pointer hover:text-black">Tambah foto</span>
        </div>
        <div class="flex gap-2 overflow-x-auto pb-4 hide-scrollbar snap-x">
            @foreach($photos as $photo)
                <div class="w-48 h-32 flex-shrink-0 rounded-lg overflow-hidden snap-start relative group cursor-pointer">
                    <img src="{{ Storage::url($photo) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                    <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                </div>
            @endforeach
            <div class="w-20 h-32 flex-shrink-0 flex items-center justify-center snap-start">
                <button class="w-10 h-10 rounded-full border border-gray-300 bg-white shadow-sm flex items-center justify-center hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- FOURTH BLOCK: All Reviews List --}}
    <div>
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-4">
            <h3 class="text-lg font-bold text-gray-900">Semua ulasan ({{ number_format($totalReviews) }})</h3>
            @auth
                @if(!$userHasReviewed)
                    <button @click="showReviewModal = true" class="bg-[#002f20] hover:bg-[#001e14] text-white font-bold py-2 px-4 rounded-full flex items-center gap-2 text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        Tulis ulasan
                    </button>
                @endif
            @endauth
        </div>
        
        <p class="text-xs text-gray-500 mb-6">Ulasan merupakan opini subjektif dari wisatawan anggota komunitas Visit Sukabumi. Kami melakukan verifikasi untuk memastikan ulasan tetap informatif dan terpercaya.</p>

        {{-- Filters (Dummy) --}}
        <div class="flex flex-wrap items-center gap-3 mb-6">
            <button class="flex items-center gap-2 px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-semibold text-gray-900 hover:bg-gray-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter (0)
            </button>
            <div class="flex items-center px-4 py-2 bg-white border border-gray-300 rounded-full text-sm font-semibold text-gray-900 hover:bg-gray-50 cursor-pointer">
                Urutkan: Terbaru
                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
            </div>
            <div class="relative flex-1 min-w-[200px]">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" placeholder="Cari ulasan..." class="w-full pl-9 pr-4 py-2 bg-white border border-gray-300 rounded-full text-sm focus:ring-[#002f20] focus:border-[#002f20] transition-colors">
            </div>
        </div>

        {{-- Popular Mentions (Dummy) --}}
        <div class="mb-8">
            <h4 class="text-sm font-bold text-gray-900 mb-3">Sering disebut</h4>
            <div class="flex flex-wrap gap-2">
                @foreach(['Pemandangan', 'Pemandu lokal', 'Suasana', 'Terjangkau', 'Bersih', 'Wajib dikunjungi', 'Budaya', 'Wisata alam', 'Hidden gem', 'Keluarga'] as $tag)
                <span class="px-3 py-1.5 border border-gray-200 rounded-full text-sm text-gray-700 bg-white hover:bg-gray-50 cursor-pointer transition-colors">{{ $tag }}</span>
                @endforeach
            </div>
        </div>

        {{-- Actual Reviews --}}
        @if($reviews->count() > 0)
            <div class="space-y-6">
                @foreach($reviews as $review)
                <div class="bg-white border border-gray-200 rounded-xl p-5 md:p-6 shadow-sm">
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-full bg-gray-200 overflow-hidden flex items-center justify-center flex-shrink-0 border border-gray-200">
                                @if($review->user && $review->user->profile_photo_url)
                                    <img src="{{ $review->user->profile_photo_url }}" class="w-full h-full object-cover">
                                @else
                                    <span class="font-bold text-gray-500 text-lg">{{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}</span>
                                @endif
                            </div>
                            <div>
                                <div class="font-bold text-gray-900 text-[15px]">{{ $review->user->name ?? 'Anonim' }}</div>
                                <div class="text-xs text-gray-500">Sukabumi, Indonesia • {{ rand(1, 15) }} ulasan</div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button class="text-gray-400 hover:text-gray-900"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"/></svg></button>
                            <button class="text-gray-400 hover:text-gray-900"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0zm7 0a1 1 0 11-2 0 1 1 0 012 0z"/></svg></button>
                        </div>
                    </div>

                    <div class="flex items-center gap-1 mb-2 text-[#00aa6c]">
                        @for($i=1; $i<=5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endfor
                    </div>

                    <h4 class="font-bold text-gray-900 mb-1">Pengalaman luar biasa!</h4>
                    <div class="text-xs text-gray-500 mb-3 font-medium">
                        {{ $review->created_at->translatedFormat('M Y') }} 
                        @if($review->visit_type)
                            • {{ $review->visit_type }}
                        @endif
                    </div>

                    <p class="text-[15px] text-gray-800 leading-relaxed">{{ $review->content }}</p>

                    @if($review->image_path)
                        <div class="mt-4">
                            <img src="{{ Storage::url($review->image_path) }}" class="rounded-lg max-h-48 object-cover border border-gray-200">
                        </div>
                    @endif
                    <div class="mt-4 text-xs text-gray-500">Ditulis pada {{ $review->created_at->translatedFormat('d F Y') }}</div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-12 border border-gray-200 rounded-xl bg-gray-50">
                <h4 class="font-bold text-gray-900 mb-2">Belum ada ulasan</h4>
                <p class="text-gray-500 text-sm">Jadilah yang pertama membagikan pengalaman Anda!</p>
            </div>
        @endif
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
                <button @click="showReviewModal = false" class="text-gray-400 hover:text-gray-900 p-1 rounded-full hover:bg-gray-100 transition-colors">
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
    // Review Star Rating Logic inside Modal
    function setModalRating(rating) {
        document.getElementById('modal-rating-input').value = rating;
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
