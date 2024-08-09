<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\Whitelist as ModelsWhitelist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Whitelist extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $numberOfPaginatorsRendered = [];
    public $search = '';

    // Filter
    public $sortField = 'whitelists.created_at';
    public $sortDirection = 'desc';
    public $currentFilter = 'Terbaru';

    // Category
    public $categoryFilters = [];
    public $sortedCategoryFilters = [];

    // Whitelist
    public $article_id;


    public function mount($article_id = null)
    {
        if ($article_id) {
            $this->article_id = $article_id;
            $this->updateCounts();
        }
    }


    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == 'terbaru') {
            $this->sortField = 'whitelists.created_at';
            $this->sortDirection = 'desc';
            $this->currentFilter = 'Terbaru';
        } elseif ($field == 'terlama') {
            $this->sortField = 'whitelists.created_at';
            $this->sortDirection = 'asc';
            $this->currentFilter = 'Terlama';
        } elseif ($field == 'az') {
            $this->sortField = 'articles.title';
            $this->sortDirection = 'asc';
            $this->currentFilter = 'A - Z';
        }

        $this->resetPage();
    }


    public function whitelist($article_id)
    {
        $user_id = Auth::user()->id;
        $whitelist = ModelsWhitelist::where('article_id', $article_id)->where('user_id', $user_id)->first();

        if ($whitelist && $whitelist->whitelist) {
            $whitelist->delete();
        } else {
            ModelsWhitelist::updateOrCreate(
                ['article_id' => $article_id, 'user_id' => $user_id],
                ['whitelist' => true]
            );
        }
    }

    
    public function render()
    {
        $query = Article::join('whitelists', 'articles.id', '=', 'whitelists.article_id')
                ->where('whitelists.user_id', Auth::user()->id)
                ->where('title', 'like', '%'.$this->search.'%')
                ->select('articles.*');

        $categories = Category::orderBy('title', 'asc')->get();

        if (!empty($this->categoryFilters)) {
            $query->where(function ($query) {
                foreach ($this->categoryFilters as $category) {
                    $query->where('category', 'like', '%' . $category . '%');
                }
            });
        }

        $whitelisted = $query->orderBy($this->sortField, $this->sortDirection)->paginate(10);

        // Mengurutkan categoryFilters secara alfabetis
        $this->sortedCategoryFilters = $this->categoryFilters;
        sort($this->sortedCategoryFilters);

        return view('livewire.whitelist', [
            'whitelisted' => $whitelisted,
            'categories' => $categories,
            'currentFilter' => $this->currentFilter,
            'sortedCategoryFilters' => $this->sortedCategoryFilters
        ]);
    }
}
