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
                                <a href="{{ route('login') }}" class="bg-blue-600 text-white px-6 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">Inloggen</a>
                                <a href="{{ route('register') }}" class="bg-white border-2 border-blue-600 text-blue-600 px-6 py-2 rounded-lg font-semibold hover:bg-blue-50 transition">Account aanmaken</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endguest

            <!-- Events Grid -->
            @if($events->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
                    @foreach($events as $event)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow max-w-sm">
                            <!-- Event Image -->
                            <div class="h-40 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative">
                                @if($event->image_url)
                                    <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-10 h-10 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                @endif
                                <!-- Price Badge -->
                                <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full shadow-lg">
                                    <span class="text-lg font-bold text-gray-900">€{{ number_format($event->price, 2, ',', '.') }}</span>
                                </div>
                            </div>

                            <!-- Event Details -->
                            <div class="p-4">
                                <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $event->name }}</h3>

                                <!-- Location -->
                                <div class="flex items-center text-gray-600 mb-1">
                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $event->location }}</span>
                                </div>

                                <!-- Date -->
                                <div class="flex items-center text-gray-600 mb-3">
                                    <svg class="w-4 h-4 mr-1.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="text-sm">{{ $event->date->format('d-m-Y H:i') }}</span>
                                </div>

                                <!-- Description -->
                                <p class="text-gray-600 text-sm mb-3 line-clamp-2">{{ Str::limit($event->description, 80) }}</p>

                                <!-- Tickets Available -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="text-xs text-gray-500">{{ $event->total_tickets }} tickets beschikbaar</span>
                                </div>

                                <!-- Buy Button -->
                                <a href="{{ route('events.show', $event) }}" class="block w-full text-center btn-primary px-4 py-2.5 rounded-lg font-semibold text-sm shadow-md hover:shadow-lg transition-all">
                                    Meer Info
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="flex justify-center">
                    {{ $events->links() }}
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-lg shadow">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900">Geen evenementen beschikbaar</h3>
                    <p class="mt-2 text-sm text-gray-500">Op dit moment zijn er geen evenementen gepland. Kom later terug!</p>
                </div>
            @endif
        </div>
    </div>
</x-layouts.app>
