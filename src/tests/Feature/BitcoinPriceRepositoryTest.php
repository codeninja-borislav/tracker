<?php

use App\Models\BitcoinPrice;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;
use App\Repositories\BitcoinPriceRepository;
use App\Contracts\BitcoinPriceInterface;

class BitcoinPriceRepositoryTest extends TestCase
{
    /** @test */
    public function it_retrieves_data_from_service()
    {
        $mockService = $this->mock(BitcoinPriceInterface::class);
        $mockService->shouldReceive('getBitcoinPrice')->once()->andReturn(['last_price' => '50000']);

        $repository = new BitcoinPriceRepository($mockService);
        $response = $repository->getLatestPrice('btcusd');

        $this->assertEquals('50000', $response['last_price']);
    }

    /** @test */
    public function it_saves_valid_price_data_correctly()
    {
        $mockData = ['currency_pair' => 'btcusd', 'last_price' => '50000'];

        $bitcoinPriceMock = Mockery::mock('overload:App\Models\BitcoinPrice');
        $bitcoinPriceMock->shouldReceive('create')
            ->once()
            ->with([
                'currency_pair' => 'btcusd',
                'price' => '50000'
            ])
            ->andReturnSelf();

        $mockService = Mockery::mock(BitcoinPriceInterface::class);
        $mockService->shouldReceive('getBitcoinPrice')
            ->with('btcusd')
            ->andReturn($mockData);

        $repository = new BitcoinPriceRepository($mockService);

        $repository->savePriceData('btcusd', $mockData);
    }

    /** @test */
    public function it_handles_invalid_data_gracefully()
    {
        $invalidData = ['currency_pair' => 'btcusd']; // missing last_price field

        $mockService = Mockery::mock(BitcoinPriceInterface::class);
        $mockService->shouldReceive('getBitcoinPrice')
            ->with('btcusd')
            ->andReturn($invalidData);

        $repository = new BitcoinPriceRepository($mockService);

        $this->expectException(\InvalidArgumentException::class);
        $repository->savePriceData('btcusd', $invalidData);
    }

    /** @test */
    public function it_fetches_and_saves_price_data_correctly()
    {
        $mockService = Mockery::mock(BitcoinPriceInterface::class);
        $mockService->shouldReceive('getBitcoinPrice')
            ->once()
            ->with('btcusd')
            ->andReturn(['last_price' => '50000']);

        $bitcoinPriceMock = Mockery::mock('overload:App\Models\BitcoinPrice');
        $bitcoinPriceMock->shouldReceive('create')
            ->once()
            ->with([
                'currency_pair' => 'btcusd',
                'price' => '50000'
            ])
            ->andReturnSelf();

        $repository = new BitcoinPriceRepository($mockService);

        $savedData = $repository->fetchAndSavePriceData('btcusd');

        $this->assertNotNull($savedData);
    }
}
