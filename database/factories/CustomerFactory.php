<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Customer>
 */
class CustomerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name',
            'email',
            'password',
            'dob',
            'sex',
            'last_visited_at',
            'last_visited_from',
            'stripe_id',
            'card_holder_name',
            'card_brand',
            'card_last_four',
            'active',
            'verification_token',
            'info',
        ];
    }
}
