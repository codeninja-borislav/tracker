<?php

namespace App\Repositories;

use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Contracts\BitcoinPriceInterface;
use App\Models\BitcoinPrice;
use InvalidArgumentException;

class BitcoinPriceRepository implements BitcoinPriceRepositoryInterface
{
    public function __construct(protected BitcoinPriceInterface $bitcoinPriceService)
    {
    }

    public function getLatestPrice($currencyPair)
    {
        return $this->bitcoinPriceService->getBitcoinPrice($currencyPair);
    }

    public function savePriceData($currencyPair, $priceData)
    {
        if (!isset($priceData['last_price'])) {
            throw new InvalidArgumentException("Missing required key 'last_price'");
        }

        return BitcoinPrice::create([
            'currency_pair' => $currencyPair,
            'price' => $priceData['last_price'],
        ]);
    }

    public function fetchAndSavePriceData($currencyPair)
    {
        $priceData = $this->getLatestPrice($currencyPair);
        if ($priceData) {
            return $this->savePriceData($currencyPair, $priceData);
        }
        return null;
    }

    public function getHistoricalPriceData($currencyPair, $timeFrame)
    {
        $timePeriods = [
            '1_hour' => 1,
            '6_hours' => 6,
            '24_hours' => 24,
        ];

        if (!array_key_exists($timeFrame, $timePeriods)) {
            throw new InvalidArgumentException("Unsupported time interval: $timeFrame");
        }

        // Calculate the start time based on the specified time interval
        $startTime = now()->subHours($timePeriods[$timeFrame]);

        // Fetch historical price data within the specified time interval
        return BitcoinPrice::where('currency_pair', $currencyPair)
            ->where('created_at', '>=', $startTime)
            ->orderBy('created_at', 'desc')
            ->get();
    }


}
