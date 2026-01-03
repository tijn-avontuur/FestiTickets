<x-layouts.app>
    <div class="bg-gradient-to-br from-yellow-50 to-orange-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-2xl mx-auto px-6 py-12 mt-8">
            <!-- Pending Icon -->
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-yellow-500 rounded-full mb-4 animate-pulse">
                    <svg class="w-12 h-12 text-gray-100" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h1 class="text-4xl font-bold text-gray-900 mb-2">Betaling In Behandeling</h1>
                <p class="text-lg text-gray-600">We wachten op bevestiging van je betaling</p>
            </div>

            <!-- Order Details Card -->
            <div class="bg-white rounded-lg shadow-xl overflow-hidden mb-6">
                <div class="bg-gradient-to-r from-yellow-600 to-orange-600 p-4">
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
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                                </svg>
                                In behandeling
                            </span>
                        </div>

                        <div class="flex justify-between pb-3 border-b">
                            <span class="text-gray-600">Totaal bedrag</span>
                            <span class="font-bold text-gray-900 text-xl">€{{ number_format($order->total_amount, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Pending Info -->
                    <div class="mt-6 bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-yellow-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold text-gray-900 mb-1">Wat betekent dit?</h3>
                                <p class="text-sm text-gray-700">
                                    Je betaling wordt momenteel verwerkt. Dit kan enkele minuten duren. We sturen je een bevestigingsmail zodra de betaling is voltooid.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Next Steps -->
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <h3 class="font-bold text-gray-900 mb-4 text-lg">Wat moet ik doen?</h3>
                <ul class="space-y-3 text-sm text-gray-700">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Wacht rustig af tot de betaling is verwerkt
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Controleer je email voor de bevestiging
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Vernieuw deze pagina over enkele minuten
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Neem contact op bij vragen
                    </li>
                </ul>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4">
                <button onclick="window.location.reload()" class="flex-1 text-center bg-blue-600 text-gray-100 px-6 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
                    <svg class="w-5 h-5 inline-block mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Pagina Verversen
                </button>
                <a href="{{ route('events.index') }}" class="flex-1 text-center bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                    Terug naar Evenementen
                </a>
            </div>
        </div>
    </div>
</x-layouts.app>
