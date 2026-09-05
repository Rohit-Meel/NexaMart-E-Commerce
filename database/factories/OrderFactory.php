<?php

namespace Database\Factories;

use App\Models\Address;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    public function definition(): array
    {
        $subtotal = fake()->randomFloat(2, 500, 50000);
        $discount = fake()->randomFloat(2, 0, 1000);
        $shipping = fake()->randomFloat(2, 0, 150);
        $tax = fake()->randomFloat(2, 20, 500);

        $total = $subtotal - $discount + $shipping + $tax;

        $customer = Customer::inRandomOrder()->first();

        $address = Address::where('customer_id', $customer->id)
            ->inRandomOrder()
            ->first();

        return [
            'customer_id' => $customer->id,
            'address_id' => $address?->id,

            'order_number' => 'ORD-' . strtoupper(Str::random(10)),

            'subtotal' => $subtotal,
            'discount' => $discount,
            'shipping_charge' => $shipping,
            'tax' => $tax,
            'total_amount' => $total,

            'coupon_code' => null,

            'payment_method' => fake()->randomElement([
                'cod',
                'online',
            ]),

            'payment_status' => fake()->randomElement([
                'pending',
                'paid',
                'failed',
            ]),

            'order_status' => fake()->randomElement([
                'pending',
                'confirmed',
                'processing',
                'shipped',
                'delivered',
                'cancelled',
            ]),

            'customer_note' => fake()->optional()->sentence(),

            'placed_at' => fake()->dateTimeBetween(
                '-30 days',
                'now'
            ),
        ];
    }
}