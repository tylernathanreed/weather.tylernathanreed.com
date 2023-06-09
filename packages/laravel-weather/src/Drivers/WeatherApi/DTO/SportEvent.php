<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Carbon\Carbon;

class SportEvent extends DTO
{
    /**
     * Creates a new sport event DTO instance.
     */
    public function __construct(
        /** Name of stadium. */
        public readonly string $stadium,

        /** Country. */
        public readonly string $country,

        /** Region. */
        public readonly string $region,

        /** Tournament name. */
        public readonly string $tournament,

        /** Start local date and time. */
        public readonly Carbon $start,

        /** Match name. */
        public readonly string $match

    ) {
        //
    }
}
