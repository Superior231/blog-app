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
        } else {
            $articles = Article::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        }

        return view('pages.dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        $categories = Category::all();

        return view('pages.dashboard.create', [
            'title' => 'Buat Artikel',
            'active' => 'dashboard',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles|max:255',
        ], [
            'title.unique' => 'Judul sudah ada.',
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

        if ($article && isset($data['category_id'])) {
            $article->categories()->attach($data['category_id']);
        }

        if ($article) {
            return redirect()->route('dashboard.index')->with('success', 'Artikel berhasil dibuat!');
        } else {
            return redirect()->route('dashboard.index')->with('error', 'Artikel gagal dibuat!');
        }
    }

    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->first();
        $categories = Category::all();

        return view('pages.dashboard.edit', [
            'title' => 'Edit Artikel',
            'active' => 'dashboard',
            'article' => $article,
            'categories' => $categories,
        ]);
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
            'title.unique' => 'Judul sudah ada.',
        ]);

        $article = Article::find($id);
        $article->category = $request->input('category', $article->category);
        $article->author = $request->input('author', $article->author);
        $article->source = $request->input('source', $article->source);
        $article->date = $request->input('date', $article->date);
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
            return redirect()->route('dashboard.index')->with([
                'success' => 'Artikel berhasil diedit!'
            ]);
        } else {
            return redirect()->route('dashboard.index')->with([
                'error' => 'Artikel gagal diedit!'
            ]);
        }
    }

    public function destroy($id)
    {
        $article = Article::find($id);

        if ($article->thumbnail) {
            Storage::disk('public')->delete('thumbnails/' . $article->thumbnail);
        }

        $article->delete();

        if ($article) {
            return redirect()->route('dashboard.index')->with([
                'success' => 'Artikel berhasil dihapus!'
            ]);
        } else {
            return redirect()->route('dashboard.index')->with([
                'error' => 'Artikel gagal dihapus!'
            ]);
        }
    }
}
