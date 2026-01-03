<x-layouts.app>
    <div class="bg-gradient-to-br from-red-50 to-orange-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-2xl mx-auto px-6 py-12 mt-8">
            <!-- Failed Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-red-500 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Betaling Mislukt</h1>
                <p class="text-lg text-gray-600">Er ging iets mis met je betaling</p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-red-600 to-orange-600 p-4">
                    <h2 class="text-lg font-bold text-gray-100">Bestellingsdetails</h2>
                </div>

                <div class="p-6">
                    <div class="space-y-4">
                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Bestelnummer</span>
                            <span class="font-bold text-gray-900">{{ $order->order_number }}</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Evenement</span>
                            <span class="font-medium text-gray-900">{{ $order->event->name }}</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Aantal tickets</span>
                            <span class="font-medium text-gray-900">{{ $order->quantity }} {{ $order->quantity == 1 ? 'ticket' : 'tickets' }}</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Status</span>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Geannuleerd
                            </span>
                        </div>
                    </div>

                    <!-- Error Info -->
                    <div class="mt-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Waarom is mijn betaling mislukt?</h3>
                                <p class="text-sm text-gray-700 mb-2">
                                    Mogelijke oorzaken:
                                </p>
                                <ul class="text-sm text-gray-700 list-disc list-inside space-y-1">
                                    <li>Onvoldoende saldo op je rekening</li>
                                    <li>Betaling geannuleerd</li>
                                    <li>Betalingstijd verlopen</li>
                                    <li>Technische problemen</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Wat nu?</h3>
                <p class="text-gray-700 mb-4">
                    Geen zorgen! Je kunt het gewoon opnieuw proberen. Je tickets zijn nog steeds beschikbaar.
                </p>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Controleer of je voldoende saldo hebt
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Probeer een andere betaalmethode
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Neem contact op met je bank indien nodig
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('events.checkout', ['event' => $order->event, 'quantity' => $order->quantity]) }}" class="flex-1 text-center bg-blue-600 text-gray-100 px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Opnieuw Proberen
                </a>
                <a href="{{ route('events.index') }}" class="flex-1 text-center bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Terug naar Evenementen
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
