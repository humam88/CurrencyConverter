<?php

use App\Services\CurrencyConverterInterface;
use Illuminate\Support\Facades\Artisan;

/**
 * Class CommandTest
 */
class FetchCurrencyRatesCommandTest extends TestCase
{
    /**
     * @test
     */
    public function TestCommand()
    {
        $mockedCurrencyLayer = $this->createMock(\App\Services\CurrencyLayer::class);
        $this->app->instance(CurrencyConverterInterface::class, $mockedCurrencyLayer);

        Artisan::call('fetch-rates');
        $response  = Artisan::output();
        $this->assertContains('Currency converted and stored in DB table', $response);
    }

}
