<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\States\Product\Active;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enName = fake('en_US')->words(3, true);
        $elName = fake('el_GR')->words(3, true);
        $enDesc = fake('en_US')->sentence();
        $elDesc = fake('el_GR')->sentence();

        return [
            'category_id' => Category::factory(),
            'slug' => fake()->unique()->slug(3),
            'name' => ['en' => $enName, 'el' => $elName],
            'description' => ['en' => $enDesc, 'el' => $elDesc],
            'price' => fake()->randomFloat(2, 20000, 200000),
            'is_combo' => false,
            'status' => Active::$name,
        ];
    }

    public function combo(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_combo' => true,
        ]);
    }
}
