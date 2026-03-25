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
        $products = Product::with(['category', 'images'])->latest()->paginate(10);
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
            'sizes.*' => 'required|array',
            'sizes.*.*' => 'required|string',
            'size_stocks' => 'required|array',
            'size_stocks.*' => 'required|array',
            'size_stocks.*.*' => 'required|integer|min:0',
            'images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'image_colors' => 'nullable|array',
            'image_colors.*' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'size_guide' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discount_price' => 'nullable|numeric|lt:price',
        ]);

        try {
            DB::beginTransaction();

            $totalStock = 0;
            if ($request->has('size_stocks')) {
                foreach ($request->size_stocks as $variationStocks) {
                    $totalStock += array_sum($variationStocks);
                }
            }

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
                'size_guide' => $request->hasFile('size_guide') ? $request->file('size_guide')->store('products/size_guides', 'public') : null,
                'discount_price' => $request->discount_price,
                'cover_image' => $request->hasFile('cover_image') ? $request->file('cover_image')->store('products/covers', 'public') : null,
            ]);

            // Save Images and corresponding Sizes
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $key => $image) {
                    $path = $image->store('products', 'public');
                    
                    // Create Image (no more is_cover here)
                    $productImage = $product->images()->create([
                        'image' => $path,
                        'color' => $request->image_colors[$key] ?? null,
                        'is_cover' => false
                    ]);
                    
                    // Create corresponding Sizes for this Image
                    if (isset($request->sizes[$key])) {
                        foreach ($request->sizes[$key] as $sizeKey => $size) {
                            $product->sizes()->create([
                                'product_image_id' => $productImage->id,
                                'size' => $size,
                                'stock' => $request->size_stocks[$key][$sizeKey] ?? 0
                            ]);
                        }
                    }
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'size_guide' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'discount_price' => 'nullable|numeric|lt:price',
            
            // Existing Variations
            'existing_image_colors' => 'nullable|array',
            'existing_image_colors.*' => 'nullable|string|max:255',
            'existing_sizes' => 'nullable|array',
            'delete_images' => 'nullable|array',
            'delete_existing_sizes' => 'nullable|array',
            'new_sizes_for_existing' => 'nullable|array',
            
            // Completely New Variations
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|mimes:jpeg,png,jpg|max:2048',
            'new_image_colors' => 'nullable|array',
            'new_image_colors.*' => 'nullable|string|max:255',
            'new_sizes' => 'nullable|array',
            'new_size_stocks' => 'nullable|array',
        ]);

        try {
            DB::beginTransaction();

            $product = Product::findOrFail($id);
            
            // Calculate Total Stock from all sources
            $totalStock = 0;
            if ($request->has('existing_sizes')) {
                foreach ($request->existing_sizes as $imageId => $sizes) {
                    foreach ($sizes as $sizeId => $sizeData) {
                        // Skip if marked for deletion
                        if (!in_array($sizeId, $request->input('delete_existing_sizes', []))) {
                            $totalStock += (int)$sizeData['stock'];
                        }
                    }
                }
            }
            if ($request->has('new_sizes_for_existing')) {
                foreach ($request->new_sizes_for_existing as $imageId => $sizes) {
                    foreach ($sizes as $sizeData) {
                        $totalStock += (int)$sizeData['stock'];
                    }
                }
            }
            if ($request->has('new_size_stocks')) {
                foreach ($request->new_size_stocks as $variationStocks) {
                    $totalStock += array_sum($variationStocks);
                }
            }

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
                'discount_price' => $request->discount_price,
            ]);

            if ($request->hasFile('size_guide')) {
                if ($product->size_guide) {
                    Storage::disk('public')->delete($product->size_guide);
                }
                $product->update([
                    'size_guide' => $request->file('size_guide')->store('products/size_guides', 'public')
                ]);
            }

            // Handle dedicated cover image
            if ($request->hasFile('cover_image')) {
                if ($product->cover_image) {
                    Storage::disk('public')->delete($product->cover_image);
                }
                $product->update([
                    'cover_image' => $request->file('cover_image')->store('products/covers', 'public')
                ]);
            }

            // --- 1. HANDLE DELETIONS ---
            // Delete Specific Existing Sizes
            if ($request->has('delete_existing_sizes')) {
                ProductSize::whereIn('id', $request->delete_existing_sizes)->delete();
            }

            // Delete Entire Existing Variations (Images + their cascaded Sizes)
            if ($request->has('delete_images')) {
                foreach ($request->delete_images as $imageId) {
                    $img = ProductImage::find($imageId);
                    if ($img) {
                        Storage::disk('public')->delete($img->image);
                        $img->delete(); // Sizes will cascade if DB is set up, but let's be safe: ProductSizes deletes cascade.
                    }
                }
            }

            // --- 2. UPDATE EXISTING VARIATIONS ---
            if ($request->has('existing_image_colors')) {
                foreach ($request->existing_image_colors as $imageId => $color) {
                    // Skip if image was marked for deletion
                    if ($request->has('delete_images') && in_array($imageId, $request->delete_images)) {
                        continue;
                    }
                    
                    // Update Image Color (no more is_cover tracking here)
                    ProductImage::where('id', $imageId)->update([
                        'color' => $color,
                        'is_cover' => false
                    ]);

                    // Update Existing Sizes for this Image
                    if (isset($request->existing_sizes[$imageId])) {
                        foreach ($request->existing_sizes[$imageId] as $sizeId => $sizeData) {
                            ProductSize::where('id', $sizeId)->update([
                                'size' => $sizeData['size'],
                                'stock' => $sizeData['stock']
                            ]);
                        }
                    }

                    // Add Dynamic New Sizes to this Existing Image
                    if (isset($request->new_sizes_for_existing[$imageId])) {
                        foreach ($request->new_sizes_for_existing[$imageId] as $newSizeData) {
                            $product->sizes()->create([
                                'product_image_id' => $imageId,
                                'size' => $newSizeData['size'],
                                'stock' => $newSizeData['stock']
                            ]);
                        }
                    }
                }
            }

            // --- 3. ADD COMPLETELY NEW VARIATIONS ---
            if ($request->hasFile('new_images')) {
                foreach ($request->file('new_images') as $key => $image) {
                    $path = $image->store('products', 'public');
                    
                    $productImage = $product->images()->create([
                        'image' => $path,
                        'color' => $request->new_image_colors[$key] ?? null,
                        'is_cover' => false
                    ]);
                    
                    // Add Sizes for this new variation
                    if (isset($request->new_sizes[$key])) {
                        foreach ($request->new_sizes[$key] as $sizeKey => $size) {
                            $product->sizes()->create([
                                'product_image_id' => $productImage->id,
                                'size' => $size,
                                'stock' => $request->new_size_stocks[$key][$sizeKey] ?? 0
                            ]);
                        }
                    }
                }
            }
            
            // Failsafe: if somehow no cover is set after update, set first available
            if (!$product->images()->where('is_cover', true)->exists()) {
                $firstImage = $product->images()->first();
                if ($firstImage) {
                    $firstImage->update(['is_cover' => true]);
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

            if ($product->size_guide) {
                Storage::disk('public')->delete($product->size_guide);
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
