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

            <!-- Download Ticket Section -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 mb-6 text-center">
                <div class="mb-4">
                    <svg class="w-16 h-16 mx-auto text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                    </svg>
                </div>
                <h3 class="text-2xl font-bold text-gray-100 mb-2">Download je Ticket</h3>
                <p class="text-blue-100 mb-6">Je PDF ticket met QR-code is klaar om te downloaden</p>

                <div class="flex flex-col sm:flex-row gap-3 justify-center">
                    <a href="{{ route('order.ticket.preview', $order) }}"
                       target="_blank"
                       class="inline-flex items-center justify-center gap-2 bg-white text-purple-600 px-6 py-3 rounded-lg font-semibold hover:bg-gray-100 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                        Bekijk Ticket
                    </a>
                    <a href="{{ route('order.ticket.download', $order) }}"
                       class="inline-flex items-center justify-center gap-2 bg-green-500 text-gray-100 px-6 py-3 rounded-lg font-semibold hover:bg-green-600 transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                        </svg>
                        Download PDF
                    </a>
                </div>
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
