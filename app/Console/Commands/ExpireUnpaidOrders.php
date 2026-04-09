<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ExpireUnpaidOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:expire-unpaid';

    /**
     * The description of the console command.
     *
     * @var string
     */
    protected $description = 'Expire unpaid orders after 24 hours and return stock';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Find unpaid orders created more than 60 minutes ago
        $expiredOrders = Order::where('status', 'unpaid')
            ->where('created_at', '<', Carbon::now()->subMinutes(60))
            ->with('items')
            ->get();

        if ($expiredOrders->isEmpty()) {
            $this->info('No expired orders found.');
            return;
        }

        foreach ($expiredOrders as $order) {
            $this->info("Expiring order #{$order->order_number}...");

            try {
                \Illuminate\Support\Facades\DB::transaction(function() use ($order) {
                    // 1. Update status
                    $order->update([
                        'status' => 'expire',
                        'cancel_reason' => 'Batal otomatis: Pembayaran melewati batas 60 menit.'
                    ]);

                    // 2. Return Stock
                    foreach ($order->items as $item) {
                        if ($item->product_size_id) {
                            \App\Models\ProductSize::where('id', $item->product_size_id)->increment('stock', $item->quantity);
                        }
                        \App\Models\Product::where('id', $item->product_id)->increment('stock', $item->quantity);
                    }
                });
                
                $this->info("Order #{$order->order_number} has been expired and stock returned.");
            } catch (\Exception $e) {
                $this->error("Failed to expire order #{$order->order_number}: " . $e->getMessage());
                Log::error("Error expiring unpaid order {$order->order_number}: " . $e->getMessage());
            }
        }

        $this->info('Process completed.');
    }
}
