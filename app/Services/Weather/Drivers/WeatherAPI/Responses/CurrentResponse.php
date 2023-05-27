<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Responses;

use App\Services\Weather\Drivers\WeatherAPI\DTO\Current;
use App\Services\Weather\Drivers\WeatherAPI\DTO\Location;

class CurrentResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Location $location,
        public readonly Current $current
    ) {
        //
    }
}
