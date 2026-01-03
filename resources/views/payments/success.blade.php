<x-layouts.app>
    <div class="bg-gradient-to-br from-green-50 to-blue-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-2xl mx-auto px-6 py-12 mt-8">
            <!-- Success Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-green-500 rounded-full mb-4">
                    <svg class="w-12 h-12 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Betaling Gelukt!</h1>
                <p class="text-lg text-gray-600">Je tickets zijn succesvol besteld</p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-green-600 to-blue-600 p-4">
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
                            <span class="text-gray-600">Datum</span>
                            <span class="font-medium text-gray-900">{{ $order->event->date->format('d F Y, H:i') }} uur</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Locatie</span>
                            <span class="font-medium text-gray-900">{{ $order->event->location }}</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Aantal tickets</span>
                            <span class="font-medium text-gray-900">{{ $order->quantity }} {{ $order->quantity == 1 ? 'ticket' : 'tickets' }}</span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Totaal betaald</span>
                            <span class="font-bold text-green-600 text-xl">€{{ number_format($order->total_amount, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Email Notification -->
                    <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Bevestigingsmail verzonden</h3>
                                <p class="text-sm text-gray-700">
                                    We hebben een bevestigingsmail met je tickets gestuurd naar <strong>{{ auth()->user()->email }}</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Wat nu?</h3>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Controleer je inbox voor de bevestigingsmail met QR-codes
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Bewaar je tickets veilig (print of op je telefoon)
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Toon je QR-code bij de ingang van het evenement
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Veel plezier bij {{ $order->event->name }}!
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route('events.index') }}" class="flex-1 text-center bg-blue-600 text-gray-100 px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    Naar Evenementen
                </a>
                <a href="{{ route('events.show', $order->event) }}" class="flex-1 text-center bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Evenement Bekijken
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
