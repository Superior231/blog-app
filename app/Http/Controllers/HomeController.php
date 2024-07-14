<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LikeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Livewire\Livewire;

class HomeController extends Controller
{   
    public function index()
    {
        $articles = Article::with('like_articles')
                    ->orderBy('created_at', 'desc')
                    ->paginate(9);

        return view('pages.home', [
            'title' => 'Blog App',
            'active' => 'home',
            'articles' => $articles
        ]);
    }

    public function detail($slug)
    {
        $article = Article::where('slug', $slug)->first();

        $user_id = Auth::id();
        $likeCount = LikeArticle::where('article_id', $article->id)->where('like', true)->count();
        $dislikeCount = LikeArticle::where('article_id', $article->id)->where('dislike', true)->count();
        $liked = LikeArticle::where('article_id', $article->id)
                ->where('user_id', $user_id)
                ->where('like', true)
                ->exists();
        $disliked = LikeArticle::where('article_id', $article->id)
                ->where('user_id', $user_id)
                ->where('dislike', true)
                ->exists();

        return view('pages.detail', [
            'title' => 'Blog App - ' . $article->title,
            'active' => 'home',
            'article' => $article,
            'likeCount' => $likeCount,
            'dislikeCount' => $dislikeCount,
            'liked' => $liked,
            'disliked' => $disliked
        ]);
    }
}
