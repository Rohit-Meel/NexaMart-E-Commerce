<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    public function definition(): array
    {
        $discountType = fake()->randomElement([
            'percentage',
            'fixed',
        ]);

        return [
            'code' => strtoupper(fake()->unique()->bothify('SAVE####')),
            'description' => fake()->sentence(8),
            'discount_type' => $discountType,
            'discount_value' => $discountType === 'percentage'
                ? fake()->numberBetween(5, 30)
                : fake()->numberBetween(50, 500),

            'minimum_order_amount' => fake()->numberBetween(500, 5000),
            'maximum_discount' => $discountType === 'percentage'
                ? fake()->numberBetween(100, 1000)
                : null,

            'usage_limit' => fake()->numberBetween(50, 500),
            'used_count' => fake()->numberBetween(0, 20),

            'start_at' => now(),
            'end_at' => now()->addDays(fake()->numberBetween(7, 30)),

            'status' => true,
        ];
    }
}