<?php

namespace App\Http\Controllers;
use App\Models\Product; 
use App\Models\Category; 
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Illuminate\Validation\Rule; 

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->get();

        return view('products.index', [
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.create', [
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => [
                'required',
                'string',
                'max:255',
                'unique:products,sku',
                'regex:/^[A-Z0-9]{2,10}-[A-Z0-9]{2,10}-\d{3,5}$/' // Format: BAGIAN1-BAGIAN2-ANGKA
            ],
            'status' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'sku.regex' => 'Format SKU tidak valid. Format yang benar: KAT-MEREK-001 (Contoh: LAP-ASUS-001)'
        ]);

        try {
            DB::transaction(function () use ($validated) {
                
                $product = Product::create([
                    'name' => $validated['name'],
                    'category_id' => $validated['category_id'],
                    'price' => $validated['price'],
                    'sku' => $validated['sku'],
                    'status' => $validated['status'],
                ]);

                $product->productDetail()->create([
                    'weight' => $validated['weight'],
                    'size' => $validated['size'],
                    'description' => $validated['description'],
                ]);

            });

            return redirect()->route('products.index')
                             ->with('success', 'Produk baru berhasil ditambahkan!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
     public function show(Product $product)
    {
        $product->load('category', 'productDetail', 'suppliers');

        return view('products.show', [
            'product' => $product
        ]);
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        $product->load('productDetail');

        $categories = Category::all();
        $suppliers = Supplier::all();

        return view('products.edit', [
            'product' => $product,
            'categories' => $categories,
            'suppliers' => $suppliers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => [
                'required', 'string', 'max:255',
                Rule::unique('products')->ignore($product->id),
            ],
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'sku' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id),
                'regex:/^[A-Z0-9]{2,10}-[A-Z0-9]{2,10}-\d{3,5}$/' // Format: BAGIAN1-BAGIAN2-ANGKA
            ],
            'status' => 'required|string',
            'weight' => 'required|numeric|min:0',
            'size' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ], [
            'sku.regex' => 'Format SKU tidak valid. Format yang benar: KAT-MEREK-001 (Contoh: LAP-ASUS-001)'
        ]);

        try {
            DB::transaction(function () use ($validated, $product) {
                
                $product->update([
                    'name' => $validated['name'],
                    'category_id' => $validated['category_id'],
                    'price' => $validated['price'],
                    'sku' => $validated['sku'],
                    'status' => $validated['status'],
                ]);

                $product->productDetail()->updateOrCreate(
                    ['product_id' => $product->id], 
                    [
                        'weight' => $validated['weight'],
                        'size' => $validated['size'],
                        'description' => $validated['description'],
                    ]
                );

            });

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil diperbarui!');

        } catch (\Exception $e) {
            return back()->withInput()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        try {

            $product->delete();

            return redirect()->route('products.index')
                             ->with('success', 'Produk berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()->route('products.index')
                             ->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
