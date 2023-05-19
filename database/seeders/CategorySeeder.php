<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Schema::enableForeignKeyConstraints();

        $data = [
            'Special Collection' => [
                "Rustic Wall Art",
                "Vintage Wall Decor",
                "Geometric Wall Art",
                "Botanical Wall Decor",
                "Boho Wall Art",
                "Coastal Wall Decor",
                "Typography Wall Art",
                "Minimalist Wall Art",
                "Contemporary Wall Decor",
                "Sculptural Wall Art",
                "Eclectic Wall Decor",
                "Mid-century Modern Wall Art",
                "Inspirational Wall Art",
            ],
            'Room Decor' => [
                'Abstract Wall Art',
                'Artistic Wall Decor',
                'Housewarming Gift',
                'Spiritual Wall Decor',
                'Modern Wood Wall Art',
                'Bedroom Wall Art',
                "Outdoor Wall Decor",
                "Farmhouse Wall Decor",
                'Kitchen Wall Decor',
            ],
            'Handmade' => [
                'Wood Wall Panels',
                'Kitty Decor',
                'Creativite Wall Art',
                'Elegant Wall Art',
            ],
            'Custom' => [
                'Natural Wood',
                'Laser Cut Wood Art',
                'Birch Plywood',
                'Multi Colored',
                "Custom Wall Art",
                '3D Wood Art',
            ],

        ];

        foreach ($data as $key => $value) {
            $category = Category::create(['name' => $key]);
            foreach ($value as $cat) {
                Category::create(['name' => $cat, 'parent_id' => $category->id]);
            }
        }
    }
}
