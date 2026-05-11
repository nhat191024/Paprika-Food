<?php

namespace App\Console\Commands;

use App\Models\Order;
use App\States\Order\Pending;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('order:test {--count=1 : Number of orders to create}')]
#[Description('Create test pending order(s) to trigger the incoming orders notification')]
class CreateTestOrder extends Command
{
    public function handle(): int
    {
        $count = (int) $this->option('count');

        $orders = Order::factory()
            ->count($count)
            ->state(['status' => Pending::class])
            ->create();

        foreach ($orders as $order) {
            $this->line("  Created: <info>{$order->order_number}</info> — {$order->final_amount} EUR");
        }

        $this->info("{$count} test pending order(s) created.");

        return self::SUCCESS;
    }
}
