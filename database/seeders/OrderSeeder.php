<?php

namespace Database\Seeders;

use App\Enums\OrderType;
use App\Enums\PaymentMethods;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = Customer::all();
        $products = Product::whereIsCombo(false)->get();

        if ($customers->isEmpty() || $products->isEmpty()) {
            $this->command->warn('OrderSeeder skipped: no customers or products found. Run UserSeeder and ProductSeeder first.');

            return;
        }

        // Completed dine-in orders
        Order::factory()
            ->count(10)
            ->dineIn()
            ->completed()
            ->recycle($customers)
            ->create()
            ->each(function (Order $order) use ($products) {
                $this->attachItems($order, $products);
            });

        // Completed online orders
        Order::factory()
            ->count(10)
            ->online()
            ->completed()
            ->recycle($customers)
            ->create()
            ->each(function (Order $order) use ($products) {
                $this->attachItems($order, $products);
            });

        // Pending orders
        Order::factory()
            ->count(5)
            ->pending()
            ->recycle($customers)
            ->create()
            ->each(function (Order $order) use ($products) {
                $this->attachItems($order, $products);
            });

        // Processing orders
        Order::factory()
            ->count(3)
            ->state(['status' => Processing::class])
            ->recycle($customers)
            ->create()
            ->each(function (Order $order) use ($products) {
                $this->attachItems($order, $products);
            });

        // Cancelled orders
        Order::factory()
            ->count(5)
            ->cancelled()
            ->recycle($customers)
            ->create()
            ->each(function (Order $order) use ($products) {
                $this->attachItems($order, $products);
            });
    }

    private function attachItems(Order $order, \Illuminate\Database\Eloquent\Collection $products): void
    {
        $selectedProducts = $products->random(fake()->numberBetween(1, 3));
        $totalAmount = 0;

        foreach ($selectedProducts as $product) {
            $quantity = fake()->numberBetween(1, 4);
            $price = $product->price;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $price,
            ]);

            $totalAmount += $price * $quantity;
        }

        $order->update([
            'total_amount' => $totalAmount,
            'final_amount' => $totalAmount,
        ]);
    }
}
