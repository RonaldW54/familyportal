<x-admin-layout>
    <x-slot name="header">
        Dashboard Übersicht
    </x-slot>

    <div class="space-y-6">
        @livewire('admin.user-approvals')
    </div>
</x-admin-layout>