<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

class Current extends DTO
{
    /**
     * Creates a new current DTO instance.
     */
    public function __construct(
        /** Local time when the real time data was updated. */
        public readonly string $last_updated,

        /** Local time when the real time data was updated in unix time. */
        public readonly int $last_updated_epoch,

        /** Temperature in celsius. */
        public readonly float $temp_c,

        /** Temperature in fahrenheit. */
        public readonly float $temp_f,

        /** Feels like temperature in celsius. */
        public readonly float $feelslike_c,

        /** Feels like temperature in fahrenheit. */
        public readonly float $feelslike_f,

        /** Weather condition. */
        public readonly Condition $condition,

        /** Wind speed in miles per hour. */
        public readonly float $wind_mph,

        /** Wind speed in kilometer per hour. */
        public readonly float $wind_kph,

        /** Wind direction in degrees. */
        public readonly int $wind_degree,

        /** Wind direction as 16 point compass. */
        public readonly string $wind_dir,

        /** Pressure in millibars. */
        public readonly float $pressure_mb,

        /** Pressure in inches. */
        public readonly float $pressure_in,

        /** Precipitation amount in millimeters. */
        public readonly float $precip_mm,

        /** Precipitation amount in inches. */
        public readonly float $precip_in,

        /** Humidity as percentage. */
        public readonly int $humidity,

        /** Cloud cover as percentage. */
        public readonly int $cloud,

        /** Whether to show day condition icon or night icon. */
        public readonly bool $is_day,

        /** UV Index. */
        public readonly float $uv,

        /** Wind gust in miles per hour. */
        public readonly float $gust_mph,

        /** Wind gust in kilometer per hour. */
        public readonly float $gust_kph,

        /** Air quality data */
        public readonly ?AirQuality $air_quality
    ) {
        //  
    }
}
