<?php

namespace Database\Factories;

use App\Models\BitcoinPrice;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\BitcoinPrice>
 */
class BitcoinPriceFactory extends Factory
{

    protected $model = BitcoinPrice::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'currency_pair' => 'btcusd',
            'price' => $this->faker->randomNumber(5),
            'timestamp' => now(),
        ];
    }
}
