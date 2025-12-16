<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FestiTickets' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen bg-secondary">
    <!-- Header -->
    <header class="header-bg header-text shadow-lg">
        <nav class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold tracking-tight hover:opacity-90 transition-opacity">
                    🎫 FestiTickets
                </a>
                <div class="flex items-center gap-6 text-sm font-medium">
                    @auth
                        <a href="{{ route('home') }}" class="header-text hover:text-gray-300 transition-colors px-3 py-2 rounded">Home</a>
                        <a href="{{ route('events.index') }}" class="header-text hover:text-gray-300 transition-colors px-3 py-2 rounded">Evenementen</a>
                        @if(auth()->user()->is_admin)
                            <a href="{{ route('admin.events.index') }}" class="header-text hover:text-gray-300 transition-colors px-3 py-2 rounded">Admin Dashboard</a>
                        @endif

                        <!-- Account Dropdown -->
                        <div class="relative" x-data="{ open: false }" x-cloak>
                            <button @click="open = !open" class="header-text hover:text-gray-300 transition-colors px-3 py-2 rounded flex items-center gap-1">
                                Account
                                <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div x-show="open" @click.away="open = false" x-transition:enter="transition ease-out duration-100" x-transition:enter-start="transform opacity-0 scale-95" x-transition:enter-end="transform opacity-100 scale-100" x-transition:leave="transition ease-in duration-75" x-transition:leave-start="transform opacity-100 scale-100" x-transition:leave-end="transform opacity-0 scale-95" class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50" style="display: none;">
                                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                    Instellingen
                                </a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100 transition">
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="header-text hover:text-gray-300 transition-colors px-3 py-2 rounded">Login</a>
                        <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">Registreren</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- Main Content -->
    <main class="flex-grow">
        {{ $slot }}
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t mt-auto">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <div class="text-center text-gray-600 text-sm">
                <p>&copy; {{ date('Y') }} FestiTickets - <a href="https://github.com/tijn-avontuur" class="hover:underline">Tijn Avontuur</a></p>
            </div>
        </div>
    </footer>
</body>
</html>

