<?php

return [

    'default' => 'weather-api',

    'fallback-location' => env('WEATHER_FALLBACK_LOCATION', 'Dallas, TX'),

    'connections' => [
        'weather-api' => [
            'driver' => 'weatherApi',
            'key' => env('WEATHER_API_KEY'),
            'cache' => 'array'
        ]
    ]

];
