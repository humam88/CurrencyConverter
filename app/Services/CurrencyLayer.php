<?php
/**
 * Created by PhpStorm.
 * User: humam
 * Date: 17.03.18
 * Time: 01:55
 */
namespace App\Services;

Use OceanApplications\currencylayer\client;

class CurrencyLayer implements CurrencyConverterInterface
{
    /**
     * @param string $originalCurrencyCode
     * @param string $relativeCurrencyCodes
     * @return array
     */
    public function get($originalCurrencyCode = 'USD', $relativeCurrencyCodes = 'JPY,GBP,EUR') : array
    {
        $ApiKey= env('CURRENCYLAYER_API_KEY');

        $currencyLayer = new  client($ApiKey);

        $response = $currencyLayer->source($originalCurrencyCode)
            ->currencies($relativeCurrencyCodes)
            ->live();

        $quotes = $response['quotes'];

        $result = [];
        foreach ($quotes as $Key => $quote) {
            $relativeCurrencyCode = trim($Key, $originalCurrencyCode);
            $result[$relativeCurrencyCode] = $quote;
        }
        return $result;
    }
}