<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(5);

        return view('pages.home', [
            'title' => 'Blog App',
            'active' => 'home',
            'articles' => $articles
        ]);
    }

    public function detail($slug)
    {
        $article = Article::where('slug', $slug)->first();

        return view('pages.detail', [
            'title' => $article->title,
            'active' => 'home',
            'article' => $article
        ]);
    }
}
