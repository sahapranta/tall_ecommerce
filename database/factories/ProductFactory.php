<?php

namespace Database\Factories;

use App\Enums\ProductStatusEnum;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "user_id" => 1,
            "title" => fake()->text(mt_rand(20, 30)),
            "status" => (ProductStatusEnum::Published)->value,
            "sale_count" => mt_rand(10, 200),
            "category_id" => Category::pluck('id')->random(),
            "description" => fake()->realText(mt_rand(250, 500)),
        ];
    }
}
