<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        return view('pages.category.index', [
            'title' => 'Blog App - Categories',
            'active' => 'category',
            'categories' => $categories
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:255',
        ], [
            'title.unique' => 'Category already exists.',
        ]);

        $data = $request->all();

        $category = Category::create($data);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category created successfully!');
        } else {
            return redirect()->route('category.index')->with('error', 'Category failed to create!');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|unique:categories|max:255',
        ], [
            'title.unique' => 'Category already exists.',
        ]);
        
        $data = $request->all();
        $category = Category::find($id);

        $category->update($data);

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category updated successfully!');
        } else {
            return redirect()->route('category.index')->with('error', 'Category failed to update!');
        }
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        $category->delete();

        if ($category) {
            return redirect()->route('category.index')->with('success', 'Category deleted successfully!');
        } else {
            return redirect()->route('category.index')->with('error', 'Category failed to delete!');
        }
    }
}
