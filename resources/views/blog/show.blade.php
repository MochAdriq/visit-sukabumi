@extends('layouts.app')

@section('title', $post->title . ' — Visit Sukabumi')
@section('meta_description', Str::limit(strip_tags($post->content), 150))

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16 relative">
    @include('components.navbar')

    {{-- Floating Back to Top Button --}}
    <div x-data="{ showTopBtn: false }" 
         @scroll.window="showTopBtn = (window.pageYOffset > 300)"
         class="fixed bottom-6 right-6 md:bottom-8 md:right-8 z-40">
        <button 
            x-show="showTopBtn" 
            x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 translate-y-4 scale-90"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-4 scale-90"
            @click="window.scrollTo({ top: 0, behavior: 'smooth' })"
            type="button"
            aria-label="Scroll ke atas"
            title="Kembali ke atas"
            class="w-12 h-12 rounded-full bg-white/95 backdrop-blur-md shadow-xl border border-gray-200/80 text-gray-700 hover:text-white hover:bg-[#1a6bbf] hover:border-[#1a6bbf] transition-all duration-300 flex items-center justify-center cursor-pointer group hover:scale-105 active:scale-95">
            <svg class="w-6 h-6 transition-transform group-hover:-translate-y-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"/>
            </svg>
        </button>
    </div>

    <main class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8 md:py-12">
        
        {{-- Breadcrumb & Category --}}
        <div class="flex items-center gap-3 text-sm text-gray-500 mb-6 font-medium">
            <a href="/" class="hover:text-[#1a6bbf] transition-colors">Beranda</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <a href="{{ route('blog.index') }}" class="hover:text-[#1a6bbf] transition-colors">Blog</a>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            <span class="text-[#00aa6c] font-bold">{{ $post->category }}</span>
        </div>

        {{-- Header Section --}}
        <header class="mb-10 text-center md:text-left">
            <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-6">
                {{ $post->title }}
            </h1>
            
            <div class="flex flex-wrap items-center justify-between gap-4 text-sm text-gray-500">
                <div class="flex flex-wrap items-center gap-4">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        Diterbitkan {{ $post->published_at ? $post->published_at->format('d M Y') : 'Draft' }}
                    </div>
                    @if($post->author_display_name)
                        <div class="flex items-center gap-1.5 border-l border-gray-200 pl-4">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Oleh <span class="font-bold text-gray-700">{{ $post->author_display_name }}</span>
                        </div>
                    @endif
                </div>

                <x-share-modal 
                    :title="$post->title" 
                    :text="'Baca artikel menarik: ' . $post->title . ' di Visit Sukabumi! ' . Str::limit(strip_tags($post->content), 120)" 
                    :url="route('blog.show', $post->slug)" 
                    :image="$post->image_path ? Storage::url($post->image_path) : null"
                    :category="$post->category"
                    button-class="flex items-center px-4 py-1.5 border border-gray-300 rounded-full hover:bg-gray-100 font-bold text-xs transition gap-2 text-gray-700 shadow-xs"
                />
            </div>
        </header>

        {{-- Featured Image --}}
        @if($post->image_path)
            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-white">
                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>
        @endif

        {{-- Main Content --}}
        <article class="article-body bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 mb-16">
            {!! $post->content !!}
        </article>

        {{-- Actions: Back & Share --}}
        <div class="mb-16 flex flex-wrap items-center justify-between gap-4">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-full font-bold text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] hover:border-gray-300 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Artikel
            </a>

            <div class="flex items-center gap-3">
                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider hidden sm:inline">Suka artikel ini?</span>
                <x-share-modal 
                    :title="$post->title" 
                    :text="'Baca artikel menarik: ' . $post->title . ' di Visit Sukabumi! ' . Str::limit(strip_tags($post->content), 120)" 
                    :url="route('blog.show', $post->slug)" 
                    :image="$post->image_path ? Storage::url($post->image_path) : null"
                    :category="$post->category"
                    button-class="flex items-center px-5 py-2.5 bg-[#00aa6c] text-white hover:bg-[#008f5a] font-bold text-sm rounded-full transition gap-2 shadow-xs"
                    button-text="Bagikan Artikel"
                />
            </div>
        </div>

        {{-- Connected Destinations Section --}}
        @if($post->places && $post->places->count() > 0)
            <section class="mb-16 pt-8 border-t border-gray-200" 
                x-data="{
                    canScrollLeft: false,
                    canScrollRight: true,
                    checkScroll() {
                        const el = this.$refs.placeSlider;
                        if (!el) return;
                        this.canScrollLeft = el.scrollLeft > 10;
                        this.canScrollRight = el.scrollLeft < (el.scrollWidth - el.clientWidth - 10);
                    },
                    scrollLeft() {
                        const el = this.$refs.placeSlider;
                        const card = el.querySelector('.place-slider-item');
                        const step = card ? card.offsetWidth + 20 : 280;
                        el.scrollBy({ left: -step, behavior: 'smooth' });
                    },
                    scrollRight() {
                        const el = this.$refs.placeSlider;
                        const card = el.querySelector('.place-slider-item');
                        const step = card ? card.offsetWidth + 20 : 280;
                        el.scrollBy({ left: step, behavior: 'smooth' });
                    }
                }"
                x-init="$nextTick(() => checkScroll())">
                
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl md:text-3xl font-extrabold text-gray-900 tracking-tight">Daftar Destinasi</h2>
                        <p class="text-sm md:text-base text-gray-500 mt-1">
                            {{ $post->places->count() }} tempat ditemukan.
                        </p>
                    </div>

                    @if($post->places->count() > 3)
                        {{-- Navigation Arrows in Header (Pure SVG) --}}
                        <div class="flex items-center gap-2">
                            <button 
                                @click="scrollLeft()"
                                :disabled="!canScrollLeft"
                                :class="{ 'opacity-40 cursor-not-allowed': !canScrollLeft, 'hover:bg-[#1a6bbf] hover:text-white hover:border-[#1a6bbf] cursor-pointer': canScrollLeft }"
                                type="button" 
                                aria-label="Geser ke kiri"
                                title="Geser ke kiri"
                                class="w-10 h-10 rounded-full border border-gray-200 bg-white shadow-xs flex items-center justify-center text-gray-700 transition-all group active:scale-95">
                                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                                </svg>
                            </button>
                            <button 
                                @click="scrollRight()"
                                :disabled="!canScrollRight"
                                :class="{ 'opacity-40 cursor-not-allowed': !canScrollRight, 'hover:bg-[#1a6bbf] hover:text-white hover:border-[#1a6bbf] cursor-pointer': canScrollRight }"
                                type="button" 
                                aria-label="Geser ke kanan"
                                title="Geser ke kanan"
                                class="w-10 h-10 rounded-full border border-gray-200 bg-white shadow-xs flex items-center justify-center text-gray-700 transition-all group active:scale-95">
                                <svg class="w-5 h-5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Relative Slider Container with Floating Overlay Arrows --}}
                <div class="relative group/slider">
                    @if($post->places->count() > 3)
                        {{-- Floating Left Arrow on Card Edge --}}
                        <button 
                            @click="scrollLeft()"
                            x-show="canScrollLeft"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 -translate-x-2"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 -translate-x-2"
                            type="button"
                            aria-label="Geser ke kiri"
                            class="hidden md:flex absolute -left-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/95 backdrop-blur-sm shadow-xl border border-gray-200 text-gray-700 hover:bg-[#1a6bbf] hover:text-white hover:border-[#1a6bbf] items-center justify-center transition-all cursor-pointer hover:scale-110 active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>

                        {{-- Floating Right Arrow on Card Edge --}}
                        <button 
                            @click="scrollRight()"
                            x-show="canScrollRight"
                            x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-x-2"
                            x-transition:enter-end="opacity-100 translate-x-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-x-0"
                            x-transition:leave-end="opacity-0 translate-x-2"
                            type="button"
                            aria-label="Geser ke kanan"
                            class="hidden md:flex absolute -right-5 top-1/2 -translate-y-1/2 z-20 w-11 h-11 rounded-full bg-white/95 backdrop-blur-sm shadow-xl border border-gray-200 text-gray-700 hover:bg-[#1a6bbf] hover:text-white hover:border-[#1a6bbf] items-center justify-center transition-all cursor-pointer hover:scale-110 active:scale-95">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>
                    @endif

                    <div 
                        x-ref="placeSlider"
                        @scroll.debounce.50ms="checkScroll()"
                        class="flex gap-5 overflow-x-auto scroll-smooth pb-4 pt-1 snap-x snap-mandatory [-ms-overflow-style:none] [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                        @foreach($post->places as $place)
                            <div class="place-slider-item w-[85%] sm:w-[calc((100%-20px)/2)] md:w-[calc((100%-40px)/3)] flex-shrink-0 snap-start flex flex-col h-full">
                                <x-place-card-grid :place="$place" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif

        {{-- Comments Section --}}
        <section id="comments" class="mb-16 pt-8 border-t border-gray-200">
            <div class="flex items-center justify-between mb-8">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-blue-50 text-[#1a6bbf] flex items-center justify-center flex-shrink-0">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight">Komentar</h3>
                        <p class="text-xs md:text-sm text-gray-500">{{ $post->comments ? $post->comments->count() : 0 }} komentar pada artikel ini</p>
                    </div>
                </div>
            </div>

            {{-- Success Alert --}}
            @if(session('comment_success'))
                <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 rounded-2xl text-emerald-800 flex items-center gap-3 text-sm">
                    <svg class="w-5 h-5 text-emerald-600 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span>{{ session('comment_success') }}</span>
                </div>
            @endif

            {{-- Comment Form Card --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 shadow-sm border border-gray-100 mb-10">
                <h4 class="text-base font-bold text-gray-900 mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-[#00aa6c]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Tinggalkan Komentar
                </h4>

                <form action="{{ route('blog.comment.store', $post->slug) }}" method="POST">
                    @csrf

                    @auth
                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-2xl mb-4 border border-gray-100">
                            <div class="w-9 h-9 rounded-full bg-[#1a6bbf] text-white flex items-center justify-center font-bold text-sm">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <div class="text-sm">
                                <span class="text-gray-500">Berkomentar sebagai</span>
                                <span class="font-bold text-gray-800 ml-1">{{ auth()->user()->name }}</span>
                            </div>
                        </div>
                    @else
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="name" required value="{{ old('name') }}" placeholder="Contoh: Budi Pratama"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none text-sm transition">
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Email (Opsional)</label>
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="alamat@email.com"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none text-sm transition">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @endauth

                    <div class="mb-4">
                        <label class="block text-xs font-bold text-gray-700 uppercase tracking-wider mb-1.5">Isi Komentar <span class="text-red-500">*</span></label>
                        <textarea name="comment" rows="4" required placeholder="Tuliskan pendapat, tanggapan, atau pertanyaan Anda tentang artikel ini..."
                            class="w-full p-4 rounded-2xl border border-gray-200 focus:border-[#1a6bbf] focus:ring-2 focus:ring-[#1a6bbf]/20 outline-none text-sm transition resize-y">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center justify-between">
                        @guest
                            <p class="text-xs text-gray-500">
                                Punya akun? <a href="{{ route('login') }}" class="text-[#1a6bbf] font-bold hover:underline">Masuk</a>
                            </p>
                        @else
                            <div></div>
                        @endguest

                        <button type="submit" class="inline-flex items-center gap-2 px-6 py-2.5 bg-[#1a6bbf] text-white font-bold text-sm rounded-full hover:bg-[#1559a3] transition shadow-sm hover:shadow active:scale-95 cursor-pointer">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                            </svg>
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>

            {{-- Comments List --}}
            @if($post->comments && $post->comments->count() > 0)
                <div class="space-y-4">
                    @foreach($post->comments as $c)
                        <div class="bg-white rounded-2xl p-6 shadow-xs border border-gray-100">
                            <div class="flex items-start justify-between gap-4 mb-3">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full {{ $c->is_admin ? 'bg-[#1a6bbf] text-white ring-2 ring-blue-200' : 'bg-gradient-to-br from-emerald-500 to-teal-600 text-white' }} flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-xs">
                                        {{ $c->author_initials }}
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-bold text-gray-900 text-sm md:text-base">{{ $c->author_name }}</span>
                                            @if($c->is_admin)
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-extrabold bg-blue-100 text-[#1a6bbf] border border-blue-200 uppercase tracking-wider">
                                                    Admin
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs text-gray-400 font-medium">
                                            {{ $c->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm text-gray-700 leading-relaxed whitespace-pre-line pl-0 md:pl-13">
                                {{ $c->comment }}
                            </p>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-2xl p-8 border border-dashed border-gray-200 text-center">
                    <div class="w-12 h-12 rounded-full bg-gray-50 text-gray-400 flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                    <p class="font-bold text-gray-700 text-sm">Belum Ada Komentar</p>
                    <p class="text-xs text-gray-500 mt-1">Jadilah yang pertama memberikan tanggapan untuk artikel ini!</p>
                </div>
            @endif
        </section>

        {{-- Related Posts --}}
        @if($related->count() > 0)
            <div class="border-t border-gray-200 pt-12">
                <h3 class="text-2xl font-bold text-gray-900 mb-8">Artikel Terkait</h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @foreach($related as $rPost)
                        <a href="{{ route('blog.show', $rPost->slug) }}" class="group block bg-white rounded-2xl overflow-hidden border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300">
                            @if($rPost->image_path)
                                <div class="aspect-[16/10] overflow-hidden bg-gray-100">
                                    <img src="{{ Storage::url($rPost->image_path) }}" alt="{{ $rPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                </div>
                            @endif
                            <div class="p-5">
                                <div class="text-xs text-[#00aa6c] font-bold mb-2">{{ $rPost->category }}</div>
                                <h4 class="font-bold text-gray-900 group-hover:text-[#1a6bbf] leading-snug line-clamp-2 transition-colors">
                                    {{ $rPost->title }}
                                </h4>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </main>
</div>
@include('components.footer')
@endsection

