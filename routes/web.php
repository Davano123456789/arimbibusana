<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\DashboardController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/beranda', [FrontController::class, 'index']);
Route::get('/produk', [FrontController::class, 'produk']);
Route::get('/produk-unggulan', [FrontController::class, 'produkUnggulan']);
Route::get('/detail-produk', [FrontController::class, 'detailProduk']);
Route::get('/keranjang', [FrontController::class, 'keranjang']);
Route::get('/pembayaran', [FrontController::class, 'pembayaran']);
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
