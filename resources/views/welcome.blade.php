<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Willkommen im Familienportal</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

    <!-- Scripts und Styles (Vite lädt automatisch das richtige CSS/JS für uns) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-800">

    <!-- Alpine.js Container für den Zustand der Seite -->
    <div x-data="{ loginOpen: false }" class="relative min-h-screen">

        <!-- Oben rechts: Links für Login & Antrag -->
        <header class="absolute top-0 right-0 p-6 text-right z-10">
    @auth
        <!-- Wenn der User eingeloggt ist -->
        <div class="flex items-center gap-4">
            <a href="{{ auth()->user()->isAdmin ? route('admin.dashboard') : route('dashboard') }}" class="font-semibold text-gray-600 hover:text-gray-900">Dashboard</a>
            
            <!-- Logout Formular -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <a href="{{ route('logout') }}"
                   onclick="event.preventDefault(); this.closest('form').submit();"
                   class="font-semibold text-gray-600 hover:text-gray-900">
                    Logout
                </a>
            </form>
        </div>
    @else
        <!-- Wenn der User nicht eingeloggt ist -->
        <button @click="loginOpen = true" class="font-semibold text-gray-600 hover:text-gray-900 focus:outline focus:outline-2 focus:rounded-sm focus:outline-red-500">
            Login
        </button>
    @endauth
</header>

        <!-- Hauptinhalt der Seite: Der Willkommenstext -->
        <main class="flex items-center justify-center min-h-screen">
            <div class="text-center">
            <h1 class="text-4xl font-bold text-gray-900">
            {{ $texts['welcome_title'] ?? 'Willkommen im Familienportal' }}
            </h1>
            <p class="mt-4 text-lg text-gray-600">
            {!! nl2br(e($texts['welcome_subtitle'] ?? 'Der sichere Ort, um eure Fotos und Geschichten zu teilen.')) !!}
            </p>
            </div>
        </main>

        <!-- Das Login-Formular als Pop-Up (Modal) -->
        <!-- Es wird nur angezeigt, wenn loginOpen = true ist -->
  <div x-show="loginOpen"
     x-transition:enter="ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-20 flex items-center justify-center p-4 bg-gray-900 bg-opacity-75"
     style="display: none;">

    <!-- Das weiße Formularfenster mit Breitenbegrenzung und abgerundeten Ecken -->
    <div @click.away="loginOpen = false"
         class="bg-white rounded-lg shadow-xl w-full p-6 border-4 border-gray-300"
         style="max-width: 500px;">

        <h2 class="text-xl font-bold mb-4 text-center">Login</h2>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email -->
            <div>
                <x-input-label for="email" value="E-Mail" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" value="Passwort" />
                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Buttons am Ende des Formulars -->
            <div class="flex items-center justify-between mt-6">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('apply.create') }}">
                    Familie gründen
                </a>

                <x-primary-button>
                    Login
                </x-primary-button>
            </div>
        </form>
    </div>
</div>

    </div> <!-- Ende Alpine.js Container -->
 
</body>
</html>