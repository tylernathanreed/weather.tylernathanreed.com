<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\Attributes\Collect;
use Reedware\Weather\Drivers\WeatherApi\Attributes\From;
use Illuminate\Support\Carbon;

class ForecastDay extends DTO
{
    /**
     * Creates a new forecast day DTO instance.
     */
    public function __construct(
        /** Forecast date. */
        public readonly Carbon $date,

        /** Forecast date as unix time.. */
        public readonly int $date_epoch,

        /** @see Day */
        public readonly Day $day,

        /** @see Astro */
        public readonly ?Astro $astro,

        /** @see Tides */
        public readonly ?Tides $tides,

        /** @var array<Hour> */
        #[Collect(Hour::class)]
        #[From('hour')]
        public readonly array $hours
    ) {
        //
    }
}

