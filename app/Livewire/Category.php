<?php

namespace App\Livewire;

use App\Models\Category as ModelsCategory;
use Livewire\Component;
use Livewire\WithPagination;

class Category extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $numberOfPaginatorsRendered = [];
    public $search = '';

    // Filter
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $currentFilter = 'Terbaru';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == 'terbaru') {
            $this->sortField = 'created_at';
            $this->sortDirection = 'desc';
            $this->currentFilter = 'Terbaru';
        } elseif ($field == 'terlama') {
            $this->sortField = 'created_at';
            $this->sortDirection = 'asc';
            $this->currentFilter = 'Terlama';
        } elseif ($field == 'az') {
            $this->sortField = 'title';
            $this->sortDirection = 'asc';
            $this->currentFilter = 'A - Z';
        }

        $this->resetPage();
    }
    public function render()
    {
        $query = ModelsCategory::where('title', 'like', '%'.$this->search.'%');
        $categories = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        return view('livewire.category', [
            'categories' => $categories,
            'currentFilter' => $this->currentFilter
        ]);
    }
}
