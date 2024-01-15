<?php

namespace App\Contracts;

interface BitcoinPriceRepositoryInterface
{
    /**
     * Get the latest price for a given currency pair.
     *
     * @param string $currencyPair The currency pair for which to get the latest price.
     * @return array|null Returns the latest price data as an array, or null if unavailable.
     */
    public function getLatestPrice(string $currencyPair): ?array;

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
     * @return array|null Returns an array of historical price data, or null if unavailable.
     */
    public function getHistoricalPriceData(string $currencyPair, string $timeFrame): ?array;
}
