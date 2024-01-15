<?php

namespace App\Console\Commands;

use App\Enums\CurrencyPair;
use App\Repositories\BitcoinPriceRepository;
use Illuminate\Console\Command;

class FetchBitcoinPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:fetch-bitcoin-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches Bitcoin prices and stores them in the database';

    public function __construct(private BitcoinPriceRepository $bitcoinPriceRepository)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Fetching Bitcoin prices...');

        $currencyPairs = CurrencyPair::cases();

        foreach ($currencyPairs as $pair) {
            $priceData = $this->bitcoinPriceRepository->getLatestPrice($pair->value);

            if ($priceData) {
                $this->bitcoinPriceRepository->savePriceData($pair->value, $priceData);
                $this->info("Price for {$pair->value} fetched and stored.");
            } else {
                $this->error("Failed to fetch price for {$pair->value}.");
            }
        }
    }
}
