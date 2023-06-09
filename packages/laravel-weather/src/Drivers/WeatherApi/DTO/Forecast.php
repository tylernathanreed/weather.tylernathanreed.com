<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\Attributes\From;

class Forecast extends DTO
{
    /**
     * Creates a new forecast DTO instance.
     */
    public function __construct(
        #[ArrayOf(ForecastDay::class)]
        #[From('forecastday')]
        public readonly array $forecast_days
    ) {
        //
    }
}

