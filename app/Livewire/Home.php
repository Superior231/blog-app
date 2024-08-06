<?php

namespace App\Livewire;

use App\Models\Article;
use App\Models\Category;
use App\Models\Comment;
use App\Models\LikeArticle;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Home extends Component
{
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    public $numberOfPaginatorsRendered = [];
    public $search = '';

    // Filter
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    public $currentFilter = 'Terbaru';

    // Category
    public $categoryFilters = [];
    public $sortedCategoryFilters = [];

    // Like
    public $likeCount = 0;
    public $liked = false;
    public $article_id;


    public function mount($article_id = null)
    {
        if ($article_id) {
            $this->article_id = $article_id;
            $this->updateCounts();
        }
    }

    private function updateCounts()
    {
        if ($this->article_id) {
            $this->likeCount = LikeArticle::where('article_id', $this->article_id)->where('like', true)->count();
            $this->liked = Auth::check() && LikeArticle::where('article_id', $this->article_id)->where('user_id', Auth::id())->where('like', true)->exists();
        }
    }

    public function like($article_id)
    {
        $user_id = Auth::user()->id;
        $like = LikeArticle::where('article_id', $article_id)->where('user_id', $user_id)->first();

        if ($like && $like->like) {
            $like->delete();
        } else {
            LikeArticle::updateOrCreate(
                ['article_id' => $article_id, 'user_id' => $user_id],
                ['like' => true]
            );
        }

        $this->updateCounts();
    }


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
        $query = Article::where('title', 'like', '%'.$this->search.'%');
        $categories = Category::orderBy('title', 'asc')->get();

        if (!empty($this->categoryFilters)) {
            $query->where(function ($query) {
                foreach ($this->categoryFilters as $category) {
                    $query->where('category', 'like', '%' . $category . '%');
                }
            });
        }

        $articles = $query->orderBy($this->sortField, $this->sortDirection)->paginate(6);

        // Mengurutkan categoryFilters secara alfabetis
        $this->sortedCategoryFilters = $this->categoryFilters;
        sort($this->sortedCategoryFilters);

        return view('livewire.home', [
            'articles' => $articles,
            'categories' => $categories,
            'currentFilter' => $this->currentFilter,
            'sortedCategoryFilters' => $this->sortedCategoryFilters
        ]);
    }
}
