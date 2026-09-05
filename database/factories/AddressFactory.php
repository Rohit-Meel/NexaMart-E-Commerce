<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'address_type' => fake()->randomElement([
                'home',
                'office',
            ]),
            'full_name' => fake()->name(),
            'phone' => fake()->unique()->numerify('9#########'),
            'address' => fake()->streetAddress(),
            'area' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->state(),
            'pincode' => fake()->numerify('######'),
            'is_default' => false,
        ];
    }
}