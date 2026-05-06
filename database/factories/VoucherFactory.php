<?php

namespace Database\Factories;

use App\Models\Voucher;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Voucher>
 */
class VoucherFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => strtoupper(fake()->unique()->bothify('??##??')),
            'discount_type' => fake()->randomElement(['fixed', 'percent']),
            'discount_value' => fake()->randomElement([10000, 20000, 50000, 10, 15, 20]),
            'min_order_amount' => fake()->randomElement([0, 50000, 100000]),
            'max_discount' => fake()->optional()->randomElement([50000, 100000]),
            'start_date' => now(),
            'end_date' => now()->addDays(30),
            'usage_limit' => fake()->optional()->numberBetween(10, 200),
            'used_count' => 0,
        ];
    }
}
