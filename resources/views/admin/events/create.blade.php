<x-layouts.app>
    <div class="bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-3xl mx-auto px-6 py-12 mt-8">
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Nieuw Evenement Aanmaken</h1>
                <p class="text-gray-600">Vul de onderstaande gegevens in om een nieuw evenement toe te voegen</p>
            </div>

            <!-- Form -->
            <div class="bg-white rounded-lg shadow p-8">
                <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <!-- Name -->
                    <div class="mb-6">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">Naam *</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('name') border-red-500 @enderror">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Description -->
                    <div class="mb-6">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">Beschrijving *</label>
                        <textarea name="description" id="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Location -->
                    <div class="mb-6">
                        <label for="location" class="block text-sm font-medium text-gray-700 mb-2">Locatie *</label>
                        <input type="text" name="location" id="location" value="{{ old('location') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('location') border-red-500 @enderror">
                        @error('location')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Date -->
                    <div class="mb-6">
                        <label for="date" class="block text-sm font-medium text-gray-700 mb-2">Datum & Tijd *</label>
                        <input type="datetime-local" name="date" id="date" value="{{ old('date') }}"
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
                            <input type="number" name="price" id="price" value="{{ old('price') }}" step="0.01" min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('price') border-red-500 @enderror">
                            @error('price')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Total Tickets -->
                        <div>
                            <label for="total_tickets" class="block text-sm font-medium text-gray-700 mb-2">Totaal Tickets *</label>
                            <input type="number" name="total_tickets" id="total_tickets" value="{{ old('total_tickets') }}" min="0"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('total_tickets') border-red-500 @enderror">
                            @error('total_tickets')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Image URL -->
                    <div class="mb-6">
                        <label for="image_url" class="block text-sm font-medium text-gray-700 mb-2">Afbeelding URL (optioneel)</label>
                        <input type="url" name="image_url" id="image_url" value="{{ old('image_url') }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('image_url') border-red-500 @enderror">
                        @error('image_url')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Event Images Upload -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Afbeeldingen Uploaden (max 5)</label>
                        <input type="file" name="images[]" id="images" multiple accept="image/*"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 @error('images') border-red-500 @enderror"
                            onchange="previewImages(event)">
                        @error('images')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        @error('images.*')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Selecteer maximaal 5 afbeeldingen (JPG, PNG, max 2MB per afbeelding)</p>

                        <!-- Image Preview -->
                        <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-5 gap-3"></div>
                    </div>

                    <!-- Categories -->
                    <div class="mb-8">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Categorieën</label>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($categories as $category)
                                <label class="flex items-center p-3 border border-gray-300 rounded-lg hover:bg-gray-50 cursor-pointer">
                                    <input type="checkbox" name="categories[]" value="{{ $category->id }}"
                                        {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}
                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                    <span class="ml-2 text-sm text-gray-700">
                                        @if($category->icon)
                                            <span class="mr-1">{{ $category->icon }}</span>
                                        @endif
                                        {{ $category->name }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                        @error('categories')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Buttons -->
                    <div class="flex items-center gap-4">
                        <button type="submit" class="btn-primary px-8 py-3 rounded-lg font-semibold shadow-md hover:shadow-lg transition-all">
                            Evenement Aanmaken
                        </button>
                        <a href="{{ route('admin.events.index') }}" class="text-gray-600 hover:text-gray-900 px-6 py-3 rounded-lg border-2 border-gray-300 hover:border-gray-400 transition">
                            Annuleren
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function previewImages(event) {
            const preview = document.getElementById('imagePreview');
            preview.innerHTML = '';
            const files = event.target.files;

            if (files.length > 5) {
                alert('Maximaal 5 afbeeldingen toegestaan');
                event.target.value = '';
                return;
            }

            for (let i = 0; i < files.length; i++) {
                const file = files[i];
                const reader = new FileReader();

                reader.onload = function(e) {
                    const div = document.createElement('div');
                    div.className = 'relative';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-300">
                        <div class="absolute top-1 right-1 bg-blue-600 text-white text-xs px-2 py-1 rounded">${i + 1}</div>
                    `;
                    preview.appendChild(div);
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
</x-layouts.app>
