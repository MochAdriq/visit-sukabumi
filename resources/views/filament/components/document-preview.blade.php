@php
    $filePath = $getState();
    $extension = $filePath ? strtolower(pathinfo($filePath, PATHINFO_EXTENSION)) : '';
    $isImage = in_array($extension, ['jpg', 'jpeg', 'png', 'webp', 'svg']);
    $url = $filePath ? Storage::url($filePath) : null;
@endphp

<div class="py-2">
    @if($url)
        @if($isImage)
            <div class="relative group rounded-xl overflow-hidden border border-gray-200 bg-gray-50 max-w-sm">
                <img src="{{ $url }}" alt="Dokumen Preview" class="w-full h-48 object-cover rounded-lg shadow-sm transition group-hover:scale-105 duration-300">
                <div class="p-3 bg-white flex items-center justify-between border-t border-gray-100">
                    <span class="text-xs text-gray-500 truncate max-w-[180px]">{{ basename($filePath) }}</span>
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                        </svg>
                        Buka Dokumen
                    </a>
                </div>
            </div>
        @else
            <div class="flex items-center justify-between p-4 rounded-xl border border-gray-200 bg-gray-50 max-w-sm">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-xs font-semibold text-gray-800 truncate max-w-[160px]">{{ basename($filePath) }}</p>
                        <p class="text-[10px] text-gray-500 uppercase">{{ $extension ?: 'FILE' }}</p>
                    </div>
                </div>
                <a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg text-xs font-semibold text-blue-600 bg-blue-50 hover:bg-blue-100 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                    </svg>
                    Unduh
                </a>
            </div>
        @endif
    @else
        <div class="text-xs text-gray-400 italic py-2 flex items-center gap-1.5">
            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
            Dokumen belum diunggah atau tidak ditemukan
        </div>
    @endif
</div>
