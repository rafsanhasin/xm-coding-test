<?php

return [
    'company_data' => [
        'base_url'  => env('COMPANY_DATA_URL'),
    ],

    'stock_data' => [
        'base_url'  => env('STOCK_DATA_URL'),
        'headers'  => [
            'API-Key' => env('STOCK_API_KEY'),
            'API-Host' => env('STOCK_API_Host'),
        ],
    ],
];
