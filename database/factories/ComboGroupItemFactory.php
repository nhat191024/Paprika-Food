<?php

namespace Database\Factories;

use App\Models\ComboGroup;
use App\Models\ComboGroupItem;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComboGroupItem>
 */
class ComboGroupItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'combo_group_id' => ComboGroup::factory(),
            'product_id' => Product::factory(),
            'extra_price' => fake()->randomElement([0, 5000, 10000, 15000]),
        ];
    }
}
