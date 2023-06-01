<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Illuminate\Support\Carbon;

class Hour extends DTO
{
    /**
     * Creates a new hour DTO instance.
     */
    public function __construct(
        /** Time as epoch. */
        public readonly int $time_epoch,

        /** Date and time. */
        public readonly Carbon $time,

        /** Temperature in celsius. */
        public readonly float $temp_c,

        /** Temperature in fahrenheit. */
        public readonly float $temp_f,

        /** Weather condition. */
        public readonly Condition $condition,

        /** Maximum wind speed in miles per hour. */
        public readonly float $wind_mph,

        /** Maximum wind speed in kilometer per hour. */
        public readonly float $wind_kph,

        /** Wind direction in degrees. */
        public readonly int $wind_degree,

        /** Wind direction as 16 point compass. e.g.: NSW. */
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

        /** Feels like temperature as celcius. */
        public readonly float $feelslike_c,

        /** Feels like temperature as fahrenheit. */
        public readonly float $feelslike_f,

        /** Windchill temperature in celcius. */
        public readonly float $windchill_c,

        /** Windchill temperature in fahrenheit. */
        public readonly float $windchill_f,

        /** Heat index in celcius. */
        public readonly float $heatindex_c,

        /** Heat index in fahrenheit. */
        public readonly float $heatindex_f,

        /** Dew point in celcius. */
        public readonly float $dewpoint_c,

        /** Dew point in fahrenheit. */
        public readonly float $dewpoint_f,

        /** Will it will rain or not. */
        public readonly bool $will_it_rain,

        /** Will it snow or not. */
        public readonly bool $will_it_snow,

        /** Whether to show day condition icon or night icon. */
        public readonly bool $is_day,

        /** Visibility in kilometer. */
        public readonly float $vis_km,

        /** Visibility in miles. */
        public readonly float $vis_miles,

        /** Chance of rain as percentage. */
        public readonly int $chance_of_rain,

        /** Chance of snow as percentage. */
        public readonly int $chance_of_snow,

        /** Wind gust in miles per hour. */
        public readonly float $gust_mph,

        /** Wind gust in kilometer per hour. */
        public readonly float $gust_kph,

        /** UV Index. */
        public readonly float $uv,

        /** Air quality. */
        public readonly ?AirQuality $air_quality,

        /** Significant wave height in metres. */
        public readonly ?float $sig_ht_mt,

        /** Swell wave height in meters. */
        public readonly ?float $swell_ht_mt,

        /** Swell wave height in feet. */
        public readonly ?float $swell_ht_ft,

        /** Swell direction in degrees. */
        public readonly ?float $swell_dir,

        /** Swell direction in 16 point compass. */
        public readonly ?float $swell_dir_16_point,

        /** Swell period in seconds. */
        public readonly ?float $swell_period_secs,

        /** Water temperature in Celcius. */
        public readonly ?float $water_temp_c,

        /** Water temperature in Fahrenheit. */
        public readonly ?float $water_temp_f
    ) {
        //
    }
}
