<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Mein Dashboard
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <h3 class="text-2xl font-bold">Hallo {{ auth()->user()->name }}, willkommen zurück!</h3>

                    {{-- Wir prüfen den Status des Benutzers. 'pending' User sehen eine Wartemeldung. --}}
                    @if(auth()->user()->status === 'pending')
                        <div class="mt-6 border-t pt-6">
                            <div class="p-6 bg-yellow-50 text-yellow-800 rounded-lg border border-yellow-200">
                                <h4 class="font-semibold">Ihr Antrag wird geprüft</h4>
                                <p class="text-sm mt-1">Vielen Dank für Ihre Registrierung. Ein Administrator wird Ihren Antrag in Kürze prüfen und Sie freischalten.</p>
                            </div>
                        </div>
                    @else
                        {{-- Dieser Block wird nur für aktive User angezeigt --}}
                        <div class="mt-6 border-t pt-6">

                            {{-- BEREICH 1: NEUEN INHALT ERSTELLEN --}}
                            <h4 class="text-lg font-semibold mb-4">Was möchtest du tun?</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                                <!-- Widget: Einzelnes Foto hochladen -->
                                <a href="{{ route('photos.create') }}" class="p-6 bg-blue-50 text-blue-800 rounded-lg hover:bg-blue-100 border border-blue-200 text-center transition">
                                    <div class="text-3xl mb-2">🖼️</div>
                                    <h5 class="font-semibold">Einzelnes Foto hochladen</h5>
                                    <p class="text-sm mt-1">Lade ein Bild hoch und füge direkt Details hinzu.</p>
                                </a>
                                
                                <!-- Widget: Massen-Upload -->
                                <a href="{{ route('photos.upload-bulk') }}" class="p-6 bg-blue-50 text-blue-800 rounded-lg hover:bg-blue-100 border border-blue-200 text-center transition">
                                    <div class="text-3xl mb-2">📦</div>
                                    <h5 class="font-semibold">Mehrere Fotos hochladen</h5>
                                    <p class="text-sm mt-1">Lade viele Bilder auf einmal per Drag & Drop.</p>
                                </a>

                                <!-- Widget: Neuer Bericht -->
                                <a href="{{ route('reports.create') }}" class="p-6 bg-green-50 text-green-800 rounded-lg hover:bg-green-100 border border-green-200 text-center transition">
                                    <div class="text-3xl mb-2">📖</div>
                                    <h5 class="font-semibold">Neuen Bericht schreiben</h5>
                                    <p class="text-sm mt-1">Verfassen Sie eine neue Geschichte für Ihre Familie.</p>
                                </a>
                            </div>

                            {{-- BEREICH 2: DEINE AUFGABEN & STATUS --}}
                            <h4 class="text-lg font-semibold mb-4">Deine Aufgaben & Status</h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                                <!-- Widget: Unbearbeitete Fotos -->
                                @if($unprocessedPhotosCount > 0)
                                    <a href="{{ route('photos.unprocessed') }}" class="p-6 bg-orange-100 text-orange-800 rounded-lg hover:bg-orange-200 border border-orange-300">
                                        <h5 class="font-semibold">Unbearbeitete Fotos</h5>
                                        <p class="text-3xl font-bold mt-2">{{ $unprocessedPhotosCount }}</p>
                                        <p class="text-sm mt-1">Bilder warten auf Ihre Beschreibung.</p>
                                    </a>
                                @else
                                    <div class="p-6 bg-green-100 text-green-800 rounded-lg border border-green-300">
                                        <h5 class="font-semibold">Bilder gepflegt!</h5>
                                        <p class="text-sm mt-2">Alle Ihre Bilder sind auf dem neuesten Stand. Super!</p>
                                    </div>
                                @endif
                                
                                {{-- Hier kommt später die Box für Systemmeldungen hin --}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>