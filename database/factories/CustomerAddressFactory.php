<?php

namespace Database\Factories;

use App\Models\Customer;
use App\Models\CustomerAddress;
use App\Models\Location;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<CustomerAddress>
 */
class CustomerAddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => Customer::factory(),
            'location_id' => Location::factory(),
            'recipient_name' => fake()->name(),
            'phone' => fake()->phoneNumber(),
            'address_detail' => fake()->streetAddress(),
            'is_default' => false,
        ];
    }
}
