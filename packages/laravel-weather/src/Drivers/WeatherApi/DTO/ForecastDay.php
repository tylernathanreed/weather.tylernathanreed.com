<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Carbon\Carbon;
use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\Attributes\From;

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
        #[ArrayOf(Hour::class)]
        #[From('hour')]
        public readonly array $hours
    ) {
        //
    }
}

