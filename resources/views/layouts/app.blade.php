<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'FestiTickets' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex flex-col min-h-screen">
    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="max-w-6xl mx-auto px-6 py-5">
            <div class="flex justify-between items-center">
                <a href="{{ route('home') }}" class="text-2xl font-bold hover:opacity-80">FestiTickets</a>
                <div class="flex items-center gap-6">
                    @auth
                        <a href="{{ route('profile.edit') }}" class="text-gray-700 hover:text-black transition">My Account</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="bg-black text-white px-5 py-2.5 rounded hover:bg-gray-800 transition">Logout</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-black transition">Login</a>
                        <a href="{{ route('register') }}" class="bg-black text-white px-5 py-2.5 rounded hover:bg-gray-800 transition">Sign Up</a>
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
        <div class="max-w-6xl mx-auto px-6 py-8">
            <div class="text-center text-gray-600">
                <p>&copy; {{ date('Y') }} FestiTickets. All rights reserved.</p>
            </div>
        </div>
    </footer>
</body>
</html>
