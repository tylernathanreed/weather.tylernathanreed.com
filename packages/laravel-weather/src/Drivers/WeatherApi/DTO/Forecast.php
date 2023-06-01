<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\Attributes\Collect;

class Forecast extends DTO
{
    /**
     * Creates a new forecast DTO instance.
     */
    public function __construct(
        #[Collect(ForecastDay::class)]
        #[From('forecastday')]
        public readonly array $forecastDays
    ) {
        //
    }
}

