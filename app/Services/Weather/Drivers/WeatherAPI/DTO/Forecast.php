<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

class Forecast extends DTO
{
    /**
     * Creates a new forecast DTO instance.
     */
    public function __construct(
        /** @var array<ForecastDay> */
        public readonly array $forecastDays
    ) {
        //
    }
}

