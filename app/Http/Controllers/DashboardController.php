<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class DashboardController extends Controller
{
    public function index()
    {
        if (Auth::user()->roles == 'admin') {
            $articles = Article::orderBy('id', 'desc')->get();
            $myArticles = Article::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $myArticlesCount = Article::where('user_id', Auth::user()->id)->count();
            $categoriesCount = Category::count();
        } else {
            $articles = Article::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
            $myArticles = $articles;
            $myArticlesCount = Article::where('user_id', Auth::user()->id)->count();
            $categoriesCount = Category::count();
        }

        return view('pages.dashboard.index', [
            'title' => 'Blog App - Dashboard',
            'active' => 'dashboard',
            'articles' => $articles,
            'myArticles' => $myArticles,
            'myArticlesCount' => $myArticlesCount,
            'categoriesCount' => $categoriesCount
        ]);
    }

    public function create()
    {
        $categories = Category::orderBy('title', 'asc')->get();

        return view('pages.dashboard.create', [
            'title' => 'Blog App - Create Article',
            'navTitle' => 'Create Article',
            'active' => 'dashboard',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles|max:255',
        ], [
            'title.unique' => 'Title already exists.',
        ]);

        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/thumbnails', $fileName);

            $data['thumbnail'] = $fileName;
        }
        
        $article = Article::create($data);

        if ($article) {
            return redirect()->route('dashboard.index')->with('success', 'Article created successfully!');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'Failed to create article!');
        }
    }

    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $categories = Category::orderBy('title', 'asc')->get();

        if (Auth::user()->roles == 'admin' || Auth::user()->id == $article->user_id) {
            return view('pages.dashboard.edit', [
                'title' => 'Blog App - Edit Article',
                'navTitle' => 'Edit Article',
                'active' => 'dashboard',
                'article' => $article,
                'categories' => $categories,
            ]);
        } else {
            return redirect()->route('dashboard.index')->with('error', 'You do not have access to edit this article!');
        }
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => [
                'required',
                Rule::unique('articles')->ignore($id),
                'max:255',
            ],
        ], [
            'title.unique' => 'Title already exists.',
        ]);

        $article = Article::find($id);

        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $article->user_id && Auth::user()->roles !== 'admin') {
            return redirect()->route('dashboard.index')->with('error', 'Oops... Something went wrong!');
        }

        $article->category = $request->input('category', $article->category);
        $article->title = $request->input('title', $article->title);
        $article->body = $request->input('body', $article->body);
        $article['slug'] = Str::slug($request->title);

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama jika ada
            if ($article->thumbnail) {
                Storage::disk('public')->delete('thumbnails/' . $article->thumbnail);
            }

            $file = $request->file('thumbnail');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/thumbnails', $fileName);

            $article->thumbnail = $fileName;
        }
        
        $article->save();

        if ($article) {
            return redirect()->route('dashboard.index')->with('success', 'Article edited successfully!');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'Failed to edit article!');
        }
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        // Cek apakah pengguna yang terautentikasi adalah pemilik dari data yang ingin diperbarui
        if (Auth::id() !== (int) $article->user_id && Auth::user()->roles !== 'admin') {
            return redirect()->route('dashboard.index')->with('error', 'Oops... Something went wrong!');
        }

        if ($article->thumbnail) {
            Storage::disk('public')->delete('thumbnails/' . $article->thumbnail);
        }

        $article->delete();

        if ($article) {
            return redirect()->route('dashboard.index')->with('success', 'Article deleted successfully!');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'Failed to delete article!');
        }
    }
}
