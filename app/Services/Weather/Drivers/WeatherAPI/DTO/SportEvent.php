<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

use Illuminate\Support\Carbon;

class SportEvent extends DTO
{
    /**
     * Creates a new sport event DTO instance.
     */
    public function __construct(
        /** Name of stadium. */
        public readonly string $stadium,

        /** Country. */
        public readonly int $country,

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
