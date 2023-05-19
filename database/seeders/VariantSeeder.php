<?php

namespace Database\Seeders;

use App\Models\Variant;
use App\Models\Product;
use Illuminate\Support\Arr;
use Facades\App\Helpers\SKU;
use App\Models\VariantOption;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class VariantSeeder extends Seeder
{
    protected $sizes = ['small', 'medium', 'large', 'xl', 'lg', 'md', 'sm', 'xxl'];
    protected $colors = ['red', 'white', 'green', 'black', 'yellow', 'blue', 'brown', 'magenta', 'cyan', 'purple'];

    protected function getCombinations(): array
    {
        $combinations = [];
        foreach ($this->sizes as $size) {
            foreach ($this->colors as $color) {
                $combinations[] = [$color, $size];
            }
        }
        return $combinations;
    }

    protected function getOne($name, $key)
    {
        $data =  $this->{$name};
        return $data[$key];
    }



    public function run(): void
    {
        Product::all()->each(function ($product) {
            // Get color, size or both dynamically
            $options = Arr::random(['color', 'size'], rand(1, 2));

            // create product variation for each option
            foreach ($options as $value) {
                VariantOption::create(['product_id' => $product->id, 'name' => $value]);
            }

            $variant_count = count($options) > 1 ? 5 : 3;
            // Create 2-5 different Variant with SKU, PRICE...
            Variant::factory(mt_rand(2, $variant_count))
                ->sequence(fn () => ['sku' => SKU::make($product->title)])
                ->create(['product_id' => $product->id]);

            // Dynamically attach different values of Size, Color or Both
            $product->variants->each(function ($variant, $key) use ($product) {
                $numOptions = $product->variantOptions()->count();

                if ($numOptions > 1) {
                    $combination = Arr::random($this->getCombinations());
                    $product->variantOptions->each(
                        fn ($option, $key) =>
                        $option->options()->attach($variant->id, ['value' => $combination[$key]])
                    );
                } else {

                    $product->variantOptions->each(
                        fn ($option, $key) =>
                        $option->options()
                            ->attach($variant->id, ['value' => Arr::random($this->{$option->name . 's'})])

                    );
                }
            });
        });
    }
}
