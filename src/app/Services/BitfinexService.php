<?php

namespace App\Services;

use App\Contracts\BitcoinPriceInterface;
use App\DTO\BitcoinPriceDTO;
use Illuminate\Support\Facades\Http;

class BitfinexService implements BitcoinPriceInterface
{
    protected $baseUrl = 'https://api.bitfinex.com/v1/';

    public function getBitcoinPrice(string $currencyPair):  ?BitcoinPriceDTO
    {
        $response = Http::get($this->baseUrl . "pubticker/{$currencyPair}");

        if ($response->successful()) {
            $responseData = $response->json();
            return new BitcoinPriceDTO($responseData ?? []);
        }

        return null;
    }
}
