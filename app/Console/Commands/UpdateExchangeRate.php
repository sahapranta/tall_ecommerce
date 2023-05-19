<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class UpdateExchangeRate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:exchange-rate {mode=all}';

    /**
     * The console command description.
     *
     * @todo
     *  In future by running this command we will first store
     *  the update in Storage as json file with update date
     *  then ask for confirmation and update database column
     *  if answer is no then show the value to manually update
     *  the file saved in storage will be used for limiting api call
     */
    protected $description = 'Update currency exchange rate from API.';


    protected function exchange_rate($from, $amount = 1, $to = 'USD')
    {
        $response = Http::acceptJson()
            ->withHeaders([
                "apikey" => env('CURRENCY_EXCHANGE_API_KEY')
            ])
            ->get("http://api.apilayer.com/exchangerates_data/convert", [
                'to' => $to,
                'from' => $from,
                'amount' => $amount,
            ])->json();

        return $response['result'];
    }

    public function result($currencies)
    {
        foreach ($currencies as $name) {
            $rate = $this->exchange_rate($name);
            $this->info("$name : $rate");
        }
    }

    public function handle()
    {
        $defaultCurrencies = ['HUF', "EUR", "GBP"];
        $mode = $this->argument('mode');
        if ($mode === 'all') {
            $this->info('The command was successful!');
            $this->result($defaultCurrencies);
        } elseif ($mode === 'one') {
            $names = $this->choice(
                'Which Currency Code?',
                $defaultCurrencies,
                0,
                null,
                true
            );
            $this->info('The command was successful!');
            $this->result($defaultCurrencies);
        }
    }
}
