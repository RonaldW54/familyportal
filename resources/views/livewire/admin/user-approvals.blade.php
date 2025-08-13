<div class="bg-white p-6 rounded-lg shadow-md">
    <h3 class="font-bold text-lg mb-4">Ausstehende Benutzer-Freigaben</h3>
    @if($usersToApprove->count() > 0)
        <ul class="space-y-3">
            @foreach($usersToApprove as $user)
                <li class="flex justify-between items-center p-2 border-b">
                    <div>
                        <span class="font-semibold">{{ $user->name }}</span>
                        <span class="text-sm text-gray-500 ml-2">({{ $user->email }})</span>
                        @if($user->requested_family_name)
                            <span class="text-xs bg-blue-100 text-blue-800 p-1 rounded ml-2">Wunsch: {{ $user->requested_family_name }}</span>
                        @endif
                    </div>
                    <div class="flex gap-2">
                        <button wire:click="approve({{ $user->id }})" class="px-3 py-1 bg-green-500 text-white text-xs rounded hover:bg-green-600">Freigeben</button>
                        <button wire:click="reject({{ $user->id }})" wire:confirm="Sind Sie sicher, dass Sie diesen Benutzer ablehnen und löschen möchten?" class="px-3 py-1 bg-red-500 text-white text-xs rounded hover:bg-red-600">Ablehnen</button>
                    </div>
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Aktuell gibt es keine ausstehenden Freigaben.</p>
    @endif
</div>