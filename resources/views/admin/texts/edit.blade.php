<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Willkommenstexte bearbeiten
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <!-- Erfolgsmeldung nach dem Speichern -->
                    @if(session('success'))
                        <div class="mb-4 font-medium text-sm text-green-600 bg-green-100 border-l-4 border-green-500 p-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.texts.update') }}">
                        @csrf
                        
                        <!-- Eingabefeld für die Hauptüberschrift -->
                        <div class="mb-6">
                            <x-input-label for="welcome_title" value="Hauptüberschrift" />
                            <x-text-input type="text" name="welcome_title" id="welcome_title" class="mt-1 block w-full" value="{{ $texts['welcome_title'] ?? '' }}" />
                        </div>
                        
                        <!-- Textarea für die Unterüberschrift -->
                        <div class="mb-6">
                            <x-input-label for="welcome_subtitle" value="Unterüberschrift" />
                            <textarea name="welcome_subtitle" id="welcome_subtitle" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" rows="5">{{ $texts['welcome_subtitle'] ?? '' }}</textarea>
                        </div>
                        
                        <!-- Speichern-Button -->
                        <div class="flex items-center">
                            <x-primary-button>
                                Speichern
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-admin-layout>