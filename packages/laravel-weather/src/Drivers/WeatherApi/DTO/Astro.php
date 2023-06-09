<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\MoonPhase;

class Astro extends DTO
{
    /**
     * Creates a new astro DTO instance.
     */
    public function __construct(
        /** Sunrise time (in HH:MM AM/PM format). */
        public readonly string $sunrise,

        /** Sunset time (in HH:MM AM/PM format). */
        public readonly string $sunset,

        /** Moonrise time (in HH:MM AM/PM format). */
        public readonly string $moonrise,

        /** Moonset time (in HH:MM AM/PM format). */
        public readonly string $moonset,

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

