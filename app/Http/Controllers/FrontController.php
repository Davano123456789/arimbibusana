<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Testimonial;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\Announcement;

class FrontController extends Controller
{
    public function index()
    {
        $bestSellers = \App\Models\Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where('is_best_seller', 1)
            ->latest()
            ->take(8)
            ->get();

        $recommended = \App\Models\Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where('is_recommended', 1)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = \App\Models\Product::with(['category', 'images'])
            ->where('status', 'active')
            ->latest()
            ->take(8)
            ->get();

        $popup = Announcement::where('is_active', true)
            ->where('show_as_popup', true)
            ->first();

        return view('public.beranda', compact('bestSellers', 'recommended', 'latestProducts', 'popup'));
    }

    public function produk(Request $request)
    {
        $categories = \App\Models\Category::all();
        
        $query = \App\Models\Product::with(['category', 'images'])
            ->where('status', 'active');

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();
            
        return view('public.produk', compact('categories', 'products'));
    }

    public function produkUnggulan(Request $request)
    {
        $categories = \App\Models\Category::all();

        $query = \App\Models\Product::with(['category', 'images'])
            ->where('status', 'active')
            ->where('is_best_seller', 1);

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Price Range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->max_price);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();

        return view('public.produkUnggulan', compact('products', 'categories'));
    }

    public function detailProduk($id)
    {
        $product = Product::with(['category', 'images', 'sizes', 'testimonials' => function($q) {
            $q->where('is_displayed', true)->latest();
        }])->withCount('likes')->findOrFail($id);

        $isLiked = false;
        if (auth()->check()) {
            $isLiked = $product->likes()->where('user_id', auth()->id())->exists();
        } else {
            // Check for user 1 as fallback if requested/for dev
            $isLiked = $product->likes()->where('user_id', 1)->exists();
        }
        
        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        return view('public.detail-produk', compact('product', 'relatedProducts', 'isLiked'));
    }

    public function toggleLike($id)
    {
        $userId = auth()->id() ?? 1; // Fallback to 1 as per user's preference for testing
        $product = Product::findOrFail($id);

        $like = ProductLike::where('user_id', $userId)
            ->where('product_id', $product->id)
            ->first();

        if ($like) {
            $like->delete();
            $status = 'unliked';
        } else {
            ProductLike::create([
                'user_id' => $userId,
                'product_id' => $product->id
            ]);
            $status = 'liked';
        }

        return response()->json([
            'status' => $status,
            'likes_count' => $product->likes()->count()
        ]);
    }

    public function storeTestimonial(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'comment' => 'required|string',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $product = Product::findOrFail($id);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'user_id' => 1, // Hardcoded as requested
            'product_id' => $product->id,
            'name' => $request->name,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'image' => $imagePath,
            'is_displayed' => true,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function keranjang()
    {
        return view('public.keranjang');
    }

    public function pembayaran()
    {
        return view('public.pembayaran');
    }
}
