<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Responses;

use App\Services\Weather\Drivers\WeatherAPI\DTO\Astro;
use App\Services\Weather\Drivers\WeatherAPI\DTO\Location;
use App\Services\Weather\Drivers\WeatherAPI\Attributes\From;

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
