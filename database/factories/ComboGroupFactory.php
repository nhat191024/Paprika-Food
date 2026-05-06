<?php

namespace Database\Factories;

use App\Models\ComboGroup;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ComboGroup>
 */
class ComboGroupFactory extends Factory
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
            'product_id' => Product::factory()->combo(),
            'name' => ['en' => $enName, 'el' => $elName],
            'min_select' => 1,
            'max_select' => 1,
            'is_required' => true,
        ];
    }
}
