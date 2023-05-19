<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\TranslationLoader\LanguageLine;

class AddLanguageLine extends Command
{
    protected $signature = 'new:lang {--en= : English translation} {--hu= : Hungarian translation}';

    protected $description = 'Add a new language line';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $group = $this->ask('Enter the group name');
        $key = $this->ask('Enter the key name');

        $en = $this->option('en') ?? $this->ask('Enter the English translation');
        $hu = $this->option('hu') ?? $this->ask('Enter the Hungarian translation');

        $textArray = [
            'en' => $en,
            'hu' => $hu,
        ];

        LanguageLine::create([
            'text' => $textArray,
            'group' => $group,
            'key' => $key,
        ]);

        $jsonFilePath = database_path('language.json');
        $json = file_get_contents($jsonFilePath);
        $langArray = json_decode($json, true);

        if (!isset($langArray[$group])) {
            $langArray[$group] = [];
        }

        $langArray[$group][$key] = $textArray;

        file_put_contents($jsonFilePath, json_encode($langArray, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $this->info('Language line created successfully.');
    }
}
