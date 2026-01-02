<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-5xl mx-auto px-6 py-12 mt-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('events.index') }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Terug naar evenementen
                </a>
            </div>

            <!-- Event Detail Card -->
            <div class="bg-white rounded-lg shadow-lg overflow-hidden">
                <!-- Event Image -->
                <div class="h-96 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative">
                    @if($event->image_url)
                        <img src="{{ $event->image_url }}" alt="{{ $event->name }}" class="w-full h-full object-cover">
                    @else
                        <svg class="w-24 h-24 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                        </svg>
                    @endif
                </div>

                <!-- Event Content -->
                <div class="p-8">
                    <div class="grid md:grid-cols-2 gap-8">
                        <!-- Main Content -->
                        <div class="md:col-span-2">
                            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $event->name }}</h1>

                            <!-- Categories -->
                            @if($event->categories->count() > 0)
                                <div class="flex flex-wrap gap-2 mb-6">
                                    @foreach($event->categories as $category)
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                                            @if($category->icon)
                                                <span class="mr-1">{{ $category->icon }}</span>
                                            @endif
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </div>
                            @endif

                            <!-- Event Info -->
                            <div class="space-y-3 mb-6">
                                <!-- Date -->
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $event->date->format('l d F Y') }} om {{ $event->date->format('H:i') }} uur</span>
                                </div>

                                <!-- Location -->
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $event->location }}</span>
                                </div>

                                <!-- Tickets -->
                                <div class="flex items-center text-gray-700">
                                    <svg class="w-5 h-5 mr-3 flex-shrink-0 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                    </svg>
                                    <span class="font-medium">{{ $event->total_tickets }} tickets beschikbaar</span>
                                </div>
                            </div>

                            <!-- Description -->
                            <div class="border-t pt-6">
                                <h2 class="text-2xl font-bold text-gray-900 mb-4">Over dit evenement</h2>
                                <div class="prose prose-gray max-w-none">
                                    <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $event->description }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Sidebar - Ticket Purchase -->
                        <div class="md:col-span-1">
                            <div class="bg-gray-50 rounded-lg p-6 sticky top-8">
                                <div class="text-center mb-6">
                                    <div class="text-sm text-gray-600 mb-2">Prijs per ticket</div>
                                    <div class="text-4xl font-bold text-gray-900">€{{ number_format($event->price, 2, ',', '.') }}</div>
                                </div>

                                @auth
                                    @if($event->total_tickets > 0)
                                        <!-- Ticket Selection -->
                                        <div class="mb-6">
                                            <label for="quantity" class="block text-sm font-medium text-gray-700 mb-2">Aantal tickets</label>
                                            <select id="quantity" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                                                @for($i = 1; $i <= min(10, $event->total_tickets); $i++)
                                                    <option value="{{ $i }}">{{ $i }} {{ $i == 1 ? 'ticket' : 'tickets' }}</option>
                                                @endfor
                                            </select>
                                        </div>

                                        <!-- Buy Button -->
                                        <button class="w-full btn-primary px-6 py-4 rounded-lg font-bold text-lg shadow-lg hover:shadow-xl transition-all mb-4">
                                            Tickets Kopen
                                        </button>

                                        <div class="text-xs text-center text-gray-500">
                                            <svg class="w-4 h-4 inline-block mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                            </svg>
                                            Veilige betaling
                                        </div>
                                    @else
                                        <!-- Sold Out -->
                                        <div class="text-center mb-4">
                                            <div class="bg-red-100 border-2 border-red-500 rounded-lg p-6 mb-4">
                                                <svg class="w-12 h-12 mx-auto text-red-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                                </svg>
                                                <h3 class="text-2xl font-bold text-red-600 mb-2">UITVERKOCHT</h3>
                                                <p class="text-gray-700">Dit evenement is helaas uitverkocht</p>
                                            </div>
                                            <a href="https://www.ticketswap.nl/" target="_blank" class="block w-full bg-green-600 text-gray-900 px-6 py-4 rounded-lg font-bold text-lg hover:bg-green-700 transition">
                                                Bekijk TicketSwap
                                            </a>
                                            <p class="text-xs text-gray-500 mt-2">Misschien vind je nog tickets via doorverkoop</p>
                                        </div>
                                    @endif
                                @else
                                    <!-- Login Required -->
                                    <div class="text-center mb-4">
                                        <p class="text-sm text-gray-600 mb-4">Je moet ingelogd zijn om tickets te kopen</p>
                                        <a href="{{ route('login') }}" class="block w-full bg-blue-600 text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-blue-700 transition mb-3">
                                            Inloggen
                                        </a>
                                        <a href="{{ route('register') }}" class="block w-full bg-white border-2 border-gray-300 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-50 transition">
                                            Account aanmaken
                                        </a>
                                    </div>
                                @endauth

                                <!-- Event Stats -->
                                <div class="border-t pt-6 mt-6">
                                    <div class="grid grid-cols-2 gap-4 text-center">
                                        <div>
                                            <div class="text-2xl font-bold text-gray-900">{{ $event->total_tickets }}</div>
                                            <div class="text-xs text-gray-600">Beschikbaar</div>
                                        </div>
                                        <div>
                                            <div class="text-2xl font-bold text-green-600">{{ ucfirst($event->date->diffForHumans()) }}</div>
                                            <div class="text-xs text-gray-600">{{ $event->date->format('d-m-Y H:i') }}</div>
                                            <div class="text-xs text-gray-600">Begint</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- More Events Section -->
            <div class="mt-12">
                <h2 class="text-2xl font-bold text-gray-900 mb-6">Andere evenementen</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $relatedEvents = \App\Models\Event::where('id', '!=', $event->id)->latest()->take(3)->get();
                    @endphp

                    @foreach($relatedEvents as $relatedEvent)
                        <a href="{{ route('events.show', $relatedEvent) }}" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow">
                            <div class="h-32 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center relative">
                                @if($relatedEvent->image_url)
                                    <img src="{{ $relatedEvent->image_url }}" alt="{{ $relatedEvent->name }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-8 h-8 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-4">
                                <h3 class="font-bold text-gray-900 mb-1">{{ $relatedEvent->name }}</h3>
                                <p class="text-sm text-gray-600">{{ $relatedEvent->date->format('d-m-Y') }}</p>
                                <p class="text-lg font-bold text-gray-900 mt-2">€{{ number_format($relatedEvent->price, 2, ',', '.') }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
