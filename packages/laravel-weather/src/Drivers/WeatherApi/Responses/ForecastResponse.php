<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\DTO\Alert;
use Reedware\Weather\Drivers\WeatherApi\DTO\Current;
use Reedware\Weather\Drivers\WeatherApi\DTO\Forecast;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

class ForecastResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Location $location,
        public readonly Current $current,
        public readonly Forecast $forecast,

        #[From('alerts.alert')]
        #[ArrayOf(Alert::class)]
        public readonly ?array $alerts
    ) {
        //
    }
}
