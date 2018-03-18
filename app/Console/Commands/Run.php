<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\currencyRate;
use App\Services\CurrencyConverterInterface;
use Illuminate\Console\Command;
use App\Services\CurrencyLayer;

class Run extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @param CurrencyConverterInterface $currencyConverter
     * @return mixed
     */
    public function handle(CurrencyConverterInterface $currencyConverter)
    {
        $originalCurrencyCode = 'USD';
        $relativeCurrencyCodes = 'EUR,CHF';
        $rates = $currencyConverter->get($originalCurrencyCode, $relativeCurrencyCodes);

        foreach ($rates as $currencyCode => $rate) {
            $sourceCurrency = Currency::where('currency_code', '=', $originalCurrencyCode)->first();
            $convertedCurrency = Currency::where('currency_code', '=', $currencyCode)->first();

            if (!is_object($sourceCurrency)) {
                $sourceCurrency = Currency::create(['currency_code' => $originalCurrencyCode]);
            }

            if (!is_object($convertedCurrency)) {
                $convertedCurrency = Currency::create(['currency_code' => $currencyCode]);
            }

            CurrencyRate::updateorcreate(['from_currency_id' => $sourceCurrency->id, 'to_currency_id' => $convertedCurrency->id] , ['rate' => $rate]);
        }

        echo "Currency converted and stored in DB table \n";
    }
}
