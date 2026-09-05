<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Banner>
 */
class BannerFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => fake()->sentence(4),
            'description' => fake()->sentence(10),
            'image' => 'Headphones.jpg',
            'button_text' => fake()->randomElement([
                'Shop Now',
                'Explore Now',
                'View Products',
            ]),
            'button_url' => '/products',
            'sort_order' => fake()->numberBetween(1, 10),
            'status' => true,
            'start_at' => now(),
            'end_at' => now()->addDays(30),
        ];
    }
}