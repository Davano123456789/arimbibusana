<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class AutoCompleteOrders extends Command
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
    protected $description = 'Automatically complete orders that have been shipped for more than 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting auto-completion of shipped orders...');
        
        // Define the threshold (7 days ago)
        $thresholdDate = Carbon::now()->subDays(7);

        // Find orders with status 'shipped' and shipped_at <= thresholdDate
        $orders = Order::where('status', 'shipped')
            ->whereNotNull('shipped_at')
            ->where('shipped_at', '<=', $thresholdDate)
            ->get();

        $count = 0;
        foreach ($orders as $order) {
            $order->update(['status' => 'completed']);
            $count++;
            
            $this->info("Order #{$order->order_number} has been automatically completed (7 days since shipped).");
            Log::info("Order #{$order->order_number} auto-completed after 7 days since shipping.");
        }

        $this->info("Total orders auto-completed: {$count}");
        
        return Command::SUCCESS;
    }
}
