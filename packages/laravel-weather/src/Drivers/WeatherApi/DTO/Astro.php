<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\MoonPhase;

class Astro extends DTO
{
    /**
     * Creates a new astro DTO instance.
     */
    public function __construct(
        /** Sunrise time. */
        public readonly string $sunrise,

        /** Sunset time. */
        public readonly string $sunset,

        /** Moonrise time. */
        public readonly string $moonrise,

        /** Moonset time. */
        public readonly string $moonset,

        /** Moon phases. */
        public readonly MoonPhase $moon_phase,

        /** Moon illumination as %. */
        public readonly float $moon_illumination,

        /** Whether or not the moon is currently up. */
        public readonly ?bool $is_moon_up,

        /** Whether or not the sun is currently up. */
        public readonly ?bool $is_sun_up,
    ) {
        //
    }
}

