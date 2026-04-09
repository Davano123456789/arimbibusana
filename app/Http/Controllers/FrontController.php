<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Testimonial;
use App\Models\Product;
use App\Models\ProductLike;
use App\Models\Announcement;
use App\Models\BlogPost;
use App\Mail\RefundRequested;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Midtrans\Config;
use Midtrans\Snap;

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
            $query->whereHas('category', function ($q) use ($request) {
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
            $query->whereHas('category', function ($q) use ($request) {
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
        $product = Product::with([
            'category',
            'images',
            'sizes',
            'testimonials' => function ($q) {
                $q->where('is_displayed', true)->latest();
            }
        ])->findOrFail($id);

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
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480',
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

    public function storeGeneralTestimonial(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'comment' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
            'image' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,webm|max:20480',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('testimonials', 'public');
        }

        Testimonial::create([
            'user_id' => auth()->id(), // null if not logged in
            'product_id' => $request->product_id,
            'name' => $request->name,
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
        $userId = \Illuminate\Support\Facades\Auth::id();
        $cartItems = \App\Models\Cart::with(['product', 'size'])->where('user_id', $userId)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Keranjang kosong'], 400);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string',
            'postal_code' => 'required|digits:5',
            'province_id' => 'required|string',
            'province_name' => 'required|string',
            'city_id' => 'required|string',
            'city_name' => 'required|string',
            'district_id' => 'required|string',
            'district_name' => 'required|string',
            'courier' => 'required|string',
            'shipping_cost' => 'required|numeric',
            'shipping_etd' => 'nullable|string',
        ]);

        try {
            return \Illuminate\Support\Facades\DB::transaction(function () use ($request, $cartItems, $userId) {
                // ... same logic ...
                $subtotal = 0;
                foreach ($cartItems as $item) {
                    $subtotal += $item->product->price * $item->quantity;
                }
                $totalPrice = $subtotal + $request->shipping_cost;

                // 1. First, check all stocks and lock them
                foreach ($cartItems as $item) {
                    $productSize = \App\Models\ProductSize::where('id', $item->size_id)->lockForUpdate()->first();
                    if (!$productSize || $productSize->stock < $item->quantity) {
                        throw new \Exception("Stok {$item->product->name} (Size {$item->size->size}) tidak mencukupi atau baru saja habis.");
                    }
                }

                // 2. Decrement stocks
                foreach ($cartItems as $item) {
                    \App\Models\ProductSize::where('id', $item->size_id)->decrement('stock', $item->quantity);
                    \App\Models\Product::where('id', $item->product_id)->decrement('stock', $item->quantity);
                }

                // 3. Create Order
                $order = \App\Models\Order::create([
                    'user_id' => $userId,
                    'order_number' => 'AQ-' . strtoupper(uniqid()),
                    'customer_name' => $request->name,
                    'customer_phone' => $request->phone,
                    'customer_address' => $request->address,
                    'customer_postal_code' => $request->postal_code,
                    'province_id' => $request->province_id,
                    'province_name' => $request->province_name,
                    'city_id' => $request->city_id,
                    'city_name' => $request->city_name,
                    'district_id' => $request->district_id,
                    'district_name' => $request->district_name,
                    'courier' => $request->courier,
                    'shipping_cost' => $request->shipping_cost,
                    'shipping_etd' => $request->shipping_etd,
                    'total_price' => $totalPrice,
                    'status' => 'unpaid',
                    'expired_at' => now()->addMinutes(60),
                    'notes' => $request->notes,
                ]);

                foreach ($cartItems as $item) {
                    \App\Models\OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_size_id' => $item->size_id,
                        'size_name' => $item->size->size,
                        'color_name' => $item->size->image ? $item->size->image->color : null,
                        'quantity' => $item->quantity,
                        'price' => $item->product->price,
                    ]);
                }

                // Midtrans Configuration
                \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
                \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
                \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
                \Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS', true);

                $params = [
                    'transaction_details' => [
                        'order_id' => $order->order_number,
                        'gross_amount' => (int) $totalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => $request->name,
                        'email' => \Illuminate\Support\Facades\Auth::user()->email,
                        'phone' => $request->phone,
                    ],
                    'item_details' => $cartItems->map(function ($item) {
                        return [
                            'id' => $item->product_id,
                            'price' => (int) $item->product->price,
                            'quantity' => $item->quantity,
                            'name' => \Illuminate\Support\Str::limit($item->product->name, 45) . ' (' . $item->size->size . ')',
                        ];
                    })->toArray(),
                    'expiry' => [
                        'start_time' => date("Y-m-d H:i:s O"),
                        'unit' => 'minute',
                        'duration' => 60,
                    ],
                ];

                if ($request->shipping_cost > 0) {
                    $params['item_details'][] = [
                        'id' => 'shipping_cost',
                        'price' => (int) $request->shipping_cost,
                        'quantity' => 1,
                        'name' => 'Ongkos Kirim (' . strtoupper($request->courier) . ')',
                    ];
                }

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                $order->update(['snap_token' => $snapToken]);

                \App\Models\Cart::where('user_id', $userId)->delete();

                return response()->json([
                    'success' => true,
                    'message' => 'Pesanan berhasil dibuat',
                    'order_id' => $order->id,
                    'snap_token' => $snapToken
                ]);
            });
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function handleNotification(Request $request)
    {
        $serverKey = env('MIDTRANS_SERVER_KEY');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hashed == $request->signature_key) {
            $order = \App\Models\Order::where('order_number', $request->order_id)->first();
            if ($order) {
                if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                    if ($order->status !== 'settlement') {
                        $order->update(['status' => 'settlement']);
                        \Illuminate\Support\Facades\Mail::send('emails.invoice', ['order' => $order], function ($m) use ($order) {
                            $m->to($order->user->email, $order->customer_name)->subject('Invoice Pesanan ' . $order->order_number);
                        });
                    }
                } elseif ($request->transaction_status == 'pending') {
                    $order->update(['status' => 'pending']);
                } elseif ($request->transaction_status == 'deny' || $request->transaction_status == 'cancel') {
                    if ($order->status !== 'cancel') {
                        $order->update(['status' => 'cancel']);
                        $this->returnStock($order);
                    }
                } elseif ($request->transaction_status == 'expire') {
                    if ($order->status !== 'expire') {
                        $order->update(['status' => 'expire']);
                        $this->returnStock($order);
                    }
                }
            }
        }

        return response()->json(['status' => 'success']);
    }

    public function finishOrder(Request $request)
    {
        $orderId = $request->order_id;

        \Midtrans\Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        \Midtrans\Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        \Midtrans\Config::$isSanitized = env('MIDTRANS_IS_SANITIZED', true);
        \Midtrans\Config::$is3ds = env('MIDTRANS_IS_3DS', true);

        try {
            $statusRes = \Midtrans\Transaction::status($orderId);
            $order = \App\Models\Order::where('order_number', $orderId)->first();

            if ($order) {
                if ($statusRes->transaction_status == 'settlement' || $statusRes->transaction_status == 'capture') {
                    if ($order->status !== 'settlement') {
                        $order->update(['status' => 'settlement']);
                        \Illuminate\Support\Facades\Mail::send('emails.invoice', ['order' => $order], function ($m) use ($order) {
                            $m->to($order->user->email, $order->customer_name)->subject('Invoice Pesanan ' . $order->order_number);
                        });
                    }
                    return redirect()->route('checkout.success', $orderId)->with('success', 'Pembayaran berhasil! Pesanan Anda sedang diproses.');
                }
            }

            return redirect('/')->with('info', 'Status pembayaran Anda: ' . $statusRes->transaction_status);
        } catch (\Exception $e) {
            return redirect('/')->with('error', 'Gagal memverifikasi pembayaran: ' . $e->getMessage());
        }
    }

    public function paymentSuccess($order_number)
    {
        $order = \App\Models\Order::with(['items.product'])->where('order_number', $order_number)->firstOrFail();

        // Ensure user can only view their own order
        if ($order->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        return view('public.pembayaran-berhasil', compact('order'));
    }

    public function invoice($order_number)
    {
        $order = \App\Models\Order::with(['items.product', 'user'])->where('order_number', $order_number)->firstOrFail();

        if ($order->user_id !== \Illuminate\Support\Facades\Auth::id()) {
            abort(403);
        }

        return view('public.invoice-web', compact('order'));
    }

    public function pesanan()
    {
        $orders = \App\Models\Order::with(['items', 'items.product', 'items.product.images'])
            ->where('user_id', \Illuminate\Support\Facades\Auth::id())
            ->latest()
            ->paginate(5);

        return view('public.pesanan', compact('orders'));
    }

    public function cancelOrder(Request $request, $id)
    {
        $order = \App\Models\Order::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
        if ($order->status !== 'unpaid')
            return back()->with('error', 'Pesanan tidak bisa dibatalkan.');

        $order->update([
            'status' => 'cancel',
            'cancel_reason' => $request->cancel_reason ?? 'Dibatalkan oleh pelanggan'
        ]);

        $this->returnStock($order);

        return back()->with('success', 'Pesanan berhasil dibatalkan dan stok telah dikembalikan.');
    }

    public function requestRefund(Request $request, $id)
    {
        $order = \App\Models\Order::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
        if ($order->status !== 'settlement')
            return back()->with('error', 'Status pesanan tidak valid untuk refund.');

        $request->validate([
            'cancel_reason' => 'required|string',
            'refund_bank' => 'required|string',
            'refund_account_number' => 'required|string'
        ]);

        $order->update([
            'status' => 'waiting_refund',
            'cancel_reason' => $request->cancel_reason,
            'refund_bank' => $request->refund_bank,
            'refund_account_number' => $request->refund_account_number
        ]);

        // Kirim notifikasi ke admin
        try {
            $adminEmail = env('MAIL_ADMIN_ADDRESS', env('MAIL_FROM_ADDRESS'));
            Mail::to($adminEmail)->send(new RefundRequested($order));
        } catch (\Exception $e) {
            Log::error('Gagal kirim email refund requested ke admin: ' . $e->getMessage());
        }

        return back()->with('success', 'Pengajuan refund berhasil dikirim. Menunggu proses admin.');
    }

    public function completeOrder(Request $request, $id)
    {
        $order = \App\Models\Order::where('id', $id)->where('user_id', \Illuminate\Support\Facades\Auth::id())->firstOrFail();
        if ($order->status !== 'shipped')
            return back()->with('error', 'Pesanan tidak bisa diselesaikan saat ini.');

        $order->update(['status' => 'completed']);

        return back()->with('success', 'Terima kasih, pesanan telah diselesaikan!');
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

    private function returnStock($order)
    {
        // Only return stock if items were already decremented
        // Based on our new flow, they are always decremented at creation
        foreach ($order->items as $item) {
            // Return to size stock
            if ($item->product_size_id) {
                \App\Models\ProductSize::where('id', $item->product_size_id)->increment('stock', $item->quantity);
            }
            // Return to global product stock
            \App\Models\Product::where('id', $item->product_id)->increment('stock', $item->quantity);
        }
    }
}
