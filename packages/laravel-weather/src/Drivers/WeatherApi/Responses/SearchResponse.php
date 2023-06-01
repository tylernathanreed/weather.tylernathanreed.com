<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\Location;
use Reedware\Weather\Drivers\WeatherApi\Attributes\From;

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
