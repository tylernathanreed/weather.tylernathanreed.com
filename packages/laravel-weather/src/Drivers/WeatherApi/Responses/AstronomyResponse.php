<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\DomainObjects\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\DTO\Astro;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

class AstronomyResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Location $location,

        #[From('astronomy.astro')]
        public readonly Astro $astronomy
    ) {
        //
    }
}
