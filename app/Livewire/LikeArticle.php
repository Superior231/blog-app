<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\LikeArticle as ModelsLikeArticle;
use App\Models\Whitelist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeArticle extends Component
{
    public $likeCount = 0;
    public $liked = false;
    public $whitelistCount = 0;
    public $whitelisted = false;
    public $article_id;

    public function mount($article_id)
    {
        // Inisialisasi data like dan dislike
        $this->article_id = $article_id;
        $this->updateCounts();
    }

    private function updateCounts()
    {
        $this->likeCount = ModelsLikeArticle::where('article_id', $this->article_id)
                        ->where('like', true)
                        ->count();
        $this->liked = Auth::check() && ModelsLikeArticle::where('article_id', $this->article_id)
                        ->where('user_id', Auth::id())
                        ->where('like', true)
                        ->exists();

        $this->whitelistCount = Whitelist::where('article_id', $this->article_id)
                        ->where('whitelist', true)
                        ->count();
        $this->whitelisted = Auth::check() && Whitelist::where('article_id', $this->article_id)
                        ->where('user_id', Auth::id())
                        ->where('whitelist', true)
                        ->exists();
    }

    public function like()
    {
        $user_id = Auth::user()->id;
        $like = ModelsLikeArticle::where('article_id', $this->article_id)
                ->where('user_id', $user_id)
                ->first();

        if ($like && $like->like) {
            $like->delete();
        } else {
            ModelsLikeArticle::updateOrCreate(
                ['article_id' => $this->article_id, 'user_id' => $user_id],
                ['like' => true]
            );
        }

        $this->updateCounts();
    }


    public function whitelist()
    {
        $user_id = Auth::user()->id;
        $whitelist = Whitelist::where('article_id', $this->article_id)
                ->where('user_id', $user_id)
                ->first();

        if ($whitelist && $whitelist->whitelist) {
            $whitelist->delete();
        } else {
            Whitelist::updateOrCreate(
                ['article_id' => $this->article_id, 'user_id' => $user_id],
                ['whitelist' => true]
            );
        }

        $this->updateCounts();
    }

    public function render()
    {
        $total_comments = Comment::where('article_id', $this->article_id)->count();

        return view('livewire.like-article', [
            'total_comments' => $total_comments
        ]);
    }
}
