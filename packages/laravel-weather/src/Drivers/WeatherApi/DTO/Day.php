<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

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

        /** Total snow in centimeters. */
        public readonly ?float $totalsnow_cm,

        /** Average visibility in kilometer */
        public readonly float $avgvis_km,

        /** Average visibility in miles */
        public readonly float $avgvis_miles,

        /** Average humidity as percentage */
        public readonly int $avghumidity,

        /** Percentage that it will rain. */
        public readonly ?int $daily_will_it_rain,

        /** Percentage for chance of rain. */
        public readonly ?int $daily_chance_of_rain,

        /** Percentage that it will snow. */
        public readonly ?int $daily_will_it_snow,

        /** Percentage for chance of snow. */
        public readonly ?int $daily_chance_of_snow,


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
