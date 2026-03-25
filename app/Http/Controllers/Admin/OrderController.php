<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderShipped;
use App\Mail\RefundCompleted;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status', 'processing'); // default to 'processing' which maps to 'settlement'
        
        $query = Order::with('user', 'items');

        if ($status === 'processing') {
            $query->where('status', 'settlement');
        } elseif ($status === 'shipped') {
            $query->where('status', 'shipped');
        } elseif ($status === 'completed') {
            $query->where('status', 'completed');
        } elseif ($status === 'refund') {
            $query->whereIn('status', ['cancel', 'expire', 'waiting_refund', 'refunded']);
        } elseif ($status === 'unpaid') {
            $query->where('status', 'unpaid')->where('snap_token', '!=', null);
        }

        $orders = $query->latest()->paginate(15);
        
        return view('dashboard.orders.index', compact('orders', 'status'));
    }

    public function show($id)
    {
        $order = Order::with(['user', 'items.product'])->findOrFail($id);
        return view('dashboard.orders.show', compact('order'));
    }

    public function inputResi(Request $request, $id)
    {
        $request->validate([
            'tracking_number' => 'required|string|max:50'
        ]);

        $order = Order::with('user')->findOrFail($id);
        
        // Kasus 6 Fix: Allow resi update for both 'settlement' (first input) AND 'shipped' (correction)
        if (!in_array($order->status, ['settlement', 'shipped'])) {
            return back()->with('error', 'Status pesanan tidak bisa diinput resi.');
        }

        $isFirstTime = $order->status === 'settlement';

        $order->update([
            'tracking_number' => $request->tracking_number,
            'shipped_at'      => $isFirstTime ? now() : $order->shipped_at,
            'status'          => 'shipped'
        ]);

        // Kirim email notifikasi hanya saat pertama kali input resi
        if ($isFirstTime && $order->user && $order->user->email) {
            try {
                Mail::to($order->user->email)->send(new OrderShipped($order));
            } catch (\Exception $e) {
                // Log error tapi jangan gagalkan proses utama
                Log::error('Gagal kirim email shipped: ' . $e->getMessage());
            }
        }

        $msg = $isFirstTime
            ? 'Nomor Resi berhasil disimpan! Email notifikasi telah dikirim ke pembeli.'
            : 'Nomor Resi berhasil diperbarui.';

        return back()->with('success', $msg);
    }

    public function uploadRefund(Request $request, $id)
    {
        $request->validate([
            'refund_receipt' => 'required|image|mimes:jpeg,png,jpg|max:4096'
        ]);

        $order = Order::with('user')->findOrFail($id);

        if ($order->status !== 'waiting_refund') {
            return back()->with('error', 'Pesanan tidak dalam antrean refund.');
        }

        $path = $request->file('refund_receipt')->store('refunds', 'public');

        $order->update([
            'refund_receipt' => $path,
            'status'         => 'refunded'
        ]);

        // Kirim email notifikasi refund selesai ke pelanggan
        if ($order->user && $order->user->email) {
            try {
                Mail::to($order->user->email)->send(new RefundCompleted($order));
            } catch (\Exception $e) {
                Log::error('Gagal kirim email refund completed: ' . $e->getMessage());
            }
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah. Email konfirmasi telah dikirim ke pelanggan.');
    }

    public function markAsCompleted($id)
    {
        $order = Order::findOrFail($id);
        
        if ($order->status !== 'shipped') {
            return back()->with('error', 'Hanya pesanan yang sudah dikirim yang dapat ditandai selesai.');
        }

        $order->update([
            'status' => 'completed'
        ]);

        return back()->with('success', 'Pesanan ditandai selesai secara paksa.');
    }
}
