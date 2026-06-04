<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Pesanan Hari Ini
        $ordersToday = Order::whereDate('created_at', today())->count();
        $ordersYesterday = Order::whereDate('created_at', today()->subDay())->count();
        if ($ordersYesterday > 0) {
            $ordersDiffPercent = (($ordersToday - $ordersYesterday) / $ordersYesterday) * 100;
        } else {
            $ordersDiffPercent = $ordersToday > 0 ? 100 : 0;
        }

        // 2. Pendapatan (Total Lunas/Sukses)
        $totalRevenue = Order::whereIn('status', ['settlement', 'shipped', 'completed'])->sum('total_price');
        
        $revenueThisWeek = Order::whereIn('status', ['settlement', 'shipped', 'completed'])
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->sum('total_price');
        $revenueLastWeek = Order::whereIn('status', ['settlement', 'shipped', 'completed'])
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->sum('total_price');
        if ($revenueLastWeek > 0) {
            $revenueDiffPercent = (($revenueThisWeek - $revenueLastWeek) / $revenueLastWeek) * 100;
        } else {
            $revenueDiffPercent = $revenueThisWeek > 0 ? 100 : 0;
        }

        // 3. Pelanggan Baru (Total Client & Registrasi Minggu Ini)
        $totalClients = User::where('role', 'client')->count();
        $clientsThisWeek = User::where('role', 'client')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $clientsLastWeek = User::where('role', 'client')
            ->whereBetween('created_at', [now()->subWeek()->startOfWeek(), now()->subWeek()->endOfWeek()])
            ->count();
        if ($clientsLastWeek > 0) {
            $clientsDiffPercent = (($clientsThisWeek - $clientsLastWeek) / $clientsLastWeek) * 100;
        } else {
            $clientsDiffPercent = $clientsThisWeek > 0 ? 100 : 0;
        }

        // 4. Produk Aktif
        $activeProductsCount = Product::where('status', 'active')->count();
        $newProductsThisWeek = Product::where('status', 'active')
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();

        return view('dashboard.index', compact(
            'ordersToday',
            'ordersDiffPercent',
            'totalRevenue',
            'revenueDiffPercent',
            'totalClients',
            'clientsDiffPercent',
            'activeProductsCount',
            'newProductsThisWeek'
        ));
    }
}
