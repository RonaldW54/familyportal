<x-app-layout>
    <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Unbearbeitete Fotos
    </h2>
</x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(session('success'))
                <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                    {{ session('success') }}
                </div>
            @endif
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if($photos->count() > 0)
                        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                            @foreach($photos as $photo)
                                <a href="{{ route('photos.edit', $photo) }}" class="block group">
                                <div class="overflow-hidden rounded-md">
                                <img src="{{ $photo->getUrl() }}" 
                                alt="{{ $photo->getCustomProperty('description') }}" 
                                class="w-full h-auto object-cover aspect-square transition-transform duration-300 group-hover:scale-110">
                                </div>
                                <p class="text-sm mt-2 truncate">{{ $photo->getCustomProperty('description') ?? 'Ohne Beschreibung' }}</p>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <p>Super! Alle deine Fotos sind auf dem neuesten Stand.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>