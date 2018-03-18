<?php

use App\Models\Currency;
use App\Models\currencyRate;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->cleanDatabase();
        $this->call('CurrencyTableSeeder');
    }

    /**
     * Truncates all tables in DB
     */
    public function cleanDatabase()
    {

        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Currency::truncate();
        CurrencyRate::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }

}
