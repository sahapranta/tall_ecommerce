<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\TranslationLoader\LanguageLine;

class LanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LanguageLine::truncate();

        $jsonData = file_get_contents(database_path('language.json'));
        $data = json_decode($jsonData, true);

        $lines = [];
        foreach ($data as $group => $items) {
            foreach ($items as $key => $text) {
                // $lines[] = ['group' => $group, 'key' => $key, 'text' => $text];
                LanguageLine::create(['group' => $group, 'key' => $key, 'text' => $text]);
            }
        }
    }
}
