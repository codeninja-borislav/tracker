<?php

namespace App\Services;

use App\Contracts\BitcoinPriceInterface;
use Illuminate\Support\Facades\Http;

class BitfinexService implements BitcoinPriceInterface
{
    protected $baseUrl = 'https://api.bitfinex.com/v1/';

    public function getBitcoinPrice($currencyPair)
    {
        $response = Http::get($this->baseUrl . "pubticker/{$currencyPair}");
        return $response->json();
    }
}
