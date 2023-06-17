<?php

namespace App\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class StockAPI {
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return Repository|Application|mixed
     */
    private function baseUrl(): string {
        return config('api.stock_data.base_url');
    }

    /**
     * @return array
     */
    private function headers(): array
    {
        return [
            'X-RapidAPI-Key' => config('api.stock_data.headers.API-Key'),
            'X-RapidAPI-Host' => config('api.stock_data.headers.API-Host'),
        ];
    }


    /**
     * @param $symbol
     * @return array
     * @throws GuzzleException
     */
    public function getStockPrices($symbol): array {
        $key = 'prices-data-'.$symbol;
        if(Cache::has($key)) {
            return Cache::get($key);
        }
        $prices = [];

        try {
            $guzzleResponse = $this->client->request('GET',
                $this->baseUrl().'/stock/v3/get-historical-data?symbol='.$symbol, [
                    'headers' => $this->headers(),
            ]);

            if ($guzzleResponse->getStatusCode() == 200) {
                $response = json_decode($guzzleResponse->getBody(), true);
                $prices = $response['prices'] ?? [];

                if (!blank($prices)) {
                    Cache::put($key, $prices, 600);
                }
            }

        } catch(\Exception $e){
            Log::info($e->getMessage());
            return $prices;
        }

        return $prices;
    }

}
