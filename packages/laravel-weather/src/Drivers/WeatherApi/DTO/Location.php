<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Carbon\Carbon;
use Reedware\DomainObjects\Attributes\Timezone;

class Location extends DTO
{
    /**
     * Creates a new location DTO instance.
     */
    public function __construct(
        /** The unique identifer for this location. */
        public readonly ?int $id,

        /** Latitude in decimal degree. */
        public readonly float $lat,

        /** Longitude in decimal degree. */
        public readonly float $lon,

        /** Location name. */
        public readonly string $name,

        /** Region or state of the location, if available. */
        public readonly ?string $region,

        /** Location country. */
        public readonly string $country,

        /** Time zone name. */
        public readonly ?string $tz_id,

        /** Local date and time in unix time. */
        public readonly ?int $localtime_epoch,

        /** Local date and time. */
        #[Timezone('tz_id', true)]
        public readonly ?Carbon $localtime,

        /** The url-safe name for this location */
        public readonly ?string $url
    ) {
        //
    }
}
