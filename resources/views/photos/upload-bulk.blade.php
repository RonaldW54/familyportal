<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Massen-Upload von Fotos</h2>
    </x-slot>

    <div class="py-12">
        {{-- Wir initialisieren Alpine.js für die gesamte Seite --}}
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8" x-data="bulkUploadPage({ initialAlbums: {{ $albums->toJson() }} })">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 md:p-8 space-y-8">

                {{-- Album-Auswahl und "Neues Album"-Funktion --}}
                <div>
                    <label for="album_id" class="block font-medium text-sm text-gray-700 mb-2">1. Einem Album zuweisen (optional)</label>
                    <div class="flex items-center gap-2">
                        <select id="album_id" x-model="selectedAlbumId" class="flex-grow block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Bilder keinem Album zuweisen --</option>
                            <template x-for="album in albums" :key="album.id">
                                <option :value="album.id" x-text="album.title"></option>
                            </template>
                        </select>
                        <button @click="showNewAlbumModal = true" type="button" class="px-4 py-2 bg-gray-200 text-sm font-semibold rounded-md hover:bg-gray-300">Neu</button>
                    </div>
                </div>

                {{-- FilePond-Upload-Bereich --}}
                <div>
                    <label class="block font-medium text-sm text-gray-700 mb-2">2. Bilder auswählen</label>
                    <div x-ref="pond"></div> {{-- FilePond wird sich hier einhängen --}}
                </div>

                {{-- Upload-Start-Button --}}
                <div>
                    <button @click="startUpload()" type="button" class="w-full inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-md font-semibold text-white uppercase tracking-widest hover:bg-indigo-700">
                        Upload starten
                    </button>
                </div>
                
                {{-- Modal zum Erstellen eines neuen Albums --}}
                <div x-show="showNewAlbumModal" @keydown.escape.window="showNewAlbumModal = false" class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center" style="display: none;">
                    <div @click.away="showNewAlbumModal = false" class="bg-white rounded-lg shadow-xl p-6 w-full max-w-md">
                        <h3 class="text-lg font-bold mb-4">Neues Album erstellen</h3>
                        <input type="text" x-model="newAlbumTitle" @keydown.enter.prevent="createNewAlbum()" placeholder="Name des Albums" class="block w-full border-gray-300 rounded-md shadow-sm">
                        <p x-text="newAlbumError" class="text-sm text-red-600 mt-1"></p>
                        <div class="mt-4 flex justify-end gap-4">
                            <button @click="showNewAlbumModal = false" type="button" class="px-4 py-2 bg-gray-200 rounded-md">Abbrechen</button>
                            <button @click="createNewAlbum()" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Erstellen</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    function bulkUploadPage(config) {
        return {
            albums: config.initialAlbums,
            selectedAlbumId: '',
            pond: null,
            showNewAlbumModal: false,
            newAlbumTitle: '',
            newAlbumError: '',

            init() {
                // Robuste Initialisierung von FilePond
                this.pond = FilePond.create(this.$refs.pond, {
                    name: 'file',
                    allowMultiple: true,
                    instantUpload: false, // Wichtig: Upload startet nicht sofort
                    labelIdle: `Bilder hierher ziehen oder <span class="filepond--label-action">Durchsuchen</span>`,
                    // ... weitere FilePond-Optionen ...
                });
            },

            startUpload() {
                // Setze die Album-ID für alle Dateien, bevor der Prozess startet
                const serverConfig = {
                    url: '{{ route("photos.upload-bulk.store") }}' + (this.selectedAlbumId ? `?album_id=${this.selectedAlbumId}` : ''),
                    process: {
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    }
                };
                this.pond.setOptions({ server: serverConfig });

                // Starte den Upload-Prozess
                this.pond.processFiles();
            },

            createNewAlbum() {
                if (!this.newAlbumTitle.trim()) {
                    this.newAlbumError = 'Bitte geben Sie einen Namen ein.';
                    return;
                }
                this.newAlbumError = '';

                fetch('{{ route("albums.ajax.store") }}', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ title: this.newAlbumTitle })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Füge das neue Album zur Liste hinzu
                        this.albums.push(data.album);
                        // Wähle das neue Album sofort aus
                        this.selectedAlbumId = data.album.id;
                        // Schließe das Modal und setze die Felder zurück
                        this.showNewAlbumModal = false;
                        this.newAlbumTitle = '';
                    } else {
                        // Zeige Validierungsfehler etc. an
                        this.newAlbumError = 'Fehler: Dieses Album existiert bereits.';
                    }
                });
            }
        }
    }
    </script>
    @endpush
</x-app-layout>