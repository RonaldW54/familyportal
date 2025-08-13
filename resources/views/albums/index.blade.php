<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meine Sammlungen (Alben)
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <div class="lg:col-span-1">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Neue Sammlung erstellen</h3>
                    <form method="POST" action="{{ route('albums.store') }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="title" value="Titel" />
                            <x-text-input type="text" name="title" id="title" class="mt-1 block w-full" required />
                        </div>
                        <div class="mb-4">
                            <x-input-label for="description" value="Beschreibung" />
                            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="4"></textarea>
                        </div>
                        <x-primary-button>Erstellen</x-primary-button>
                    </form>
                </div>
            </div>
            <div class="lg:col-span-2">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <h3 class="text-lg font-semibold mb-4">Bestehende Sammlungen</h3>
                    @if(session('success'))
                        <div class="mb-4 p-4 text-sm text-green-700 bg-green-100 rounded-lg">
                            {{ session('success') }}
                        </div>
                    @endif
                    @forelse($albums as $album)
        <a href="{{ route('albums.show', $album) }}" class="block p-6 bg-white border border-gray-200 rounded-lg shadow hover:bg-gray-100 transition">
            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900">{{ $album->title }}</h5>
            <p class="font-normal text-gray-700 mb-4">{{ Str::limit($album->description, 100) }}</p>
            <span class="text-xs text-gray-500">{{ $album->media()->count() }} Bilder</span>
        </a>
    @empty
        <div class="col-span-full text-center py-12">
            <p class="text-gray-500">Sie haben noch keine Alben erstellt.</p>
        </div>
    @endforelse
                </div>
            </div>
        </div>
    </div>
</x-app-layout>