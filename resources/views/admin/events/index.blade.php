<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-7xl mx-auto px-6 py-12 mt-8">
            <!-- Header -->
            <div class="flex justify-between items-center mb-8">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Admin Dashboard - Evenementen</h1>
                    <p class="text-gray-600">Beheer alle evenementen in het systeem</p>
                </div>
                <div class="flex gap-3">
                    <a href="{{ route('admin.payments.index') }}" class="bg-purple-600 text-gray-100 px-6 py-3 rounded-lg font-semibold shadow-md hover:bg-purple-700 hover:shadow-lg transition-all">
                        💳 Betalingen
                    </a>
                    <a href="{{ route('admin.events.create') }}" class="btn-primary px-6 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                        + Nieuw Evenement
                    </a>
                </div>
            </div>

            <!-- Success Message -->
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded">
                    <p class="font-medium">{{ session('success') }}</p>
                </div>
            @endif

            <!-- Categories Section (Toggleable) -->
            <div class="mb-8" x-data="{ showCategories: false }">
                <!-- Toggle Button -->
                <button @click="showCategories = !showCategories" class="w-full bg-white rounded-lg shadow p-4 flex justify-between items-center hover:bg-gray-50 transition mb-4">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-blue-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        <h2 class="text-xl font-bold text-gray-900">Categorieën Beheren</h2>
                    </div>
                    <svg class="w-5 h-5 text-gray-600 transition-transform" :class="{'rotate-180': showCategories}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Categories Content (Hidden by default) -->
                <div x-show="showCategories" x-cloak x-transition class="bg-white rounded-lg shadow overflow-hidden">
                    <!-- Add New Category Form -->
                    <div class="border-b border-gray-200 p-6 bg-gray-50">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Nieuwe Categorie Toevoegen</h3>
                        <form action="{{ route('admin.categories.store') }}" method="POST" class="grid md:grid-cols-4 gap-4">
                            @csrf
                            <div>
                                <input type="text" name="name" placeholder="Naam *" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <input type="text" name="icon" placeholder="Emoji Icon (bijv. 🎧) *" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <input type="text" name="description" placeholder="Beschrijving *" required
                                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div>
                                <button type="submit" class="w-full btn-primary px-4 py-2 rounded-lg font-semibold">
                                    Toevoegen
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Categories Table -->
                    @if($categories->count() > 0)
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Icon</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Slug</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Beschrijving</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Evenementen</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50 transition" x-data="{ editing: false }">
                                        <template x-if="!editing">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-2xl">{{ $category->icon }}</div>
                                            </td>
                                        </template>
                                        <template x-if="editing">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <form :id="'edit-form-{{ $category->id }}'" action="{{ route('admin.categories.update', $category) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="text" name="icon" value="{{ $category->icon }}" class="w-16 px-2 py-1 text-center border border-gray-300 rounded">
                                                </form>
                                            </td>
                                        </template>

                                        <template x-if="!editing">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="text-sm font-medium text-gray-900">
                                                    {{ $category->name }}
                                                </div>
                                            </td>
                                        </template>
                                        <template x-if="editing">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="text" name="name" value="{{ $category->name }}" form="edit-form-{{ $category->id }}" class="w-full px-2 py-1 border border-gray-300 rounded">
                                            </td>
                                        </template>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $category->slug }}</div>
                                        </td>

                                        <template x-if="!editing">
                                            <td class="px-6 py-4">
                                                <div class="text-sm text-gray-600">{{ $category->description }}</div>
                                            </td>
                                        </template>
                                        <template x-if="editing">
                                            <td class="px-6 py-4">
                                                <input type="text" name="description" value="{{ $category->description }}" form="edit-form-{{ $category->id }}" class="w-full px-2 py-1 border border-gray-300 rounded">
                                            </td>
                                        </template>

                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-600">{{ $category->events->count() }}</div>
                                        </td>

                                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                            <template x-if="!editing">
                                                <button @click="editing = true" class="text-blue-600 hover:text-blue-900 mr-3">Bewerken</button>
                                            </template>
                                            <template x-if="editing">
                                                <div class="flex justify-end gap-2">
                                                    <button type="submit" form="edit-form-{{ $category->id }}" class="text-green-600 hover:text-green-900">Opslaan</button>
                                                    <button @click="editing = false" class="text-gray-600 hover:text-gray-900 mr-3">Annuleren</button>
                                                </div>
                                            </template>
                                            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je deze categorie wilt verwijderen?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="text-center py-8">
                            <p class="text-gray-500">Nog geen categorieën aangemaakt</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Events Table -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if($events->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Naam</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Locatie</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Datum</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tickets</th>
                                <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($events as $event)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <a href="{{ route('events.show', $event) }}" class="text-sm font-medium text-blue-600 hover:text-blue-900 hover:underline">
                                            {{ $event->name }}
                                        </a>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $event->location }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $event->date->format('d-m-Y H:i') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-semibold">€{{ number_format($event->price, 2, ',', '.') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-600">{{ $event->total_tickets }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="{{ route('admin.events.edit', $event) }}" class="text-blue-600 hover:text-blue-900 mr-3">Bewerken</a>
                                        <form action="{{ route('admin.events.destroy', $event) }}" method="POST" class="inline" onsubmit="return confirm('Weet je zeker dat je dit evenement wilt verwijderen?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">Verwijderen</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="px-6 py-4 bg-gray-50">
                        {{ $events->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">Geen evenementen</h3>
                        <p class="mt-1 text-sm text-gray-500">Begin met het aanmaken van je eerste evenement.</p>
                        <div class="mt-6">
                            <a href="{{ route('admin.events.create') }}" class="btn-primary px-6 py-2 rounded-lg font-semibold">
                                + Nieuw Evenement
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
