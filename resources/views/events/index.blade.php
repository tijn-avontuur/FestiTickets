<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-7xl mx-auto px-6 py-12 mt-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Aankomende Evenementen</h1>
                <p class="text-gray-600">Ontdek de beste festivals en evenementen bij jou in de buurt</p>
            </div>

            <!-- Login Required Message for Guests -->
            @guest
                <div class="bg-blue-50 border-l-4 border-blue-500 text-blue-700 p-6 mb-8 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div>
                            <h3 class="font-semibold text-lg mb-2">Account vereist</h3>
                            <p class="mb-3">Je moet ingelogd zijn om alle evenementen te bekijken en tickets te kopen.</p>
                            <div class="flex gap-3">
                                <a href="{{ route('login') }}" class="bg-blue-600 text-gray-100 px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Inloggen</a>
                                <a href="{{ route('register') }}" class="bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">Account aanmaken</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

            <!-- Livewire Event Filter Component -->
            <livewire:event-filter />
        </div>
    </div>
</x-layouts.app>
