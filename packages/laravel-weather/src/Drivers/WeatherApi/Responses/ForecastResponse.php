<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\Forecast;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

class ForecastResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Location $location,
        public readonly Forecast $forecast,

        /** @var array<Alerts> */
        public readonly ?array $alerts
    ) {
        //
    }
}
