<div>
    {{-- ============================================= --}}
    {{-- ===== ADMIN-FILTER-SEKTION ================== --}}
    {{-- ============================================= --}}
    <div class="bg-gray-50 p-4 rounded-lg border mb-6">
        <h3 class="font-semibold mb-2">Filter</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Status-Filter --}}
            <div>
                <label for="filterStatus" class="block text-sm font-medium text-gray-700">Status</label>
                <select wire:model.live="filterStatus" id="filterStatus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">Alle</option>
                    <option value="no-description">Ohne Beschreibung</option>
                    <option value="no-album">Ohne Album</option>
                </select>
            </div>
            {{-- Benutzer-Filter --}}
            <div>
                <label for="filterUser" class="block text-sm font-medium text-gray-700">Besitzer</label>
                <select wire:model.live="filterUser" id="filterUser" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
                    <option value="">Alle Benutzer</option>
                    @foreach($allUsers as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
            </div>
            {{-- Datums-Filter --}}
            <div>
                <label for="filterDateAfter" class="block text-sm font-medium text-gray-700">Hochgeladen nach</label>
                <input wire:model.live="filterDateAfter" id="filterDateAfter" type="date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
            </div>
            {{-- Such-Filter --}}
            <div>
                <label for="search" class="block text-sm font-medium text-gray-700">Dateiname</label>
                <input wire:model.live.debounce.300ms="search" id="search" type="text" placeholder="Suchen..." class="mt-1 block w-full rounded-md border-gray-300 shadow-sm text-sm">
            </div>
        </div>
    </div>

    {{-- ============================================= --}}
    {{-- ===== BILDERGALERIE ========================= --}}
    {{-- ============================================= --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-4">
        @forelse($photos as $photo)
            <div class="relative group">
                <a href="{{ route('admin.photos.manage.edit', $photo) }}">
                    <img src="{{ $photo->hasGeneratedConversion('thumbnail') ? $photo->getUrl('thumbnail') : $photo->getUrl() }}" 
                         class="rounded shadow-md aspect-square object-cover">
                </a>
                {{-- Info-Overlay, das bei Hover erscheint --}}
                <div class="absolute bottom-0 left-0 right-0 bg-black bg-opacity-60 text-white text-xs p-2 rounded-b-md opacity-0 group-hover:opacity-100 transition-opacity">
                    <p class="truncate"><strong>Besitzer:</strong> {{ $photo->model->name ?? 'N/A' }}</p>
                    <p class="truncate"><strong>Hochgeladen:</strong> {{ $photo->created_at->format('d.m.Y') }}</p>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500">Keine Bilder gefunden, die den Filterkriterien entsprechen.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $photos->links() }}
    </div>
</div>