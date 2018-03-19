<?php

namespace App\Console\Commands;

use App\Models\Currency;
use App\Models\currencyRate;
use App\Services\CurrencyConverterInterface;
use Illuminate\Console\Command;

/**
 * Class CurrencyRatesCommand
 * @package App\Console\Commands
 */
class CurrencyRatesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch-rates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch current currency rates';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    const ORIGINAL_CURRENCY_CODE = 'USD';

    const RELATIVE_CURRENCY_CODE = 'EUR,CHF';

    /**
     * Execute the console command.
     *
     * @param CurrencyConverterInterface $currencyConverter
     * @return mixed
     */
    public function handle(CurrencyConverterInterface $currencyConverter)
    {
        try {
            $rates = $currencyConverter->convert(self::ORIGINAL_CURRENCY_CODE, self::RELATIVE_CURRENCY_CODE);

            foreach ($rates as $currencyCode => $rate) {
                $sourceCurrency = Currency::where('currency_code', '=', self::ORIGINAL_CURRENCY_CODE)->first();
                $convertedCurrency = Currency::where('currency_code', '=', $currencyCode)->first();

                if (!is_object($sourceCurrency)) {
                    $sourceCurrency = Currency::create(['currency_code' => self::ORIGINAL_CURRENCY_CODE]);
                }

                if (!is_object($convertedCurrency)) {
                    $convertedCurrency = Currency::create(['currency_code' => $currencyCode]);
                }

                CurrencyRate::updateorcreate([
                    'from_currency_id' => $sourceCurrency->id,
                    'to_currency_id' => $convertedCurrency->id
                ], ['rate' => $rate]);
            }

            $this->info("Currency converted and stored in DB table");
        } catch (\Exception $e) {
            $this->error('Could not store currency rates to DB');
        }
    }

}
