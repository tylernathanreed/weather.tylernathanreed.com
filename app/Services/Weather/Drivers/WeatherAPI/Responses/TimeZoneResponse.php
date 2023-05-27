<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Responses;

use App\Services\Weather\Drivers\WeatherAPI\DTO\Location;

class TimeZoneResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Location $location
    ) {
        //
    }
}
