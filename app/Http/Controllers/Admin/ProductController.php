<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\ProductSize;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images'])->latest()->get();
        return view('dashboard.products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('dashboard.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'sizes' => 'required|array',
            'sizes.*' => 'required|string',
            'size_stocks' => 'required|array',
            'size_stocks.*' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $totalStock = array_sum($request->size_stocks);

            $product = Product::create([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $totalStock,
                'is_best_seller' => $request->has('is_best_seller'),
                'is_recommended' => $request->has('is_recommended'),
                'status' => $request->status ?? 'inactive',
            ]);

            // Save Sizes
            foreach ($request->sizes as $key => $size) {
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => $request->size_stocks[$key]
                ]);
            }

            // Save Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create([
                        'image' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil ditambahkan!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menambahkan produk: ' . $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $product = Product::with(['category', 'images', 'sizes'])->findOrFail($id);
        return view('dashboard.products.show', compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with(['sizes', 'images'])->findOrFail($id);
        $categories = Category::all();
        return view('dashboard.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
            'status' => 'nullable|string',
            'sizes' => 'required|array',
            'sizes.*' => 'required|string',
            'size_stocks' => 'required|array',
            'size_stocks.*' => 'required|integer|min:0',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            $totalStock = array_sum($request->size_stocks);

            $product->update([
                'category_id' => $request->category_id,
                'name' => $request->name,
                'slug' => Str::slug($request->name) . '-' . Str::random(5),
                'price' => $request->price,
                'description' => $request->description,
                'stock' => $totalStock,
                'is_best_seller' => $request->has('is_best_seller'),
                'is_recommended' => $request->has('is_recommended'),
                'status' => $request->status ?? 'inactive',
            ]);

            // Sync Sizes (Delete and Recreate)
            $product->sizes()->delete();
            foreach ($request->sizes as $key => $size) {
                $product->sizes()->create([
                    'size' => $size,
                    'stock' => $request->size_stocks[$key]
                ]);
            }

            // Add New Images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create([
                        'image' => $path
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil diperbarui!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui produk: ' . $e->getMessage())->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            $product = Product::findOrFail($id);

            // Delete images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image);
            }

            $product->delete();
            DB::commit();

            return redirect()->route('dashboard.products.index')->with('success', 'Produk berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }
}
