<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'order_number',
            'customer_id',
            'item_count',
            'quantity',
            'taxrate',
            'subtotal',
            'discount',
            'shipping_weight',
            'shipping_charge',
            'total',
            'approved',
            'shipping_method',
            'billing_address',
            'shipping_address',
            'shipping_date',
            'delivery_date',
            'tracking_id',
            'payment_status',
            'payment_method_id',
            'message_to_customer',
        ];
    }
}
