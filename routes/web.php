<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Email Verification Routes
Route::get('/email/verify', [AuthController::class, 'verificationNotice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();
    return redirect('/')->with('success', 'Email berhasil diverifikasi! Selamat berbelanja.');
})->middleware(['auth', 'signed'])->name('verification.verify');
Route::post('/email/verification-notification', [AuthController::class, 'resendVerification'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

Route::middleware('auth')->group(function () {
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
    Route::patch('/keranjang/{id}', [CartController::class, 'update'])->name('cart.update');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::get('/pembayaran', [FrontController::class, 'pembayaran'])->name('checkout.index');
    Route::post('/detail-produk/{id}/ulasan', [FrontController::class, 'storeTestimonial']);
});

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BlogController;

Route::get('/', [FrontController::class, 'index']);

Route::get('/produk', [FrontController::class, 'produk']);
Route::get('/produk', [FrontController::class, 'produk']);
Route::get('/produk-unggulan', [FrontController::class, 'produkUnggulan']);
Route::get('/detail-produk/{id}', [FrontController::class, 'detailProduk']);
Route::post('/detail-produk/{id}/like', [FrontController::class, 'toggleLike']);
Route::get('/testimoni', [FrontController::class, 'testimoni']);
Route::get('/tentang', [FrontController::class, 'tentang']);
Route::post('/testimoni', [FrontController::class, 'storeGeneralTestimonial']);

// Shipping (RajaOngkir)
Route::get('/shipping/provinces', [\App\Http\Controllers\ShippingController::class, 'getProvinces']);
Route::get('/shipping/cities/{provinceId}', [\App\Http\Controllers\ShippingController::class, 'getCities']);
Route::post('/shipping/cost', [\App\Http\Controllers\ShippingController::class, 'getCost']);
Route::post('/pembayaran', [\App\Http\Controllers\FrontController::class, 'storeOrder'])->name('checkout.store');

Route::get('/blog', [FrontController::class, 'blog'])->name('public.blog');
Route::get('/blog/{slug}', [FrontController::class, 'blogDetail'])->name('public.blog.detail');

Route::prefix('dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/products', [ProductController::class, 'index'])->name('dashboard.products.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('dashboard.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('dashboard.products.store');
    Route::get('/products/{id}', [ProductController::class, 'show'])->name('dashboard.products.show');
    Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('dashboard.products.edit');
    Route::put('/products/{id}', [ProductController::class, 'update'])->name('dashboard.products.update');
    Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('dashboard.products.destroy');

    Route::get('/categories', [CategoryController::class, 'index'])->name('dashboard.categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('dashboard.categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('dashboard.categories.store');
    Route::get('/categories/{id}/edit', [CategoryController::class, 'edit'])->name('dashboard.categories.edit');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('dashboard.categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('dashboard.categories.destroy');

    Route::get('/testimonials', [TestimonialController::class, 'index'])->name('dashboard.testimonials.index');
    Route::get('/testimonials/{id}', [TestimonialController::class, 'show'])->name('dashboard.testimonials.show');
    Route::delete('/testimonials/{id}', [TestimonialController::class, 'destroy'])->name('dashboard.testimonials.destroy');
    Route::post('/testimonials/{id}/toggle', [TestimonialController::class, 'toggleDisplay'])->name('dashboard.testimonials.toggle');

    Route::resource('/announcements', AnnouncementController::class)->names([
        'index' => 'dashboard.announcements.index',
        'create' => 'dashboard.announcements.create',
        'store' => 'dashboard.announcements.store',
        'edit' => 'dashboard.announcements.edit',
        'update' => 'dashboard.announcements.update',
        'destroy' => 'dashboard.announcements.destroy',
    ])->except(['show']);
    Route::post('/announcements/{id}/toggle-popup', [AnnouncementController::class, 'togglePopup'])->name('dashboard.announcements.toggle-popup');
    Route::post('/announcements/{id}/toggle-status', [AnnouncementController::class, 'toggleStatus'])->name('dashboard.announcements.toggle-status');
    
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'index'])->name('dashboard.settings.index');
    Route::post('/settings', [\App\Http\Controllers\Admin\SettingController::class, 'update'])->name('dashboard.settings.update');

    Route::resource('/blogs', BlogController::class)->names([
        'index' => 'dashboard.blogs.index',
        'create' => 'dashboard.blogs.create',
        'store' => 'dashboard.blogs.store',
        'edit' => 'dashboard.blogs.edit',
        'update' => 'dashboard.blogs.update',
        'destroy' => 'dashboard.blogs.destroy',
    ])->except(['show']);
    Route::post('/blogs/upload', [BlogController::class, 'uploadImage'])->name('dashboard.blogs.upload');
    
    // User Management
    Route::get('/users', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('dashboard.users.index');
    Route::delete('/users/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('dashboard.users.destroy');
});

Route::get('/live', [FrontController::class, 'live'])->name('public.live');
