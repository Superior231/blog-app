<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\LikeArticle as Like;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class LikeArticle extends Component
{
    public $likeCount = 0;
    public $dislikeCount = 0;
    public $liked = false;
    public $disliked = false;
    public $article_id;
    
    public function mount($article_id)
    {
        // Inisialisasi data like dan dislike
        $this->article_id = $article_id;
        $this->updateCounts($article_id);
    }
    
    private function updateCounts($article_id)
    {
        $this->likeCount = Like::where('article_id', $article_id)->where('like', true)->count();
        $this->dislikeCount = Like::where('article_id', $article_id)->where('dislike', true)->count();
        $this->liked = Auth::check() && Like::where('article_id', $article_id)->where('user_id', Auth::id())->where('like', true)->exists();
        $this->disliked = Auth::check() && Like::where('article_id', $article_id)->where('user_id', Auth::id())->where('dislike', true)->exists();
    }
    
    public function like($article_id)
    {
        $user_id = Auth::user()->id;
    
        $like = Like::where('article_id', $article_id)
                ->where('user_id', $user_id)
                ->first();
    
        if ($like && $like->like) {
            $like->delete();

        } else {
            Like::updateOrCreate(
                ['article_id' => $article_id, 'user_id' => $user_id],
                ['like' => true, 'dislike' => false]
            );
        }

        $this->updateCounts($article_id);
    }
    
    public function dislike($article_id)
    {
        $user_id = Auth::user()->id;
    
        $like = Like::where('article_id', $article_id)
                ->where('user_id', $user_id)
                ->first();
    
        if ($like && $like->dislike) {
            $like->delete();

        } else {
            Like::updateOrCreate(
                ['article_id' => $article_id, 'user_id' => $user_id],
                ['like' => false, 'dislike' => true]
            );
        }

        $this->updateCounts($article_id);
    }


    public function render()
    {
        $total_comments = Comment::where('article_id', $this->article_id)->count();

        return view('livewire.like-article', [
            'total_comments' => $total_comments
        ]);
    }
}
