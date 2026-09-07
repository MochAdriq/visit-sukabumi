@props(['place'])

@php
    // Basic array of Unsplash IDs to act as beautiful placeholders
    $randomIds = [
        'wisata-alam' => ['1542662565-7e4fd1e56993', '1596404554311-66774e50ebec', '1448375240586-882707db888b', '1610486001224-b0402b8552fc'],
        'wisata-pantai' => ['1507525428034-b723cf961d3e', '1506905925346-21bda4d32df4'],
        'kuliner' => ['1555939594-58d7cb561ad1', '1565299624946-b28f40a0ae38', '1512621776951-a57141f2eefd'],
        'hotel-resort' => ['1566073771259-6a8506099945', '1582719508461-89dac9aa45ce'],
    ];
    $catSlug = $place->category ? $place->category->slug : 'wisata-alam';
    $catImages = $randomIds[$catSlug] ?? ['1610486001224-b0402b8552fc', '1542662565-7e4fd1e56993'];
    $randomImageId = $catImages[$place->id % count($catImages)];
    
    $fallbackImage = "https://images.unsplash.com/photo-{$randomImageId}?q=80&w=640&h=480&fit=crop";
    $image = $place->primaryImage ? Storage::url($place->primaryImage->image_path) : $fallbackImage;
    
    // Assign a badge dynamically just for demo
    $badges = ['Top Rated', 'Special offer', 'An itinerary essential', 'Popular', 'Staff Pick'];
    $badge = $badges[$place->id % count($badges)];
@endphp

<a href="{{ route('place.show', $place->slug) }}" class="group relative block h-80 overflow-hidden bg-gray-900 rounded-xl shadow-md cursor-pointer">
    @if($place->id % 3 !== 0) <!-- Randomly show badge -->
        <span class="absolute top-4 left-0 bg-[#f9a826] text-gray-900 text-[12px] font-bold px-3 py-1 z-20 rounded-r-md shadow-sm">{{ $badge }}</span>
    @endif
    
    <img alt="{{ $place->name }}" src="{{ $image }}" class="absolute inset-0 h-full w-full object-cover transition-transform duration-700 group-hover:scale-110"/>
    
    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent opacity-80 group-hover:opacity-100 transition-opacity duration-300"></div>
    
    <div class="absolute inset-x-0 bottom-0 p-5 z-10 flex flex-col justify-end">
        <h3 class="text-xl font-bold text-white group-hover:underline decoration-2 underline-offset-4 transition-all duration-300">{{ $place->name }}</h3>
        <div class="max-h-0 opacity-0 overflow-hidden transition-all duration-500 ease-in-out group-hover:max-h-24 group-hover:opacity-100 group-hover:mt-2">
            <p class="text-[13px] text-gray-200 line-clamp-3">
                {{ $place->description }}
            </p>
        </div>
    </div>
</a>
