<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Responses;

use App\Services\Weather\Drivers\WeatherAPI\DTO\Location;
use App\Services\Weather\Drivers\WeatherAPI\Attributes\From;

class SearchResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        #[From('0')]
        public readonly Location $location
    ) {
        //
    }
}
