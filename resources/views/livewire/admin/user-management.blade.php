<div>
    {{-- Erfolgsmeldung --}}
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Suchfeld --}}
    <div class="mb-4">
        <input wire:model.live.debounce.300ms="search" type="text" placeholder="Benutzer suchen..." class="w-full rounded-md border-gray-300 shadow-sm">
    </div>

    {{-- Benutzertabelle --}}
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Familie</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Aktion</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($users as $user)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->family->name ?? 'Keine' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">{{ $user->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right">
                            <button wire:click="edit({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900">Bearbeiten</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $users->links() }}</div>

    {{-- Bearbeiten-Modal --}}
    @if($showEditModal)
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-lg">
                <h3 class="text-lg font-bold mb-4">Benutzer bearbeiten: {{ $editingUser->name }}</h3>
                <div class="space-y-4">
                    <div>
                        <label for="name" class="block text-sm">Name</label>
                        <input wire:model="name" type="text" id="name" class="w-full rounded-md border-gray-300">
                        @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="email" class="block text-sm">E-Mail</label>
                        <input wire:model="email" type="email" id="email" class="w-full rounded-md border-gray-300">
                        @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label for="family_id" class="block text-sm">Familie</label>
                        <select wire:model="family_id" id="family_id" class="w-full rounded-md border-gray-300">
                            <option value="">Keiner Familie zuweisen</option>
                            @foreach($families as $family)
                                <option value="{{ $family->id }}">{{ $family->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <<div class="border-t pt-4">
                        <h4 class="font-semibold">Passwort-Aktionen</h4>
                        <button wire:click="generateResetLink" type="button" class="mt-2 text-sm text-blue-600">Passwort-Reset-Link generieren (15 Min. gültig)</button>
    
                        @if($resetLink)
                            <div class="mt-2 p-2 bg-yellow-100 border border-yellow-400 rounded">
                            <strong>Einmaliger Reset-Link:</strong>
                            <input type="text" value="{{ $resetLink }}" class="w-full font-mono text-xs mt-1" readonly onclick="this.select()">
                            <p class="text-xs mt-1">Bitte kopieren und sicher an den Benutzer weitergeben.</p>
                            </div>
                        @endif
                
                </div>
                <div class="mt-6 flex justify-end gap-4">
                    <button wire:click="$set('showEditModal', false)" type="button" class="px-4 py-2 bg-gray-200 rounded-md">Abbrechen</button>
                    <button wire:click="save" type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md">Speichern</button>
                </div>
            </div>
        </div>
    @endif
</div>