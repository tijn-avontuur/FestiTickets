<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventImage;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;

class EventController extends Controller
{
    /**
     * Display admin dashboard for events.
     */
    public function index(): View
    {
        $events = Event::latest()->paginate(10);
        $categories = Category::all();
        return view('admin.events.index', compact('events', 'categories'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        $categories = Category::all();
        return view('admin.events.create', compact('categories'));
    }

    /**
     * Store a newly created event in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'total_tickets' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
        ]);

        $event = Event::create($validated);

        // Attach categories if provided
        if ($request->has('categories')) {
            $event->categories()->attach($request->categories);
        }

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('event-images', 'public');
                EventImage::create([
                    'event_id' => $event->id,
                    'path' => $path,
                    'order' => $index + 1,
                ]);
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Evenement succesvol aangemaakt!');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        $categories = Category::all();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    /**
     * Update the specified event in storage.
     */
    public function update(Request $request, Event $event): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'location' => 'required|string|max:255',
            'date' => 'required|date',
            'total_tickets' => 'required|integer|min:0',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
            'categories' => 'nullable|array',
            'categories.*' => 'exists:categories,id',
            'images' => 'nullable|array|max:5',
            'images.*' => 'image|mimes:jpeg,jpg,png|max:2048',
            'delete_images' => 'nullable|array',
            'delete_images.*' => 'exists:event_images,id',
        ]);

        $event->update($validated);

        // Sync categories (removes old ones and adds new ones)
        $event->categories()->sync($request->categories ?? []);

        // Delete selected images
        if ($request->has('delete_images')) {
            foreach ($request->delete_images as $imageId) {
                $image = EventImage::find($imageId);
                if ($image && $image->event_id === $event->id) {
                    Storage::disk('public')->delete($image->path);
                    $image->delete();
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            $currentImageCount = $event->images()->count();
            $maxOrder = $event->images()->max('order') ?? 0;

            foreach ($request->file('images') as $index => $image) {
                if ($currentImageCount + $index + 1 <= 5) {
                    $path = $image->store('event-images', 'public');
                    EventImage::create([
                        'event_id' => $event->id,
                        'path' => $path,
                        'order' => $maxOrder + $index + 1,
                    ]);
                }
            }
        }

        return redirect()->route('admin.events.index')
            ->with('success', 'Evenement succesvol bijgewerkt!');
    }

    /**
     * Remove the specified event from storage.
     */
    public function destroy(Event $event): RedirectResponse
    {
        $event->delete();

        return redirect()->route('admin.events.index')
            ->with('success', 'Evenement succesvol verwijderd!');
    }
}
