<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

class IpLocation extends DTO
{
    /**
     * Creates a new IP location DTO instance.
     */
    public function __construct(
        /** IP address. */
        public readonly string $ip,

        /** ipv4 or ipv6. */
        public readonly string $type,

        /** Continent code. */
        public readonly string $continent_code,

        /** Continent name. */
        public readonly string $continent_name,

        /** Country code. */
        public readonly string $country_code,

        /** Name of country. */
        public readonly string $country_name,

        /** true or false. */
        public readonly bool $is_eu,

        /** Geoname ID. */
        public readonly string $geoname_id,

        /** City name. */
        public readonly string $city,

        /** Region name. */
        public readonly string $region,

        /** Latitude in decimal degree. */
        public readonly float $lat,

        /** Longitude in decimal degree. */
        public readonly float $lon,

        /** Time zone. */
        public readonly string $tz_id
    ) {
        //
    }
}
