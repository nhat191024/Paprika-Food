<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $enName = fake('en_US')->words(2, true);
        $elName = fake('el_GR')->words(2, true);

        return [
            'name' => ['en' => $enName, 'el' => $elName],
            'slug' => fake()->unique()->slug(2),
            'parent_id' => null,
        ];
    }
}
