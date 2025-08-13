<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Foto-Details bearbeiten
        </h2>
    </x-slot>

    <div class="py-12" x-data="photoEditPage()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- LINKE SPALTE: Bild-Vorschau und Aktionen --}}
                <div class="lg:col-span-1 space-y-4">
                    <div class="sticky top-24">
                        <img src="{{ $media->getUrl() }}?v={{ $media->updated_at->timestamp }}" alt="Vorschau" class="rounded-lg shadow-md w-full">

                        <div class="mt-4 flex justify-center gap-4">
                            <form action="{{ route('photos.rotate', $media) }}" method="POST">
                                @csrf
                                <input type="hidden" name="direction" value="left">
                                <button type="submit" class="p-2 bg-white border rounded-full shadow hover:bg-gray-100" title="90° nach links drehen">
                                    <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="transform: scaleX(-1);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L8 9l9-5 5 5-7 7z" transform="rotate(90 12 12)" /></svg>
                                </button>
                            </form>
                            <form action="{{ route('photos.rotate', $media) }}" method="POST">
                                @csrf
                                <input type="hidden" name="direction" value="right">
                                <button type="submit" class="p-2 bg-white border rounded-full shadow hover:bg-gray-100" title="90° nach rechts drehen">
                                     <svg class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L8 9l9-5 5 5-7 7z" transform="rotate(90 12 12)" /></svg>
                                </button>
                            </form>
                            <button type="button" @click="showCropper = true" class="p-2 bg-white border rounded-full shadow hover:bg-gray-100" title="Bild zuschneiden">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.121 14.121L19 19M4.879 4.879L9.757 9.757M3 12h18M12 3v18"/></svg>
                            </button>
                        </div>
                    </div>
                </div>

                {{-- RECHTE SPALTE: Formular --}}
                <div class="lg:col-span-2">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <form method="POST" action="{{ route('photos.update', $media) }}" class="p-6 space-y-6">
                            @csrf
                            @method('PATCH')

                            @if(is_array($filters))
                                @foreach($filters as $key => $value)
                                    <input type="hidden" name="filters[{{ $key }}]" value="{{ $value }}">
                                @endforeach
                            @endif

                            <div class="p-3 bg-gray-50 rounded-md border flex items-center justify-between">
                                <div>
                                    <button type="button" @click="importExifData()" class="text-sm bg-blue-500 hover:bg-blue-600 text-white font-bold py-1 px-3 rounded">EXIF-Datum importieren</button>
                                </div>
                                <span x-text="feedback" class="text-xs text-gray-500"></span>
                            </div>

                            <div>
                                <x-input-label for="description" value="Beschreibung" />
                                <textarea name="description" id="description" x-model="description" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" rows="3"></textarea>
                            </div>
                            <div>
                                <x-input-label for="photo_date" value="Aufnahmedatum" />
                                <input type="date" name="photo_date" id="photo_date" x-model="photo_date" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            </div>
                            <div>
                                <x-input-label for="location" value="Aufnahmeort" />
                                <x-text-input type="text" name="location" id="location" x-model="location" class="mt-1 block w-full" />
                            </div>
                            <div>
                                <x-input-label for="tags" value="Abgebildete Personen" />
                                <x-text-input type="text" name="tags" id="tags" value="{{ $media->tags->pluck('name')->join(', ') }}" class="mt-1 block w-full" />
                                <p class="text-xs text-gray-500 mt-1">Mehrere Personen mit Komma trennen.</p>
                            </div>
                            <div>
                                <x-input-label for="photographer" value="Fotograf" />
                                <x-text-input type="text" name="photographer" id="photographer" x-model="photographer" class="mt-1 block w-full" />
                            </div>
                            
                            <div>
                                <x-input-label for="album_ids" value="Sammlungen" />
                                <select name="album_ids[]" id="album_ids" multiple class="block mt-1 w-full border-gray-300 rounded-md shadow-sm h-32">
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}" @if($media->albums->contains($album->id)) selected @endif>{{ $album->title }}</option>
                                    @endforeach
                                </select>
                                <p class="text-xs text-gray-500 mt-1">Halten Sie Strg (oder Cmd auf Mac) gedrückt, um mehrere Alben auszuwählen.</p>
                            </div>

                            <div class="border-t pt-6">
                                <label class="block font-medium text-sm text-gray-700 mb-2">Dieses Foto freigeben für:</label>
                                <div class="space-y-2 max-h-48 overflow-y-auto border rounded-md p-4 bg-gray-50">
                                    @php $sharedFamilyIds = $media->sharedWithFamilies->pluck('id'); @endphp
                                    @forelse($allFamilies as $family)
                                        <label class="flex items-center cursor-pointer">
                                            <input type="checkbox" name="share_with_families[]" value="{{ $family->id }}"
                                                   @if($sharedFamilyIds->contains($family->id)) checked @endif
                                                   class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                            <span class="ml-3 text-sm text-gray-700">{{ $family->name }}</span>
                                        </label>
                                    @empty
                                        <p class="text-sm text-gray-500 italic">Es gibt noch keine anderen Familien im Portal.</p>
                                    @endforelse
                                </div>
                            </div>

                            @if(class_exists('App\Http\Livewire\PhotoAlbumManager'))
                                <div>@livewire('photo-album-manager', ['media' => $media])</div>
                            @endif

                            <div class="border-t pt-4">
                                <label class="inline-flex items-center">
                                    <input type="checkbox" name="ignore_completeness" value="1" @if($media->getCustomProperty('ignore_completeness')) checked @endif class="rounded border-gray-300">
                                    <span class="ml-2 text-sm text-gray-600">Dieses Bild als 'vollständig' markieren.</span>
                                </label>
                            </div>

                            <div class="flex items-center gap-4">
                                <x-primary-button>Speichern</x-primary-button>
                                <a href="{{ route('photos.index', $filters) }}" class="text-sm text-gray-600 underline">Abbrechen</a>
                            </div>
                        </form>

                        <div class="p-6 border-t border-red-200">
                            <form method="POST" action="{{ route('photos.destroy', $media) }}" onsubmit="return confirm('Sind Sie sicher, dass Sie dieses Foto endgültig löschen möchten?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-sm text-red-600 hover:underline">Foto endgültig löschen</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div x-show="showCropper" @keydown.escape.window="showCropper = false" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center p-4" style="display: none;">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] flex flex-col" @click.away="showCropper = false">
                <div class="p-4 flex-1 overflow-hidden"><img id="image-to-crop" src="{{ $media->getUrl() }}?v={{ $media->updated_at->timestamp }}" class="max-w-full max-h-full"></div>
                <div class="p-4 bg-gray-100 border-t flex justify-end items-center gap-4">
                    <button @click="showCropper = false" type="button" class="text-sm px-4 py-2 rounded-md bg-gray-200 hover:bg-gray-300">Abbrechen</button>
                    <button @click="cropImage()" type="button" class="text-sm px-4 py-2 rounded-md bg-indigo-600 text-white hover:bg-indigo-700"><span x-show="!loading">Zuschnitt anwenden</span><span x-show="loading">Speichere...</span></button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('photoEditPage', () => ({
            photo_date: '{{ $media->getCustomProperty('photo_date') }}',
            description: `{!! addslashes($media->getCustomProperty('description')) !!}`,
            photographer: `{!! addslashes($media->getCustomProperty('photographer', auth()->user()->name)) !!}`,
            location: `{!! addslashes($media->getCustomProperty('location')) !!}`,
            feedback: '',
            importExifData() {
                this.feedback = 'Lese EXIF-Daten...';
                fetch('{{ route("photos.import-exif", $media) }}', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Content-Type': 'application/json', 'Accept': 'application/json' },
                })
                .then(response => response.ok ? response.json() : Promise.reject('Keine Daten gefunden'))
                .then(data => {
                    if (data.photo_date) this.photo_date = data.photo_date;
                    this.feedback = data.message || 'EXIF-Daten importiert!';
                })
                .catch(error => this.feedback = 'Fehler: ' + (error.message || 'Unbekannter Fehler'));
            },
            showCropper: false,
            cropperInstance: null,
            loading: false,
            init() {
                this.$watch('showCropper', value => {
                    if (value) {
                        this.$nextTick(() => {
                            const image = document.getElementById('image-to-crop');
                            if (image && !this.cropperInstance) {
                                this.cropperInstance = new Cropper(image, { viewMode: 1 });
                            }
                        });
                    } else {
                        if (this.cropperInstance) {
                            this.cropperInstance.destroy();
                            this.cropperInstance = null;
                        }
                    }
                });
            },
            cropImage() {
                if (!this.cropperInstance) return;
                this.loading = true;
                const cropData = this.cropperInstance.getData(true);
                fetch('{{ route("photos.crop", $media) }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json' },
                    body: JSON.stringify({ data: cropData })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Fehler: ' + (data.message || 'Unbekannt'));
                        this.loading = false;
                    }
                });
            }
        }));
    });
    </script>
    @endpush
</x-app-layout>