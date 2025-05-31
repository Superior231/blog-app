<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\LikeArticle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

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
        $author_name = $author->name;
        $description = Str::limit(strip_tags($article->body), 150);
        $thumbnail = $article->thumbnail;

        $likeCount = LikeArticle::where('article_id', $article->id)->where('like', true)->count();
        $liked = LikeArticle::where('article_id', $article->id)
                ->where('user_id', $user_id)
                ->where('like', true)
                ->exists();
            

        return view('pages.detail', [
            'title' => $article->title,
            'active' => 'home',
            'article' => $article,
            'likeCount' => $likeCount,
            'liked' => $liked,
            'author' => $author,
            'author_name' => $author_name,
            'description' => $description,
            'keywords' => $article->category,
            'thumbnail' => $thumbnail,
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
