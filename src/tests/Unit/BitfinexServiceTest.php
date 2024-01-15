<?php

use Tests\TestCase;
use App\Services\BitfinexService;
use Illuminate\Support\Facades\Http;

class BitfinexServiceTest extends TestCase
{
    /** @test */
    public function it_fetches_bitcoin_price_successfully()
    {
        Http::fake([
            'api.bitfinex.com/v1/pubticker/btcusd' => Http::response(['last_price' => '50000'], 200),
        ]);

        $service = new BitfinexService();
        $response = $service->getBitcoinPrice('btcusd');

        $this->assertEquals('50000', $response['last_price']);
    }

    /** @test */
    public function it_handles_api_failure_gracefully()
    {
        Http::fake([
            'api.bitfinex.com/v1/pubticker/btcusd' => Http::response(null, 500),
        ]);

        $service = new BitfinexService();
        $response = $service->getBitcoinPrice('btcusd');

        $this->assertNull($response);
    }

}
