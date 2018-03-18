<?php

namespace App\Services;

interface CurrencyConverterInterface
{
    public function get($originalCurrencyCode, $relativeCurrencyCodes) :array;
}