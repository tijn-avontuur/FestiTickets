<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class EventController extends Controller
{
    /**
     * Display admin dashboard for events.
     */
    public function index(): View
    {
        $events = Event::latest()->paginate(10);
        return view('admin.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new event.
     */
    public function create(): View
    {
        return view('admin.events.create');
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
            'total_tickets' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
        ]);

        Event::create($validated);

        return redirect()->route('admin.events.index')
            ->with('success', 'Evenement succesvol aangemaakt!');
    }

    /**
     * Show the form for editing the specified event.
     */
    public function edit(Event $event): View
    {
        return view('admin.events.edit', compact('event'));
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
            'total_tickets' => 'required|integer|min:1',
            'price' => 'required|numeric|min:0',
            'image_url' => 'nullable|url|max:255',
        ]);

        $event->update($validated);

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
