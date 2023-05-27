<?php

return [

    'default' => 'weather-api',

    'connections' => [
        'weather-api' => [
            'driver' => 'weatherApi',
            'key' => env('WEATHER_API_KEY')
        ]
    ]

];
