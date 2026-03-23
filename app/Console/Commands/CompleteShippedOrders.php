<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;

class CompleteShippedOrders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:auto-complete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically mark shipped orders as completed if 7 days have passed since shipped_at';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-complete process for shipped orders...');

        $thresholdDate = Carbon::now()->subDays(7);

        // Find orders that are 'shipped' and the 'shipped_at' is older than 7 days
        $orders = Order::where('status', 'shipped')
                       ->whereNotNull('shipped_at')
                       ->where('shipped_at', '<=', $thresholdDate)
                       ->get();

        $count = 0;
        foreach ($orders as $order) {
            $order->update(['status' => 'completed']);
            $count++;
            $this->line("Order #{$order->order_number} marked as completed.");
        }

        $this->info("Process finished! Total orders auto-completed: {$count}");
    }
}
