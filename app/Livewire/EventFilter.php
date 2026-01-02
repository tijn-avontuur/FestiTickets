<?php

namespace App\Livewire;

use App\Models\Event;
use App\Models\Category;
use Livewire\Component;
use Livewire\WithPagination;

class EventFilter extends Component
{
    use WithPagination;

    public $search = '';
    public $selectedCategories = [];

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingSelectedCategories()
    {
        $this->resetPage();
    }

    public function toggleCategory($categoryId)
    {
        if (in_array($categoryId, $this->selectedCategories)) {
            $this->selectedCategories = array_diff($this->selectedCategories, [$categoryId]);
        } else {
            $this->selectedCategories[] = $categoryId;
        }
        $this->resetPage();
    }

    public function clearFilters()
    {
        $this->reset(['search', 'selectedCategories']);
        $this->resetPage();
    }

    public function render()
    {
        $categories = Category::all();

        $events = Event::query()
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('location', 'like', '%' . $this->search . '%')
                      ->orWhere('description', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->selectedCategories, function ($query) {
                // Use AND logic - event must have ALL selected categories
                foreach ($this->selectedCategories as $categoryId) {
                    $query->whereHas('categories', function ($q) use ($categoryId) {
                        $q->where('categories.id', $categoryId);
                    });
                }
            })
            ->orderBy('date', 'asc')
            ->paginate(9);

        return view('livewire.event-filter', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }
}
