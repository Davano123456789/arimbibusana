<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

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

Route::get('/', [FrontController::class, 'index']);

Route::get('/produk', [FrontController::class, 'produk']);
Route::get('/produk', [FrontController::class, 'produk']);
Route::get('/produk-unggulan', [FrontController::class, 'produkUnggulan']);
Route::get('/detail-produk/{id}', [FrontController::class, 'detailProduk']);
Route::post('/detail-produk/{id}/ulasan', [FrontController::class, 'storeTestimonial']);
Route::get('/keranjang', [FrontController::class, 'keranjang']);
Route::get('/pembayaran', [FrontController::class, 'pembayaran']);

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
});
