<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Collection;

interface BitcoinPriceRepositoryInterface
{
    /**
     * Save the price data for a given currency pair.
     *
     * @param string $currencyPair The currency pair for which to save the price data.
     * @param array $priceData The price data to be saved.
     * @return bool Returns true on success, false on failure.
     */
    public function savePriceData(string $currencyPair, array $priceData): bool;

    /**
     * Fetch the latest price data and save it.
     *
     * @param string $currencyPair The currency pair for which to fetch and save the price data.
     * @return bool Returns true if both fetching and saving are successful, false otherwise.
     */
    public function fetchAndSavePriceData(string $currencyPair): bool;

    /**
     * Get historical price data for a given currency pair within a specified timeframe.
     *
     * @param string $currencyPair The currency pair for which to get historical price data.
     * @param string $timeFrame The timeframe for the historical data.
     */
    public function getHistoricalPriceData(string $currencyPair, string $timeFrame, ?string $date): Collection;

    /**
     * Get dynamic historical price data for a given currency pair and timeframe.
     *
     * @param string $currencyPair The currency pair for which to get historical price data.
     * @param string $timeFrame The timeframe for the historical data (e.g., '1_hour', '6_hours', '24_hours').
     * @return Collection Returns a collection of historical price data.
     */
    public function getDynamicHistoricalPriceData(string $currencyPair, string $timeFrame): Collection;
}
