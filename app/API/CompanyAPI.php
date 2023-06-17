<?php

namespace App\API;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class CompanyAPI {
    protected $client;
    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @return string
     */
    private function baseUrl(): string {
        return config('api.company_data.base_url');
    }

    /**
     * @return array
     * @throws GuzzleException
     */
    public function getAllCompany():array {
        $key = 'company-data';
        if(Cache::has($key)) {
            return Cache::get($key);
        }
        $companies = [];
        try {
            $guzzleResponse = $this->client->get(
                $this->baseUrl().'/core/nasdaq-listings/nasdaq-listed_json/data/a5bc7580d6176d60ac0b2142ca8d7df6/nasdaq-listed_json.json', [
            ]);

            if ($guzzleResponse->getStatusCode() == 200) {
                $companies = json_decode($guzzleResponse->getBody(), true);
                if (!blank($companies)) {
                    Cache::put($key, $companies, 600);
                }
            }

        } catch(\Exception $e){
            Log::info($e->getMessage());
            return $companies;
        }

        return $companies;
    }

}
