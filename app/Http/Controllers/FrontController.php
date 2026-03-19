<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\Announcement;
use App\Models\BlogPost;

class FrontController extends Controller
{
    public function index()
    {
        $bestSellers = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active')
            ->where('is_best_seller', 1)
            ->latest()
            ->take(8)
            ->get();

        $recommended = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active')
            ->where('is_recommended', 1)
            ->latest()
            ->take(8)
            ->get();

        $latestProducts = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active')
            ->latest()
            ->take(9)
            ->get();

        $discountedProducts = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active')
            ->whereNotNull('discount_price')
            ->latest()
            ->take(8)
            ->get();

        $popup = Announcement::where('is_active', true)
            ->where('show_as_popup', true)
            ->first();
        $latestPosts = \App\Models\BlogPost::where('status', 'published')
            ->latest()
            ->take(3)
            ->get();

        $likedProducts = collect();
        $likedProductIds = [];
        if (Auth::check()) {
            $likedProducts = Auth::user()->likedProducts()->with(['images'])->get();
            $likedProductIds = Auth::user()->likedProducts()->pluck('products.id')->toArray();
        }

        return view('public.beranda', compact('bestSellers', 'recommended', 'latestProducts', 'discountedProducts', 'latestPosts', 'popup', 'likedProducts', 'likedProductIds'));
    }

    public function produk(Request $request)
    {
        $categories = \App\Models\Category::all();

        $query = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active');

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Price Range (Taking discount_price into account)
        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(discount_price, price) >= ?', [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(discount_price, price) <= ?', [$request->max_price]);
        }

        // Filter by On Sale
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('discount_price');
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) asc');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();

        $likedProductIds = [];
        if (Auth::check()) {
            $likedProductIds = Auth::user()->likedProducts()->pluck('products.id')->toArray();
        }

        return view('public.produk', compact('categories', 'products', 'likedProductIds'));
    }

    public function produkUnggulan(Request $request)
    {
        $categories = \App\Models\Category::all();

        $query = \App\Models\Product::with(['category', 'images', 'images.sizes'])
            ->where('status', 'active')
            ->where('is_best_seller', 1);

        // Filter by Category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // Filter by Price Range (Taking discount_price into account)
        if ($request->filled('min_price')) {
            $query->whereRaw('COALESCE(discount_price, price) >= ?', [$request->min_price]);
        }
        if ($request->filled('max_price')) {
            $query->whereRaw('COALESCE(discount_price, price) <= ?', [$request->max_price]);
        }

        // Filter by On Sale
        if ($request->boolean('on_sale')) {
            $query->whereNotNull('discount_price');
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderByRaw('COALESCE(discount_price, price) asc');
                break;
            case 'price_high':
                $query->orderByRaw('COALESCE(discount_price, price) desc');
                break;
            case 'oldest':
                $query->oldest();
                break;
            default:
                $query->latest();
                break;
        }

        $products = $query->get();

        $likedProductIds = [];
        if (Auth::check()) {
            $likedProductIds = Auth::user()->likedProducts()->pluck('products.id')->toArray();
        }

        return view('public.produkUnggulan', compact('products', 'categories', 'likedProductIds'));
    }

    public function detailProduk($id)
    {
        $product = Product::with(['category', 'images', 'sizes', 'testimonials' => function($q) {
            $q->where('is_displayed', true)->latest();
        }])->findOrFail($id);

        $relatedProducts = Product::with(['category', 'images'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('status', 'active')
            ->latest()
            ->take(4)
            ->get();

        $isLiked = false;
        if (Auth::check()) {
            $isLiked = ProductLike::where('user_id', Auth::id())
                ->where('product_id', $product->id)
                ->exists();
        }

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
            'user_id' => auth()->id(),
            'product_id' => $product->id,
            'name' => auth()->user()->name,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'image' => $imagePath,
            'is_displayed' => true,
        ]);

        return back()->with('success', 'Terima kasih atas ulasan Anda!');
    }

    public function testimoni()
    {
        $testimonials = Testimonial::with(['product'])
            ->where('is_displayed', true)
            ->latest()
            ->get();

        $products = Product::where('status', 'active')
            ->latest()
            ->get(['id', 'name']);

        return view('public.testimoni', compact('testimonials', 'products'));
    }

    public function tentang()
    {
        return view('public.tentang');
    }

    public function pembayaran()
    {
        $userId = Auth::id();
        $cartItems = \App\Models\Cart::with(['product', 'product.images', 'size'])
            ->where('user_id', $userId)
            ->get();

        if ($cartItems->count() == 0) {
            return redirect()->route('cart.index')->with('warning', 'Keranjang belanja Anda kosong.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            $total += $item->product->price * $item->quantity;
        }

        return view('public.pembayaran', compact('cartItems', 'total'));
    }

    public function storeOrder(Request $request)
    {
        $userId = Auth::id();
        $cartItems = \App\Models\Cart::with(['product', 'size'])->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong'], 400);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'province_id' => 'required|string',
            'province_name' => 'required|string',
            'city_id' => 'required|string',
            'city_name' => 'required|string',
            'shipping_cost' => 'required|numeric',
        ]);

        $subtotal = 0;
        foreach ($cartItems as $item) {
            $subtotal += $item->product->price * $item->quantity;
        }

        $totalPrice = $subtotal + $request->shipping_cost;

        $order = \App\Models\Order::create([
            'user_id' => $userId,
            'order_number' => 'AQ-' . strtoupper(uniqid()),
            'customer_name' => $request->name,
            'customer_phone' => $request->phone,
            'customer_address' => $request->address,
            'province_id' => $request->province_id,
            'province_name' => $request->province_name,
            'city_id' => $request->city_id,
            'city_name' => $request->city_name,
            'shipping_cost' => $request->shipping_cost,
            'total_price' => $totalPrice,
            'status' => 'unpaid',
            'notes' => $request->notes,
        ]);

        foreach ($cartItems as $item) {
            \App\Models\OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item->product_id,
                'product_size_id' => $item->product_size_id,
                'size_name' => $item->size->size,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
            ]);
        }

        // Clear cart
        \App\Models\Cart::where('user_id', $userId)->delete();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order_id' => $order->id
        ]);
    }

    public function blog()
    {
        $posts = BlogPost::where('status', 'published')
            ->latest()
            ->paginate(9);
            
        return view('public.blog', compact('posts'));
    }

    public function blogDetail($slug)
    {
        $post = BlogPost::where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();
            
        $recentPosts = BlogPost::where('id', '!=', $post->id)
            ->where('status', 'published')
            ->latest()
            ->take(5)
            ->get();

        return view('public.blog-detail', compact('post', 'recentPosts'));
    }

    public function live()
    {
        return view('public.live');
    }
}
