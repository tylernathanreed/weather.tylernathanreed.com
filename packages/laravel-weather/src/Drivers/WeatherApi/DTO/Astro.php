<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Carbon\Carbon;
use Reedware\DomainObjects\Attributes\NullValues;
use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\MoonPhase;

class Astro extends DTO
{
    /**
     * Creates a new astro DTO instance.
     */
    public function __construct(
        /** Sunrise time (in HH:MM AM/PM format). */
        public readonly Carbon $sunrise,

        /** Sunset time (in HH:MM AM/PM format). */
        public readonly Carbon $sunset,

        /** Moonrise time (in HH:MM AM/PM format). */
        #[NullValues(['No moonrise'])]
        public readonly ?Carbon $moonrise,

        /** Moonset time (in HH:MM AM/PM format). */
        #[NullValues(['No moonset'])]
        public readonly ?Carbon $moonset,

        /** Moon phases. */
        public readonly MoonPhase $moon_phase,

        /** Moon illumination as percentage. */
        public readonly int $moon_illumination,

        /** Whether or not the moon is currently up. */
        public readonly ?bool $is_moon_up,

        /** Whether or not the sun is currently up. */
        public readonly ?bool $is_sun_up,
    ) {
        //
    }
}

