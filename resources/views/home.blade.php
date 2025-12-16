<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-7xl mx-auto px-6 py-12 mt-8">
            @auth
                <!-- Dashboard View -->
                <div class="mb-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
                    <p class="text-gray-600">Welkom terug, {{ auth()->user()->name }}!</p>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow p-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Snelle Acties</h2>
                    <div class="grid md:grid-cols-3 gap-4">
                        <a href="{{ route('events.index') }}" class="bg-gradient-to-br from-blue-50 to-blue-100 border-2 border-blue-200 rounded-lg p-6 text-left hover:border-blue-400 hover:shadow-md transition-all">
                            <div class="font-semibold text-gray-900 text-lg">Evenementen Bekijken</div>
                            <div class="text-sm text-gray-600 mt-2">Beheer alle evenementen</div>
                        </a>
                        <a href="#" class="bg-gradient-to-br from-purple-50 to-purple-100 border-2 border-purple-200 rounded-lg p-6 text-left hover:border-purple-400 hover:shadow-md transition-all">
                            <div class="font-semibold text-gray-900 text-lg">Mijn Bestellingen</div>
                            <div class="text-sm text-gray-600 mt-2">Bekijk bestelgeschiedenis</div>
                        </a>
                        <a href="{{ route('profile.edit') }}" class="bg-gradient-to-br from-green-50 to-green-100 border-2 border-green-200 rounded-lg p-6 text-left hover:border-green-400 hover:shadow-md transition-all">
                            <div class="font-semibold text-gray-900 text-lg">Account Instellingen</div>
                            <div class="text-sm text-gray-600 mt-2">Beheer je profiel</div>
                        </a>
                    </div>
                </div>
            @else
                <!-- Welcome View -->
                <div class="text-center py-16">
                    <h1 class="text-4xl font-bold text-gray-900 mb-4">Welkom bij FestiTickets</h1>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">Beheer je festival tickets en evenementen op één plek</p>
                    <p class="text-xl text-gray-600 mb-4 max-w-2xl mx-auto">Log in om alle evenementen te zien</p>
                    <a href="{{ route('login') }}" class="btn-primary px-6 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">Inloggen</a>
                    <a href="{{ route('register') }}" class="btn-primary px-6 py-2.5 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">Registreren</a>
                </div>

                <!-- Features -->
                <div class="mt-16">
                    <h2 class="text-2xl font-bold text-center text-gray-900 mb-12">Functies</h2>
                    <div class="grid md:grid-cols-3 gap-8">
                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Evenementen Beheer</h3>
                            <p class="text-gray-600 text-sm">Maak en beheer evenementen met gemak</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Ticket Systeem</h3>
                            <p class="text-gray-600 text-sm">Veilige ticket generatie en validatie</p>
                        </div>
                        <div class="bg-white p-6 rounded-lg shadow text-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-lg mx-auto mb-4 flex items-center justify-center">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                            </div>
                            <h3 class="font-semibold text-gray-900 mb-2">Betalingen Verwerken</h3>
                            <p class="text-gray-600 text-sm">Verwerk betalingen en bestellingen veilig</p>
                        </div>
                    </div>
                </div>
            @endauth
        </div>
    </div>
</x-layouts.app>

