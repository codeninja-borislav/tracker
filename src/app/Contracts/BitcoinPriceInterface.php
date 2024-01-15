<?php

namespace App\Contracts;

interface BitcoinPriceInterface
{
    /**
     * Get the Bitcoin price for a given currency pair.
     *
     * @param string $currencyPair The currency pair for which to get the Bitcoin price.
     * @return array|null Returns the Bitcoin price data as an array, or null if unavailable.
     */
    public function getBitcoinPrice($currencyPair): ?array;
}
