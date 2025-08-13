<div>
    <x-input-label value="Gehört zu folgenden Sammlungen:" />
    <div class="mt-2 space-y-2">
        @forelse($assignedAlbums as $album)
            <div class="flex justify-between items-center bg-gray-100 p-2 rounded-md">
                <span>{{ $album->title }}</span>
                <button type="button" wire:click="removeFromAlbum({{ $album->id }})" class="text-red-500 text-xs">Entfernen</button>
            </div>
        @empty
            <p class="text-sm text-gray-500">Dieses Bild ist in keiner Sammlung.</p>
        @endforelse
    </div>

    <div class="mt-4">
        <select wire:model="newAlbumId" class="border-gray-300 rounded-md shadow-sm">
            <option>Zu einer weiteren Sammlung hinzufügen...</option>
            @foreach($availableAlbums as $album)
                <option value="{{ $album->id }}">{{ $album->title }}</option>
            @endforeach
        </select>
        <button type="button" wire:click="addToAlbum" class="ml-2 ...">Hinzufügen</button>
    </div>
</div>