<?php

namespace App\Http\Controllers;

use App\Contracts\BitcoinPriceInterface;
use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Enums\CurrencyPair;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class BitcoinController extends Controller
{
    public function __construct(
        private BitcoinPriceRepositoryInterface $bitcoinPriceRepository,
        private BitcoinPriceInterface $bitcoinPrice
    ){}

    /**
     * Get the current Bitcoin price for a specified currency pair.
     *
     * @param string $currencyPair The currency pair to get the price for.
     * @return JsonResponse
     */
    public function getCurrentPrice(string $currencyPair): JsonResponse
    {
        try {
            if (!CurrencyPair::tryFrom($currencyPair)) {
                return response()->json(['error' => 'Invalid currency pair'], 400);
            }

            $price = $this->bitcoinPrice->getBitcoinPrice($currencyPair);
            return response()->json(['price' => $price]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Get historical Bitcoin prices for a specified currency pair.
     *
     * @param Request $request
     * @param string $currencyPair The currency pair to get historical prices for.
     * @return JsonResponse
     */
    public function getHistoricalPrices(Request $request, string $currencyPair): JsonResponse
    {
        try {
            if (!CurrencyPair::tryFrom($currencyPair)) {
                return response()->json(['error' => 'Invalid currency pair'], 400);
            }

            $timeFrame = $request->input('time_frame', '24_hours');
            $date = $request->input('date', Carbon::today()->toDateString());

            $prices = $this->bitcoinPriceRepository->getHistoricalPriceData($currencyPair, $timeFrame, $date);
            return response()->json(['historical_prices' => $prices]);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
