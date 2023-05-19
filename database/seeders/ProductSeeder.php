<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Variant;
use App\Models\VariantOption;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */




    public function run(): void
    {
        Schema::disableForeignKeyConstraints();

        VariantOption::truncate();
        Variant::truncate();
        Product::truncate();
        DB::table('product_variant_options')->truncate();

        Schema::enableForeignKeyConstraints();


        Product::factory()
            ->count(50)
            ->create();
    }
}
