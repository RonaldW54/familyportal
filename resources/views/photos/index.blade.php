<x-app-layout>

    {{-- ====================================================== --}}
    {{-- HIER DEN PHP-BLOCK FÜR DIE ROUTEN-LOGIK EINFÜGEN --}}
    {{-- ====================================================== --}}
    @php
        $currentRouteName = 'photos.index'; // Standard
        $currentRouteParams = [];

        if ($mode === 'shared') {
            $currentRouteName = 'photos.shared';
        }

        if ($mode === 'album') {
            $currentRouteName = 'albums.show';
            $currentRouteParams = ['album' => $album];
        }
    @endphp

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
             @if(isset($mode) && $mode === 'album')
        {{-- Spezielle Anzeige für Alben --}}
        @php
            $currentRouteName = 'photos.index';
            $currentRouteParams = [];

            if (isset($mode) && $mode === 'shared') {
                $currentRouteName = 'photos.shared';
            }

            if (isset($mode) && $mode === 'album') {
                $currentRouteName = 'albums.show';
                $currentRouteParams = ['album' => $album]; // Wichtig: Der Parameter muss übergeben werden
            }
        @endphp
        <div>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Album: {{ $album->title }}
            </h2>
            @if($album->description)
                <p class="mt-1 text-sm text-gray-600 prose max-w-none">{{ $album->description }}</p>
            @endif
        </div>
    @elseif(isset($mode) && $mode === 'shared')
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Für mich freigegebene Fotos
        </h2>
    @else
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Meine Fotos
        </h2>
    @endif
        </h2>
        @if($mode === 'album' && $album->description)
            <p class="text-sm text-gray-600 mt-1">{{ $album->description }}</p>
        @endif
    </x-slot>

    {{-- ... Rest der Datei ... --}}
<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        @if($mode === 'album')
            Album: {{ $album->title }}
        @elseif($mode === 'shared')
            Für mich freigegebene Fotos
        @else
            Meine Fotos
        @endif
    </h2>
    @if($mode === 'album' && $album->description)
        <p class="text-sm text-gray-600 mt-1">{{ $album->description }}</p>
    @endif
</x-slot>

    <div x-data="{ filterOpen: false }">
        <div class="sticky top-[4.1rem] z-30 bg-gray-100/75 backdrop-blur-sm border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            {{-- Ansicht-Umschalter (links) --}}
            <div class="flex items-center gap-2 p-1 bg-gray-200 rounded-md">
            @php
                $gridUrl = route($currentRouteName, array_merge($currentRouteParams, request()->query(), ['view' => 'grid']));
                $listUrl = route($currentRouteName, array_merge($currentRouteParams, request()->query(), ['view' => 'list']));
                $slideshowUrl = route($currentRouteName, array_merge($currentRouteParams, request()->query(), ['view' => 'slideshow']));
            @endphp
            <a href="{{ $gridUrl }}" ...>Matrix</a>
            <a href="{{ $listUrl }}" ...>Liste</a>
            <a href="{{ $slideshowUrl }}" ...>Slideshow</a>

            </div>
            
            {{-- Filter-Button (rechts) --}}
            <button @click.prevent="filterOpen = true" class="inline-flex items-center px-4 py-2 bg-indigo-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-indigo-700">
                Filter
            </button>
        </div>
    </div>
</div>

        <div x-show="filterOpen" x-transition class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex justify-center items-center p-4" style="display: none;">
            <div @click.away="filterOpen = false" class="bg-white rounded-lg shadow-xl w-full max-w-xl">
                 <form id="filter-form" action="{{ route($currentRouteName, $currentRouteParams) }}" method="GET">
                 <input type="hidden" name="view" value="{{ $currentView }}">   
                 <h3 class="text-lg font-bold mb-6">Anzeige filtern</h3>
                    <div class="space-y-6">
                       <div>
    
