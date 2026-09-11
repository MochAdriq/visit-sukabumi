@props(['event'])

@php
    $fallbackImage = asset('assets/images/10.jpg');
    $image = $event->image_path ? Storage::url($event->image_path) : $fallbackImage;
    $rating = $event->reviews_avg_rating ?? 0;
    $fullBubbles = floor($rating);
    $halfBubble = ($rating - $fullBubbles) >= 0.5;
@endphp

<div class="group flex flex-col md:flex-row bg-white rounded-xl border border-gray-200 overflow-hidden hover:shadow-lg transition-shadow duration-300">
    {{-- Image Section --}}
    <div class="relative w-full md:w-64 h-56 md:h-auto flex-shrink-0 cursor-pointer overflow-hidden">
        <a href="{{ route('event.show', $event->slug) }}" class="block w-full h-full relative">
            <img alt="{{ $event->title }}" src="{{ $image }}" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-105"/>
            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
            <div class="absolute top-3 left-3 bg-white rounded-lg px-2 py-1 text-center shadow">
                <div class="text-[10px] font-black text-red-500 uppercase">{{ $event->start_date->translatedFormat('M') }}</div>
                <div class="text-xl font-black text-gray-900 leading-none">{{ $event->start_date->format('d') }}</div>
            </div>
        </a>
    </div>

    {{-- Content Section --}}
    <div class="flex-1 p-4 md:p-5 flex flex-col justify-between">
        <div>
            {{-- Title --}}
            <div class="flex justify-between items-start mb-1">
                <a href="{{ route('event.show', $event->slug) }}" class="text-xl font-bold text-gray-900 hover:underline">
                    {{ $event->title }}
                </a>
            </div>

            {{-- Rating Stars --}}
            <div class="flex items-center gap-1.5 mb-3">
                <div class="flex items-center gap-0.5">
                    @for($i = 1; $i <= 5; $i++)
                        @if($i <= $fullBubbles)
                            <svg class="w-4 h-4 text-[#00aa6c] fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @elseif($i == $fullBubbles + 1 && $halfBubble)
                            {{-- Half star --}}
                            <svg class="w-4 h-4 text-[#00aa6c]" viewBox="0 0 20 20">
                                <path fill="currentColor" d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" opacity="0.5"/>
                            </svg>
                        @else
                            <svg class="w-4 h-4 text-gray-300 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        @endif
                    @endfor
                </div>
                <span class="text-sm text-gray-500 font-medium">{{ $event->reviews_count ?? 0 }} ulasan</span>
            </div>

            {{-- Meta info (Location & Date Range) --}}
            <div class="flex flex-wrap items-center gap-2 text-sm text-gray-600 mb-3">
                @if($event->location_name)
                    <span class="flex items-center gap-1 font-medium text-gray-800">
                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        {{ $event->location_name }}
                    </span>
                @endif
                <span class="text-gray-300">•</span>
                <span class="flex items-center gap-1 text-gray-600">
                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    {{ $event->start_date->translatedFormat('d M') }} 
                    @if($event->end_date && $event->end_date->format('Y-m-d') !== $event->start_date->format('Y-m-d'))
                        - {{ $event->end_date->translatedFormat('d M Y') }}
                    @else
                        {{ $event->start_date->translatedFormat('Y') }}
                    @endif
                </span>
            </div>

            {{-- Description Snippet --}}
            <p class="text-sm text-gray-600 line-clamp-2 leading-relaxed">
                {{ strip_tags($event->description) }}
            </p>
        </div>

        {{-- Action Button --}}
        <div class="mt-4 flex justify-end">
            <a href="{{ route('event.show', $event->slug) }}" class="inline-flex items-center text-sm font-bold text-[#1a6bbf] hover:text-[#145299] group/link">
                Detail Acara
                <svg class="w-4 h-4 ml-1 transform group-hover/link:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                </svg>
            </a>
        </div>
    </div>
</div>
