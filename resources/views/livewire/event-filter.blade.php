<div>
    <!-- Search and Filter Section -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <!-- Search Bar -->
        <div class="mb-6">
            <div class="flex justify-between items-center mb-2">
                <label for="search" class="block text-sm font-medium text-gray-700">Zoeken</label>
                @if($search)
                    <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium transition">
                        Filters wissen
                    </button>
                @endif
            </div>
            <div class="relative">
                <input
                    type="text"
                    id="search"
                    wire:model.live.debounce.300ms="search"
                    placeholder="   Zoek op naam, locatie of beschrijving..."
                    class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
            </div>
        </div>

        <!-- Category Filter -->
        <div>
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-2 mb-3">
                <label class="block text-sm font-medium text-gray-700">Filter op Categorie</label>
                @if(count($selectedCategories) > 0)
                    <button wire:click="clearFilters" class="text-sm text-blue-600 hover:text-blue-800 hover:underline font-medium transition text-left sm:text-right">
                        Filters wissen
                    </button>
                @endif
            </div>
            <div class="flex-wrap gap-2">
                @foreach($categories as $category)
                    <button
                        wire:click="toggleCategory({{ $category->id }})"
                        class="inline-flex items-center px-3 py-1.5 sm:px-4 sm:py-2 rounded-full text-xs sm:text-sm font-medium transition-all
                            {{ in_array($category->id, $selectedCategories)
                                ? 'bg-blue-600 text-gray-700 shadow-md hover:bg-blue-700'
                                : 'bg-gray-100 text-gray-700 hover:bg-gray-200 hover:shadow-sm' }}">
                        @if($category->icon)
                            <span class="mr-1 sm:mr-1.5">{{ $category->icon }}</span>
                        @endif
                        <span class="whitespace-nowrap">{{ $category->name }}</span>
                    </button>
                @endforeach
            </div>
        </div>

        <!-- Active Filters Info -->
        @if($search || count($selectedCategories) > 0)
            <div class="mt-4 pt-4 border-t border-gray-200">
                <div class="flex items-center text-sm text-gray-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>{{ $events->total() }} {{ $events->total() === 1 ? 'evenement gevonden' : 'evenementen gevonden' }}</span>
                </div>
            </div>
        @endif
    </div>

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
                        <!-- Sold Out Badge -->
                        @if($event->total_tickets == 0)
                            <div class="absolute top-4 left-4 bg-red-600 text-gray-100 px-3 py-1 rounded-full shadow-lg font-bold text-sm">
                                UITVERKOCHT
                            </div>
                        @endif
                        <!-- Price Badge -->
                        <div class="absolute top-4 right-4 bg-white px-3 py-1 rounded-full shadow-lg">
                            <span class="text-lg font-bold text-gray-900">€{{ number_format($event->price, 2, ',', '.') }}</span>
                        </div>
                    </div>

                    <!-- Event Details -->
                    <div class="p-4">
                        <h3 class="text-lg font-bold text-gray-900 mb-2">{{ $event->name }}</h3>

                        <!-- Categories -->
                        @if($event->categories->count() > 0)
                            <div class="flex flex-wrap gap-1 mb-2">
                                @foreach($event->categories->take(3) as $category)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                        @if($category->icon)
                                            <span class="mr-0.5">{{ $category->icon }}</span>
                                        @endif
                                        {{ $category->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

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
                            @if($event->total_tickets == 0)
                                <span class="text-xs text-red-600 font-semibold">Uitverkocht</span>
                            @else
                                <span class="text-xs text-gray-500">{{ $event->total_tickets }} tickets beschikbaar</span>
                            @endif
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
        <div class="mt-8">
            {{ $events->links() }}
        </div>
    @else
        <!-- No Results -->
        <div class="bg-white rounded-lg shadow-md p-12 text-center">
            <svg class="mx-auto h-16 w-16 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <h3 class="text-xl font-semibold text-gray-900 mb-2">Geen evenementen gevonden</h3>
            <p class="text-gray-600 mb-4">Probeer andere zoektermen of filters</p>
            <button wire:click="clearFilters" class="btn-primary px-6 py-2 rounded-lg font-semibold">
                Filters wissen
            </button>
        </div>
    @endif
</div>
