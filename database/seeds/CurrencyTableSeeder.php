<?php

use App\Models\Currency;
use Illuminate\Database\Seeder;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = ['EUR', 'USD', 'CHF', 'JPY', 'GBP'];

        foreach ($currencies as $currency) {
            Currency::create([
                'currency_code' => $currency,
            ]);
        }

    }
}
