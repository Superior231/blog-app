<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Dashboard extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $numberOfPaginatorsRendered = [];
    public $search = '';

    // Filter
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $currentFilter = 'Terbaru';

    // category
    public $categoryFilters = [];
    public $sortedCategoryFilters = [];

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
        $user = Auth::user();
        $query = Article::where('title', 'like', '%'.$this->search.'%');
        $categories = Category::orderBy('title', 'asc')->get();
        
        if (!empty($this->categoryFilters)) {
            $query->where(function ($query) {
                foreach ($this->categoryFilters as $category) {
                    $query->where('category', 'like', '%' . $category . '%');
                }
            });
        }

        $articles = $query->where('user_id', $user->id)->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        // Mengurutkan categoryFilters secara alfabetis
        $this->sortedCategoryFilters = $this->categoryFilters;
        sort($this->sortedCategoryFilters);

        return view('livewire.dashboard', [
            'articles' => $articles,
            'categories' => $categories,
            'currentFilter' => $this->currentFilter,
            'sortedCategoryFilters' => $this->sortedCategoryFilters
        ]);
    }
}
