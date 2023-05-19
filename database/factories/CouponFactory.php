<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Coupon>
 */
class CouponFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    const TYPES = ['amount', 'percent'];

    const TEXT = [
        "Limited time offer: Save up to X% on selected products!",
        "Don't miss out on our biggest sale of the year!",
        "Get X% off your purchase when you use the code [CODE] at checkout.",
        "Mega discount alert! Save big on our entire stock.",
        "For a limited time, enjoy huge discounts on our most popular items.",
        "Black Friday comes early: Get X% off everything in-store and online.",
        "End of season sale: Take an extra X% off already reduced prices.",
    ];

    public function definition(): array
    {
        $type = self::TYPES[rand(0, 1)];
        $value = $type === 'amount' ? mt_rand(10, 40) : mt_rand(2, 12);

        return [
            // 'code' => fake()->regexify('[A-Z0-9]{8}'),
            'code' => fake()->numerify(mb_strtoupper(fake()->firstNameFemale()) . '##'),
            'type' => $type,
            'value' => $value * 5,
            'min_amount' => mt_rand(2, 4) * 50,
            'max_amount' => mt_rand(1, 4) * 500,
            'starting_time' => fake()->dateTimeThisMonth(),
            'ending_time' => fake()->dateTimeBetween('now', '+3 months'),
            'active' => 1,
            'description' => self::TEXT[rand(0, 6)]
        ];
    }
}
