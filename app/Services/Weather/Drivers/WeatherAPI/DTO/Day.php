<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

class Day extends DTO
{
    /**
     * Creates a new day DTO instance.
     */
    public function __construct(
        /** Maximum temperature in celsius for the day. */
        public readonly float $maxtemp_c,

        /** Maximum temperature in fahrenheit for the day. */
        public readonly float $maxtemp_f,

        /** Minimum temperature in celsius for the day. */
        public readonly float $mintemp_c,

        /** Minimum temperature in fahrenheit for the day. */
        public readonly float $mintemp_f,

        /** Average temperature in celsius for the day. */
        public readonly float $avgtemp_c,

        /** Average temperature in fahrenheit for the day. */
        public readonly float $avgtemp_f,

        /** Maximum wind speed in miles per hour. */
        public readonly float $maxwind_mph,

        /** Maximum wind speed in kilometer per hour. */
        public readonly float $maxwind_kph,

        /** Total precipitation in milimeter. */
        public readonly float $totalprecip_mm,

        /** Total precipitation in inches */
        public readonly float $totalprecip_in,

        /** Average visibility in kilometer */
        public readonly float $avgvis_km,

        /** Average visibility in miles */
        public readonly float $avgvis_miles,

        /** Average humidity as percentage */
        public readonly int $avghumidity,

        /** Weather condition. */
        public readonly Condition $condition,

        /** UV Index. */
        public readonly float $uv,

        /** Air quality. */
        public readonly ?AirQuality $air_quality
    ) {
        //
    }
}
