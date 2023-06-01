<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\Current;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

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
