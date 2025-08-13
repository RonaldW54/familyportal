<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
   <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
    <body class="font-sans antialiased bg-gray-100">
        <div class="flex h-screen overflow-hidden">
            
            {{-- Linke Navigationsleiste --}}
            <aside class="w-64 bg-gray-800 text-white flex-shrink-0 overflow-y-auto">
                <div class="p-4 border-b border-gray-700">
                    <a href="{{ route('admin.dashboard') }}" class="text-lg font-bold">Admin Panel</a>
                </div>
                <nav class="mt-4 text-sm">
                    <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-md m-2 @if(request()->routeIs('admin.dashboard')) bg-gray-900 @endif">Übersicht</a>
                    <a href="{{ route('admin.approvals.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-md m-2 @if(request()->routeIs('admin.approvals.index')) bg-gray-900 @endif">Freigaben</a>
                    <a href="{{ route('admin.users.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-md m-2 @if(request()->routeIs('admin.users.index')) bg-gray-900 @endif">Benutzerverwaltung</a>
                    <a href="{{ route('admin.photos.manage.index') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-md m-2 @if(request()->routeIs('admin.photos.manage.index')) bg-gray-900 @endif">Inhaltsverwaltung</a>
                    <a href="{{ route('admin.settings.edit') }}" class="block px-4 py-2 hover:bg-gray-700 rounded-md m-2 @if(request()->routeIs('admin.settings.edit')) bg-gray-900 @endif">Texte & Einstellungen</a>

            </aside>

            {{-- Rechter Hauptbereich --}}
            <div class="flex-1 flex flex-col">
                <header class="bg-white shadow-sm p-4 z-10">
                    <div class="flex justify-between items-center">
    {{-- Die Überschrift bleibt, wie sie ist --}}
    <h1 class="text-xl font-semibold text-gray-800">{{ $header ?? 'Dashboard' }}</h1>

    {{-- Dieser Container hält jetzt den Link UND das neue Dropdown --}}
    <div class="flex items-center ml-6">
        <a href="{{ route('dashboard') }}" class="text-sm text-gray-600 hover:underline mr-4">Benutzeransicht</a>

        {{-- DAS IST DAS NEUE DROPDOWN-MENÜ --}}
        <div x-data="{ open: false }" @click.outside="open = false" class="relative">
            <div @click="open = !open">
                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ml-1">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </div>
                </button>
            </div>

            <div x-show="open"
                 x-transition
                 @click="open = false"
                 class="absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 z-50"
                 style="display: none;">
                
                <a href="{{ route('admin.dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Admin-Übersicht</a>
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Mein Profil</a>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        Abmelden
                    </a>
                </form>
            </div>
        </div>
    </div>
</div>
                </header>

                <main class="flex-1 overflow-y-auto p-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        <div class="lg:col-span-2">
                            {{ $slot }} {{-- HIER KOMMT DER INHALT DER SEITEN REIN --}}
                        </div>
                        <div class="lg:col-span-1">
                            @livewire('admin.portal-stats')
                        </div>
                    </div>
                </main>
            </div>
        </div>
        @livewireScripts
        @stack('scripts')
    </body>
</html>