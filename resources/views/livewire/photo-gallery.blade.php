<div x-data="{ filterOpen: false }" @filters-applied.window="filterOpen = false">
    {{-- Sticky Controlbar --}}
    <div class="sticky top-[4.1rem] z-30 bg-gray-100/75 backdrop-blur-sm border-b border-gray-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-end items-center h-16 gap-4">
                <a href="{{ route($mode === 'mine' ? 'photos.index' : 'photos.shared', array_merge(request()->query(), ['view' => 'slideshow'])) }}" class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700">
                    Slideshow starten
                </a>
                <button @click.prevent="filterOpen = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                    Filter & Ansicht
                </button>
            </div>
        </div>
    </div>

    {{-- Filter-Popup --}}
    <div x-show="filterOpen" x-transition class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex justify-center items-center p-4" style="display: none;">
        <div @click.away="filterOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-xl p-6">
            <h3 class="text-lg font-bold mb-6">Anzeige filtern und anpassen</h3>
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ansichtsmodus</label>
                    <div class="flex items-center gap-4">
                        {{-- HIER IST .live ENTFERNT --}}
                        <label class="flex items-center cursor-pointer"><input type="radio" wire:model="view" value="grid" class="h-4 w-4 text-indigo-600"> <span class="ml-2">Matrix</span></label>
                        <label class="flex items-center cursor-pointer"><input type="radio" wire:model="view" value="list" class="h-4 w-4 text-indigo-600"> <span class="ml-2">Liste</span></label>
                    </div>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t pt-6">
                    <div>
                        <label for="filter-select" class="block text-sm font-medium text-gray-700">Hauptfilter</label>
                        <select wire:model="filter" id="filter-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            <option value="">-- Alle Bilder --</option>
                            <option value="no-album">Bilder ohne Album</option>
                            <option value="by-album">Nach Album filtern</option>
                        </select>
                    </div>
                    <div>
                        <label for="album-select" class="block text-sm font-medium text-gray-700">Album</label>
                        <select wire:model="albumId" id="album-select" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" @if($filter !== 'by-album') disabled @endif>
                            <option value="">-- Album wählen --</option>
                            @foreach($userAlbums as $album)
                                <option value="{{ $album->id }}">{{ $album->title }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="person-input" class="block text-sm font-medium text-gray-700">Abgebildete Person</label>
                        {{-- KEIN debounce mehr nötig --}}
                        <input type="text" wire:model="person" id="person-input" placeholder="Namen der Person eingeben..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                    </div>
                </div>
            </div>
            {{-- NEU: Die Button-Leiste --}}
            <div class="mt-8 flex justify-between items-center">
                <button type="button" wire:click="resetFilters" class="text-sm text-gray-600 underline hover:text-gray-900">Zurücksetzen</button>
                <div class="flex items-center gap-4">
                    <button @click="filterOpen = false" type="button" class="px-4 py-2 bg-gray-200 text-gray-800 rounded-md text-sm font-medium hover:bg-gray-300">Abbrechen</button>
                    <button type="button" wire:click="applyFilters" class="px-4 py-2 bg-indigo-600 text-white rounded-md text-sm font-medium">Anwenden</button>
                </div>
            </div>
        </div>
    </div>

    {{-- Bilderanzeige (bleibt unverändert) --}}
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6 pb-12">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
            @if($photos->count() > 0)
                @if($view == 'list')
                    {{-- ... Listenansicht-Code hier ... --}}
                @else
                    {{-- ... Matrixansicht-Code hier ... --}}
                @endif
                <div class="mt-8">{{ $photos->links() }}</div>
            @else
                <div class="text-center p-10"><p>Keine Bilder gefunden...</p></div>
            @endif
        </div>
    </div>
</div>