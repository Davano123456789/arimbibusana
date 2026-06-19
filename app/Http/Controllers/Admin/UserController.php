<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        // Get all users who are clients (members)
        $users = User::where('role', 'client')
            ->withCount(['orders as successful_purchases_count' => function ($query) {
                $query->whereIn('status', ['settlement', 'shipped', 'completed']);
            }])
            ->latest()
            ->paginate(10);

        return view('dashboard.users.index', compact('users'));
    }

    public function show($id)
    {
        $user = User::where('role', 'client')->findOrFail($id);

        // Get all items purchased in successful orders
        $purchasedItems = OrderItem::whereHas('order', function ($query) use ($id) {
            $query->where('user_id', $id)
                  ->whereIn('status', ['settlement', 'shipped', 'completed']);
        })
        ->with(['product', 'order'])
        ->latest()
        ->get();

        // Get order history
        $orders = Order::where('user_id', $id)->latest()->get();

        // Calculate total successful spent
        $totalSpent = Order::where('user_id', $id)
            ->whereIn('status', ['settlement', 'shipped', 'completed'])
            ->sum('total_price');

        // Count successful orders
        $successfulOrdersCount = Order::where('user_id', $id)
            ->whereIn('status', ['settlement', 'shipped', 'completed'])
            ->count();

        return view('dashboard.users.show', compact('user', 'purchasedItems', 'orders', 'totalSpent', 'successfulOrdersCount'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        
        // Prevent deleting current user
        if ((int)$user->id === (int)auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $user->delete();
        return back()->with('success', 'User berhasil dihapus.');
    }
}
