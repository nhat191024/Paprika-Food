<?php

namespace Database\Factories;

use App\Models\Banner;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'link' => fake()->optional()->url(),
            'sort_order' => fake()->numberBetween(0, 10),
            'status' => true,
        ];
    }
}
