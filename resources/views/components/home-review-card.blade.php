<div class="bg-white rounded-2xl p-6 shadow-[0_4px_20px_rgb(0,0,0,0.03)] border border-gray-100 flex flex-col h-auto transition-transform hover:scale-[1.02] cursor-default">
    <div class="flex items-center text-[#f9a826] mb-3">
        @for($i=1; $i<=5; $i++)
            <svg class="w-4 h-4 {{ $i <= $review->rating ? 'fill-current' : 'text-gray-200 fill-current' }}" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
        @endfor
    </div>
    <p class="text-[14px] text-gray-700 leading-relaxed italic mb-5 flex-1">"{{ $review->content }}"</p>
    <div class="flex items-center gap-3 pt-4 border-t border-gray-100 mt-auto">
        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-[#1a6bbf] to-[#0f407a] text-white flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-inner">
            {{ strtoupper(substr($review->user->name ?? 'A', 0, 1)) }}
        </div>
        <div>
            <div class="text-[13px] font-bold text-gray-900 leading-tight">{{ $review->user->name ?? 'Anonim' }}</div>
            @if($review->place)
                <a href="{{ route('place.show', $review->place->slug) }}" class="text-[12px] text-[#1a6bbf] hover:underline leading-tight block mt-0.5">{{ $review->place->name }}</a>
            @elseif($review->event)
                <a href="{{ route('event.show', $review->event->slug) }}" class="text-[12px] text-[#00aa6c] hover:underline leading-tight block mt-0.5">{{ $review->event->title }}</a>
            @else
                <span class="text-[12px] text-gray-500 leading-tight block mt-0.5">Sukabumi</span>
            @endif
        </div>
    </div>
</div>