</div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 border-t pt-6">
                            <div>
                                <label for="filter" class="block text-sm font-medium text-gray-700">Hauptfilter</label>
                                <select name="filter" id="filter" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">-- Alle Bilder --</option>
                                    <option value="no-album" @if(isset($currentFilter) && $currentFilter == 'no-album') selected @endif>Bilder ohne Album</option>
                                    <option value="by-album" @if(isset($currentFilter) && $currentFilter == 'by-album') selected @endif>Nach Album filtern</option>
                                </select>
                            </div>
                            <div>
                                <label for="album_id" class="block text-sm font-medium text-gray-700">Album</label>
                                <select name="album_id" id="album_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">-- Album wählen --</option>
                                    @foreach($albums as $album)
                                        <option value="{{ $album->id }}" @if(isset($currentAlbumId) && $currentAlbumId == $album->id) selected @endif>{{ $album->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="person" class="block text-sm font-medium text-gray-700">Abgebildete Person</label>
                                <input type="text" name="person" id="person" value="{{ $currentPerson ?? '' }}" placeholder="Namen eingeben..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                            </div>
                        </div>
                    </div>
                    <div class="mt-8 flex justify-between items-center">
                        <a href="{{ route($mode === 'mine' ? 'photos.index' : 'photos.shared') }}" class="text-sm text-gray-600 underline">Zurücksetzen</a>
                        <div class="flex items-center gap-4">
                            <button type="button" @click="filterOpen = false" class="px-4 py-2 bg-gray-200">Abbrechen</button>
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Anwenden</button>
                            <a href="{{ route($currentRouteName, $currentRouteParams) }}" class="text-sm text-gray-600 underline">Zurücksetzen</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 pt-6 pb-12">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                @if($photos->count() > 0)

    {{-- ======================================================= --}}
    {{-- WELT 1: DIE SLIDESHOW (hat keine Paginierung) --}}
    {{-- ======================================================= --}}
    @if(isset($currentView) && $currentView == 'slideshow')

    {{-- ======================================================= --}}
    {{-- WELT 1: DIE SLIDESHOW (hat keine Paginierung) --}}
    {{-- ======================================================= --}}
    <div class="fixed inset-0 bg-black z-50 flex flex-col">
        <a href="{{ route($mode === 'mine' ? 'photos.index' : 'photos.shared', array_merge(request()->except('page', 'view'), ['view' => 'grid'])) }}"
   class="absolute top-4 right-4 text-white bg-black bg-opacity-30 rounded-full p-2 hover:bg-opacity-60 transition z-50" 
   aria-label="Slideshow schließen"
   title="Slideshow schließen">
    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
    </svg>
</a>
        <div class="swiper h-full w-full">
            <div class="swiper-wrapper">
                @foreach($photos as $photo)
                    <div class="swiper-slide !flex items-center justify-center p-4">
                        <figure class="relative h-full w-full flex items-center justify-center">
                            <img src="{{ $photo->hasGeneratedConversion('preview') ? $photo->getUrl('preview') : $photo->getUrl() }}" alt="{{ $photo->getCustomProperty('title', $photo->name) }}" class="max-w-full max-h-full object-contain">
                            <figcaption class="absolute bottom-0 left-0 right-0 p-4 text-center text-white bg-gradient-to-t from-black/60 to-transparent">
                                <h4 class="font-bold text-lg">{{ $photo->getCustomProperty('title', $photo->name) }}</h4>
                            </figcaption>
                        </figure>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-prev text-white"></div>
            <div class="swiper-button-next text-white"></div>
        </div>
    </div>

    {{-- ======================================================= --}}
    {{-- DAS JAVASCRIPT WIRD JETZT DIREKT HIER EINGEFÜGT     --}}
    {{-- ======================================================= --}}
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Die Verzögerung aus PHP holen
            const delay = {{ $slideshowDelay ?? 0 }};

            // Grundkonfiguration für Swiper
            const swiperOptions = {
                loop: {{ $photos->count() > 1 ? 'true' : 'false' }},
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                keyboard: {
                    enabled: true,
                },
            };

            // Füge die Autoplay-Optionen NUR hinzu, wenn eine Verzögerung > 0 gesetzt ist
            if (delay > 0) {
                swiperOptions.autoplay = {
                    delay: delay,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                };
            }

            // Initialisiere Swiper mit der finalen Konfiguration
            new Swiper('.swiper', swiperOptions);
        });
    </script>
    @else

    {{-- ======================================================= --}}
    {{-- WELT 2: MATRIX & LISTE (haben Paginierung) --}}
    {{-- ======================================================= --}}
        
        @if(isset($currentView) && $currentView == 'list')
            <div class="space-y-10">
    @foreach($photos as $photo)
        <div class="max-w-4xl mx-auto">
            <a href="{{ route('photos.edit', ['media' => $photo, 'filters' => request()->query()]) }}" class="block group">
                <div class="bg-gray-100 rounded-lg flex items-center justify-center overflow-hidden h-auto" style="max-height: calc(100vh - 16rem);">
                    {{-- Verwende die 'preview' Konvertierung für bessere Performance --}}
                    <img src="{{ $photo->hasGeneratedConversion('preview') ? $photo->getUrl('preview') : $photo->getUrl() }}" 
                         alt="{{ $photo->getCustomProperty('title', $photo->name) }}" 
                         class="max-w-full max-h-full object-contain">
                </div>
            </a>
            <div class="mt-3 text-center">
                {{-- Robuste Anzeige von Titel/Beschreibung --}}
                <h4 class="font-bold group-hover:underline">
                    {{ $photo->getCustomProperty('title', $photo->getCustomProperty('description', $photo->name)) }}
                </h4>
            </div>
        </div>
    @endforeach
</div>
        @else
            <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 xl:grid-cols-6 2xl:grid-cols-8 gap-x-4 gap-y-6">
                @foreach($photos as $photo)
                    <a href="{{ route('photos.edit', ['media' => $photo, 'filters' => request()->query()]) }}" class="block group">
                        <div class="aspect-w-1 aspect-h-1 bg-gray-100 rounded-md overflow-hidden">
                            <img src="{{ $photo->hasGeneratedConversion('thumbnail') ? $photo->getUrl('thumbnail') : $photo->getUrl() }}" alt="{{ $photo->getCustomProperty('title', $photo->name) }}" class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-110">
                        </div>
                        <div class="mt-2">
                            <h4 class="text-sm font-semibold truncate group-hover:underline">{{ $photo->getCustomProperty('title', $photo->getCustomProperty('description', $photo->name)) }}</h4>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- Die Paginierung wird nur in dieser "Welt" gerendert --}}
        @if ($photos->hasPages())
            <div class="mt-8">
                {{ $photos->links() }}
            </div>
        @endif

    @endif

@else
    <div class="text-center p-10"><p>Keine Bilder gefunden, die den Filterkriterien entsprechen.</p></div>
@endif
            </div>
        </div>
    </div>
</x-app-layout>