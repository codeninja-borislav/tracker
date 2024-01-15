<?php

namespace App\Repositories;

use App\Contracts\BitcoinPriceInterface;
use App\Contracts\BitcoinPriceRepositoryInterface;
use App\Models\BitcoinPrice;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class BitcoinPriceRepository implements BitcoinPriceRepositoryInterface
{
    public function __construct(
        private BitcoinPriceInterface $bitcoinPrice
    ){}
    public function savePriceData($currencyPair, $priceData): bool
    {
        if (!isset($priceData->lastPrice)) {
            throw new InvalidArgumentException("Missing required key 'last_price'");
        }

        $bitcoinPrice = BitcoinPrice::create([
            'currency_pair' => $currencyPair,
            'price' => $priceData->lastPrice,
        ]);

        return $bitcoinPrice !== null;
    }

    public function fetchAndSavePriceData($currencyPair): bool
    {
        $priceData = $this->bitcoinPrice->getBitcoinPrice($currencyPair);
        if ($priceData) {
            return $this->savePriceData($currencyPair, $priceData);
        }
        return false;
    }

    public function getHistoricalPriceData($currencyPair, $timeFrame, ?string $date): Collection
    {
        $timePeriods = [
            '24_hours' => 24,
            '168_hours' => 168
        ];

        if (!array_key_exists($timeFrame, $timePeriods)) {
            throw new InvalidArgumentException("Unsupported time interval: $timeFrame");
        }

        $inputDate = $date ? Carbon::createFromFormat('Y-m-d', $date) : Carbon::now();

        if (!$inputDate) {
            throw new InvalidArgumentException("Invalid date format: $date");
        }

        $startTime = $timeFrame === '24_hours' ?
            $inputDate->copy()->startOfDay() :
            $inputDate->copy()->subDays(7)->startOfDay();

        $endTime = $inputDate->copy()->endOfDay();

        return BitcoinPrice::where('currency_pair', $currencyPair)
            ->whereBetween('created_at', [$startTime, $endTime])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getDynamicHistoricalPriceData($currencyPair, $timeFrame): Collection {
        $timePeriods = [
            '1_hour' => 1,
            '6_hours' => 6,
            '24_hours' => 24
        ];

        if (!array_key_exists($timeFrame, $timePeriods)) {
            throw new InvalidArgumentException("Unsupported time interval: $timeFrame");
        }

        $hoursBack = $timePeriods[$timeFrame];
        $startTime = Carbon::now()->subHours($hoursBack);

        return BitcoinPrice::where('currency_pair', $currencyPair)
            ->where('created_at', '>=', $startTime)
            ->orderBy('created_at', 'desc')
            ->get();
    }

}
