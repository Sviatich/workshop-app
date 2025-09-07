<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class PruneExpiredOrders extends Command
{
    protected $signature = 'orders:prune-expired {--days=}';

    protected $description = 'Delete orders (and files) older than expiration period';

    public function handle(): int
    {
        $days = (int) ($this->option('days') ?: config('orders.expiration_days', 30));

        $this->info("Pruning orders older than {$days} days...");

        $count = 0;

        Order::where('created_at', '<=', now()->subDays($days))
            ->orderBy('id')
            ->chunkById(200, function ($orders) use (&$count) {
                foreach ($orders as $order) {
                    try {
                        $order->delete();
                        $count++;
                    } catch (\Throwable $e) {
                        \Log::warning('Failed to prune expired order', [
                            'order_id' => $order->id,
                            'uuid' => $order->uuid,
                            'message' => $e->getMessage(),
                        ]);
                    }
                }
            });

        $this->info("Pruned {$count} orders.");

        return self::SUCCESS;
    }
}

