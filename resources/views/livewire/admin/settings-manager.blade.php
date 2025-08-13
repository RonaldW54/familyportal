<div>
    {{-- Erfolgsmeldung, die nach dem Speichern erscheint --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6" role="alert">
            <p>{{ session('success') }}</p>
        </div>
    @endif

    {{-- Das Formular wird von Livewire per AJAX abgeschickt --}}
    <form wire:submit="save">
        {{-- Ein "Karten"-Container für die Slideshow-Einstellungen --}}
        <div class="bg-white p-6 rounded-lg shadow-md">
            <h3 class="text-lg font-bold border-b pb-4 mb-4">Slideshow-Einstellungen</h3>
            
            <div>
                <label for="slideshowDelay" class="block text-sm font-medium text-gray-700">
                    Bildwechsel-Verzögerung (in Millisekunden)
                </label>
                
                <input wire:model="slideshowDelay" type="number" id="slideshowDelay" 
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                
                <p class="text-xs text-gray-500 mt-2">
                    Geben Sie die Anzeigedauer für jedes Bild ein.
                    <br>Beispiel: <span class="font-mono">5000</span> für 5 Sekunden.
                    <br>Geben Sie <span class="font-mono">0</span> ein, um den automatischen Bildwechsel zu deaktivieren.
                </p>

                @error('slideshowDelay') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        </div>

        {{-- Hier werden später weitere Einstellungs-Karten (Themes, Logo etc.) hinzugefügt --}}

        {{-- Der Speichern-Button am Ende --}}
        <div class="flex justify-end mt-6">
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Einstellungen speichern
            </button>
        </div>
    </form>
</div>