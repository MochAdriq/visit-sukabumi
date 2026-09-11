@extends('layouts.app')

@section('title', $post->title . ' — Visit Sukabumi')
@section('meta_description', Str::limit(strip_tags($post->content), 150))

@section('content')
<div class="min-h-screen bg-gray-50 font-sans text-gray-900 pb-16">
    @include('components.navbar')

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
            
            <div class="flex flex-wrap items-center justify-center md:justify-start gap-4 text-sm text-gray-500">
                <div class="flex items-center gap-1.5">
                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    Diterbitkan {{ $post->published_at->format('d M Y') }}
                </div>
                @if($post->author)
                    <div class="flex items-center gap-1.5 border-l border-gray-200 pl-4">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Oleh <span class="font-bold text-gray-700">{{ $post->author->name }}</span>
                    </div>
                @endif
            </div>
        </header>

        {{-- Featured Image --}}
        @if($post->image_path)
            <div class="mb-12 rounded-2xl overflow-hidden shadow-lg border border-gray-100 bg-white">
                <img src="{{ Storage::url($post->image_path) }}" alt="{{ $post->title }}" class="w-full h-auto max-h-[500px] object-cover">
            </div>
        @endif

        {{-- Main Content --}}
        <article class="prose prose-lg md:prose-xl max-w-none prose-img:rounded-2xl prose-img:shadow-md prose-headings:font-extrabold prose-a:text-[#1a6bbf] hover:prose-a:text-[#135a9e] prose-p:text-gray-700 leading-relaxed bg-white p-8 md:p-12 rounded-3xl shadow-sm border border-gray-100 mb-16">
            {!! $post->content !!}
        </article>

        {{-- Back to list --}}
        <div class="mb-16">
            <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white border border-gray-200 rounded-full font-bold text-gray-700 hover:bg-gray-50 hover:text-[#1a6bbf] hover:border-gray-300 transition-all shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                Kembali ke Daftar Artikel
            </a>
        </div>

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
@endsection
