<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-3xl mx-auto px-6 py-12 mt-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Evenement Bewerken</h1>
                <p class="text-gray-600">Pas de gegevens van het evenement aan</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-8">
                <form action="{{ route('events.update', $event) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Naam *</label>
                        <input type="text" name="name" id="name" value="{{ old('name', $event->name) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Beschrijving *</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description', $event->description) }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Locatie *</label>
                        <input type="text" name="location" id="location" value="{{ old('location', $event->location) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Datum & Tijd *</label>
                        <input type="datetime-local" name="date" id="date" value="{{ old('date', $event->date->format('Y-m-d\TH:i')) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('date') border-red-500 @enderror">
                        @error('date')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Price and Tickets Row -->
                    <div class="grid md:grid-cols-2 gap-6 mb-6">
                        <!-- Price -->
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-2">Prijs (€) *</label>
                            <input type="number" name="price" id="price" value="{{ old('price', $event->price) }}" step="0.01" min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Tickets -->
                        <div>
                            <label for="total_tickets" class="block text-sm font-medium text-gray-700 mb-2">Totaal Tickets *</label>
                            <input type="number" name="total_tickets" id="total_tickets" value="{{ old('total_tickets', $event->total_tickets) }}" min="1"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('total_tickets') border-red-500 @enderror">
                            @error('total_tickets')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div class="mb-8">
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">Afbeelding URL (optioneel)</label>
                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url', $event->image_url) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror">
                        @error('image_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                            Wijzigingen Opslaan
                        </button>
                        <a href="{{ route('events.index') }}" class="text-gray-600 hover:text-gray-900 px-6 py-3 rounded-lg border-2 border-gray-300 hover:border-gray-400 transition">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
