<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderBy('title', 'asc')->paginate(10);

        return view('pages.category.index', [
            'title' => 'Kategori',
            'active' => 'category',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:255',
        ], [
            'title.unique' => 'Kategori sudah ada.',
        ]);

        $data = $request->all();

        $category = Category::create($data);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Kategori berhasil dibuat!');
        } else {
            return redirect()->route('category.index')->with('error', 'Kategori gagal dibuat!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:255',
        ], [
            'title.unique' => 'Kategori sudah ada.',
        ]);
        
        $data = $request->all();
        $category = Category::find($id);

        $category->update($data);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Kategori berhasil diupdate!');
        } else {
            return redirect()->route('category.index')->with('error', 'Kategori gagal diupdate!');
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Kategori berhasil dihapus!');
        } else {
            return redirect()->route('category.index')->with('error', 'Kategori gagal dihapus!');
        }
    }
}
