<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DashboardController extends Controller
{
    public function index()
    {
        $articles = Article::where('user_id', Auth::user()->id)
                    ->orderBy('id', 'desc')
                    ->get();

        return view('pages.dashboard.index', [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'articles' => $articles,
        ]);
    }

    public function create()
    {
        return view('pages.dashboard.create', [
            'title' => 'Buat Artikel',
            'active' => 'dashboard',
        ]);
    }

    public function store(Request $request)
    {
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
            return redirect()->route('dashboard.index')->with([
                'success' => 'Artikel berhasil dibuat!'
            ]);
        } else {
            return redirect()->route('dashboard.index')->with([
                'error' => 'Artikel gagal dibuat!'
            ]);
        }
    }

    public function edit($slug)
    {
        $article = Article::where('slug', $slug)->first();

        return view('pages.dashboard.edit', [
            'title' => 'Edit Artikel',
            'active' => 'dashboard',
            'article' => $article
        ]);
    }

    public function update(Request $request, string $id)
    {
        $article = Article::find($id);
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
