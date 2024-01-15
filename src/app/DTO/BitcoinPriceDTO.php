<?php

namespace App\DTO;

class BitcoinPriceDTO
{
    public $mid;
    public $bid;
    public $ask;
    public $lastPrice;
    public $low;
    public $high;
    public $volume;
    public $timestamp;

    public function __construct($data)
    {
        $this->mid = $data['mid'] ?? null;
        $this->bid = $data['bid'] ?? null;
        $this->ask = $data['ask'] ?? null;
        $this->lastPrice = $data['last_price'] ?? null;
        $this->low = $data['low'] ?? null;
        $this->high = $data['high'] ?? null;
        $this->volume = $data['volume'] ?? null;
        $this->timestamp = $data['timestamp'] ?? null;
    }
}
