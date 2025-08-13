<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Neues Foto hochladen</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <form method="POST" action="{{ route('photos.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="mt-4">
                            <x-input-label for="album_id" :value="__('Einem Album zuweisen (optional)')" />
                                <select name="album_id" id="album_id" class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                                <option value="">-- Kein Album --</option>
                                @foreach($albums as $album)
                                    <option value="{{ $album->id }}">{{ $album->title }}</option>
                                @endforeach
                                </select>
                        </div>
                        <div class="mb-4">
                            <x-input-label for="photo" value="Foto auswählen (max. 20MB)" />
                            <input type="file" name="photo" id="photo" class="mt-1 block w-full" required>
                            <x-input-error :messages="$errors->get('photo')" class="mt-2" />
                        </div>
                        
                        <div class="mb-4">
                            <x-input-label for="description" value="Beschreibung (optional)" />
                            <textarea name="description" id="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3">{{ old('description') }}</textarea>
                        </div>

                        <div class="mb-4">
                            <x-input-label for="photo_date" value="Aufnahmedatum (optional)" />
                            <input type="date" name="photo_date" id="photo_date" value="{{ old('photo_date') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <x-primary-button>Hochladen</x-primary-button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>