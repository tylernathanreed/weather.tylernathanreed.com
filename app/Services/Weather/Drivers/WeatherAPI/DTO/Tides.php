<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

class Tides extends DTO
{
    /**
     * Creates a new condition DTO instance.
     */
    public function __construct(
        /** Local tide time. */
        public readonly string $tide_time,

        /** Tide height in mountain time. */
        public readonly float $tide_height_mt,

        /** Type of tide i.e. High or Low. */
        public readonly string $tide_type,
    ) {
        //
    }
}
