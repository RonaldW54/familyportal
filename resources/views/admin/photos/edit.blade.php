<x-admin-layout>
    <x-slot name="header">
        Foto bearbeiten (Admin-Ansicht)
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        {{-- Linke Spalte: Bild und Admin-Aktionen --}}
        <div class="lg:col-span-1 space-y-4">
            <img src="{{ $media->getUrl() }}" alt="Vorschau" class="rounded-lg shadow-md w-full">
            
            {{-- Formular zum Ändern des Besitzers --}}
            <div class="p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <h3 class="font-semibold text-gray-800">Besitzrecht übertragen</h3>
                <p class="text-xs text-gray-600 mt-1">Aktueller Besitzer: <strong>{{ $media->model->name }}</strong></p>

                <form method="POST" action="{{ route('admin.photos.manage.reassign', $media) }}" class="mt-4">
                    @csrf
                    <label for="new_owner_id" class="block text-sm font-medium text-gray-700">Neuer Besitzer:</label>
                    <select name="new_owner_id" id="new_owner_id" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm">
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" @if($user->id === $media->model_id) selected @endif>
                                {{ $user->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="mt-4 w-full inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700">
                        Besitz übertragen
                    </button>
                </form>
            </div>
        </div>

        {{-- Rechte Spalte: Normales Bearbeitungsformular --}}
        <div class="lg:col-span-2">
            <div class="bg-white p-6 rounded-lg shadow-md">
                <h3 class="font-semibold text-lg mb-4">Metadaten bearbeiten</h3>
                {{-- Wichtig: Das action-Attribut zeigt auf die Admin-Update-Route --}}
                <form method="POST" action="{{ route('admin.photos.manage.update', $media) }}" class="space-y-4">
                    @csrf
                    @method('PATCH')

                    {{-- Hier können Sie die exakt gleichen Formularfelder wie in der normalen
                         'photos.edit.blade.php' einfügen (Beschreibung, Datum, Ort,
                         Tags, Alben, Freigaben etc.), damit der Admin alles ändern kann. --}}

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Beschreibung</label>
                        <textarea name="description" id="description" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ $media->getCustomProperty('description') }}</textarea>
                    </div>

                    {{-- ... weitere Felder hier einfügen ... --}}

                    <div class="flex justify-end">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                            Änderungen speichern
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-admin-layout>