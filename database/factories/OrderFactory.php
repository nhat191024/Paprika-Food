<?php

namespace Database\Factories;

use App\Enums\OrderType;
use App\Enums\PaymentMethods;
use App\Models\Customer;
use App\Models\Order;
use App\States\Order\Cancelled;
use App\States\Order\Completed;
use App\States\Order\Pending;
use App\States\Order\Processing;
use App\States\Order\Ready;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total = fake()->randomFloat(2, 50000, 500000);

        return [
            'user_id' => Customer::factory(),
            'order_number' => 'ORD-'.strtoupper(fake()->unique()->bothify('####??')),
            'total_amount' => $total,
            'discount_amount' => 0,
            'final_amount' => $total,
            'status' => fake()->randomElement([Pending::class, Processing::class, Ready::class, Completed::class, Cancelled::class]),
            'payment_method' => fake()->randomElement(PaymentMethods::cases()),
            'order_type' => fake()->randomElement(OrderType::cases()),
            'customer_address_id' => null,
            'delivery_recipient_name' => null,
            'delivery_phone' => null,
            'delivery_address_detail' => null,
        ];
    }

    public function pending(): static
    {
        return $this->state(fn (array $attributes) => ['status' => Pending::class]);
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => ['status' => Completed::class]);
    }

    public function cancelled(): static
    {
        return $this->state(fn (array $attributes) => ['status' => Cancelled::class]);
    }

    public function online(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_type' => OrderType::ONLINE,
            'delivery_recipient_name' => fake()->name(),
            'delivery_phone' => fake()->phoneNumber(),
            'delivery_address_detail' => fake()->address(),
        ]);
    }

    public function dineIn(): static
    {
        return $this->state(fn (array $attributes) => [
            'order_type' => OrderType::DINE_IN,
        ]);
    }
}
