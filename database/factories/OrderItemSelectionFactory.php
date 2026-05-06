<?php

namespace Database\Factories;

use App\Models\OrderItem;
use App\Models\OrderItemSelection;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<OrderItemSelection>
 */
class OrderItemSelectionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_item_id' => OrderItem::factory(),
            'product_id' => Product::factory(),
            'extra_price' => fake()->randomElement([0, 5000, 10000]),
        ];
    }
}
