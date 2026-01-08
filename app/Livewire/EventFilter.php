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
    public $sortBy = 'date_asc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCategories' => ['except' => []],
        'sortBy' => ['except' => 'date_asc'],
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
            });

        // Apply sorting
        switch ($this->sortBy) {
            case 'price_asc':
                $events->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $events->orderBy('price', 'desc');
                break;
            case 'date_desc':
                $events->orderBy('date', 'desc');
                break;
            case 'date_asc':
            default:
                $events->orderBy('date', 'asc');
                break;
        }

        $events = $events->paginate(9);

        return view('livewire.event-filter', [
            'events' => $events,
            'categories' => $categories,
        ]);
    }
}
