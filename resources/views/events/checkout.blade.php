<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-4xl mx-auto px-6 py-12 mt-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Afrekenen</h1>
                <p class="text-gray-600">Controleer je bestelling en ga door naar betaling</p>
            </div>

            <div class="grid md:grid-cols-2 gap-8">
                <!-- Order Summary (Main Content) -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Event Info Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <div class="flex gap-4">
                                <!-- Event Details -->
                                <div class="flex-1">
                                    <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $event->name }}</h3>

                                    <div class="space-y-1 text-sm text-gray-600">
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            {{ $event->date->format('l d F Y') }} om {{ $event->date->format('H:i') }} uur
                                        </div>
                                        <div class="flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            </svg>
                                            {{ $event->location }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Customer Information Card -->
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-gray-900 mb-4">Jouw Gegevens</h2>

                            <div class="space-y-3 text-sm">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Naam</span>
                                    <span class="font-medium text-gray-900">{{ auth()->user()->name }}</span>
                                </div>
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Email</span>
                                    <span class="font-medium text-gray-900">{{ auth()->user()->email }}</span>
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-4">
                                <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Je tickets worden verstuurd naar dit e-mailadres
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Order Summary Sidebar -->
                <div class="md:col-span-1">
                    <div class="bg-white rounded-lg shadow-md overflow-hidden sticky top-8">
                        <div class="bg-gradient-to-r from-blue-600 to-purple-600 p-4">
                            <h2 class="text-lg font-bold text-gray-100">Bestelling Overzicht</h2>
                        </div>

                        <div class="p-6">
                            <!-- Ticket Details -->
                            <div class="space-y-4 mb-6">
                                <div class="flex justify-between items-center pb-3 border-b">
                                    <div>
                                        <p class="text-sm text-gray-600">Aantal tickets</p>
                                        <p class="font-medium text-gray-900">{{ $quantity }} {{ $quantity == 1 ? 'ticket' : 'tickets' }}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs text-gray-500">€{{ number_format($ticketPrice, 2, ',', '.') }} p/st</p>
                                        <p class="font-semibold text-gray-900">€{{ number_format($subtotal, 2, ',', '.') }}</p>
                                    </div>
                                </div>

                                <div class="flex justify-between items-center pb-3 border-b">
                                    <div>
                                        <p class="text-sm text-gray-600">Service kosten</p>
                                        <p class="text-xs text-gray-500">{{ $serviceFeePercentage }}% van totaal</p>
                                    </div>
                                    <p class="font-semibold text-gray-900">€{{ number_format($serviceFee, 2, ',', '.') }}</p>
                                </div>
                            </div>

                            <!-- Total -->
                            <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-lg mb-6">
                                <div class="flex justify-between items-center">
                                    <div>
                                        <p class="text-sm text-gray-600 mb-1">Totaal te betalen</p>
                                        <p class="text-xs text-gray-500">Inclusief BTW</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-2xl font-bold text-gray-900">€{{ number_format($total, 2, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <form action="{{ route('payment.create', $event) }}" method="POST">
                                @csrf
                                <input type="hidden" name="quantity" value="{{ $quantity }}">

                                <div class="space-y-3">
                                    <button type="submit" class="w-full btn-primary px-6 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition-all">
                                        Doorgaan naar Betaling
                                    </button>

                                    <a href="{{ route('events.show', $event) }}" class="block w-full text-center bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                                        Terug naar evenement
                                    </a>
                                </div>
                            </form>

                            <!-- Security Notice -->
                            <div class="mt-6 pt-6 border-t mt-4">
                                <div class="flex items-start gap-2 text-xs text-gray-500 mt-4">
                                    <svg class="w-4 h-4 flex-shrink-0 mt-0.5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                    <div>
                                        <p class="font-medium text-gray-700 mb-1">Veilige betaling</p>
                                        <p>Je betaling wordt beveiligd verwerkt via Mollie. We slaan geen creditcardgegevens op.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Terms and Conditions -->
            <div class="mt-8 bg-white rounded-lg shadow-md p-6">
                <h3 class="font-bold text-gray-900 mb-3">Voorwaarden</h3>
                <ul class="space-y-2 text-sm text-gray-600">
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tickets zijn geldig voor de aangegeven datum en locatie
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Je ontvangt een bevestigingsmail met QR-codes
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Tickets zijn niet overdraagbaar zonder toestemming
                    </li>
                    <li class="flex items-start">
                        <svg class="w-5 h-5 mr-2 flex-shrink-0 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Bij annulering gelden de algemene voorwaarden
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
