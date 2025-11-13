<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::latest()->get(); 

        return view('categories.index', [
            'categories' => $categories
        ]);
        // SAMPAI SINI
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();

        return view('categories.create', [
            'categories' => $categories
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:categories', 
            'description' => 'nullable|string', 
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        Category::create($validated);

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        $category->load('products', 'parent');

        return view('categories.show', [
            'category' => $category
        ]);
    }


    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();

        return view('categories.edit', [
            'category' => $category,
            'all_categories' => $categories 
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories')->ignore($category->id), 
            ],
            'description' => 'nullable|string',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
                         ->with('success', 'Kategori berhasil diperbarui!');//
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {

        try {
            $category->delete();

            return redirect()->route('categories.index')
                             ->with('success', 'Kategori berhasil dihapus!');

        } catch (\Illuminate\Database\QueryException $e) {

            if ($e->getCode() == '23000') {
                return redirect()->route('categories.index')
                                 ->with('error', 'Gagal menghapus: Kategori ini masih digunakan oleh satu atau lebih produk.');
            }

            return redirect()->route('categories.index')
                             ->with('error', 'Gagal menghapus kategori: ' . $e->getMessage());
        }
    }
}