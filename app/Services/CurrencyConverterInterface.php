<?php

namespace App\Services;

/**
 * Interface CurrencyConverterInterface
 * @package App\Services
 */
interface CurrencyConverterInterface
{
    public function convert($originalCurrencyCode, $relativeCurrencyCodes) :array;
}