<?php

namespace Database\Factories;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Notification>
 */
class NotificationFactory extends Factory
{
    public function definition(): array
    {
        $isRead = fake()->boolean(40);

        return [
            'customer_id' => Customer::inRandomOrder()->first()->id,
            'title' => fake()->sentence(5),
            'message' => fake()->sentence(12),
            'type' => fake()->randomElement([
                'order',
                'promotion',
                'system',
                'general',
            ]),
            'url' => null,
            'is_read' => $isRead,
            'read_at' => $isRead
                ? fake()->dateTimeBetween('-30 days', 'now')
                : null,
        ];
    }
}