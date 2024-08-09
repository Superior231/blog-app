<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LikeArticle;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{   
    public function index()
    {
        return view('pages.home', [
            'title' => 'Blog App',
            'active' => 'home',
        ]);
    }

    public function detail($slug)
    {
        $article = Article::where('slug', $slug)->with('comments')->firstOrFail();
        $user_id = Auth::id();
        $author = $article->user;

        $likeCount = LikeArticle::where('article_id', $article->id)->where('like', true)->count();
        $liked = LikeArticle::where('article_id', $article->id)
                ->where('user_id', $user_id)
                ->where('like', true)
                ->exists();
            

        return view('pages.detail', [
            'title' => 'Blog App - ' . $article->title,
            'active' => 'home',
            'article' => $article,
            'likeCount' => $likeCount,
            'liked' => $liked,
            'author' => $author
        ]);
    }

    public function whitelist()
    {
        return view('pages.whitelist', [
            'title' => 'Blog App - Whitelists',
            'active' => 'whitelist',
        ]);
    }
}
