{{-- in resources/views/admin/users/index.blade.php --}}
<x-admin-layout>
    <x-slot name="header">
        Benutzerverwaltung
    </x-slot>

    {{-- Hier wird die Livewire-Komponente für die gesamte Benutzerverwaltung geladen --}}
    @livewire('admin.user-management')

</x-admin-layout>