<?php

namespace App\Http\Controllers;

use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Enums\CurrencyPair;
use Exception;
use Illuminate\Http\Request;

class BitcoinController extends Controller
{
    public function __construct(private BitcoinPriceRepositoryInterface $bitcoinPriceRepository)
    {
    }

    public function getCurrentPrice($currencyPair)
    {
        try {
            if (!CurrencyPair::tryFrom($currencyPair)) {
                return response()->json(['error' => 'Invalid currency pair'], 400);
            }

            $price = $this->bitcoinPriceRepository->getLatestPrice($currencyPair);
            return response()->json(['price' => $price]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getHistoricalPrices(Request $request, $currencyPair)
    {
        try {
            if (!CurrencyPair::tryFrom($currencyPair)) {
                return response()->json(['error' => 'Invalid currency pair'], 400);
            }

            $timeFrame = $request->input('time_frame', 'daily');

            $prices = $this->bitcoinPriceRepository->getHistoricalPriceData($currencyPair, $timeFrame);
            return response()->json(['historical_prices' => $prices]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
