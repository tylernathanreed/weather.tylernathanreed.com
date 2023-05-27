<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

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
        public readonly int $dateEpoch,

        /** @see Day */
        public readonly Day $day,

        /** @see Astro */
        public readonly ?Astro $astro,

        /** @see Tides */
        public readonly ?Tides $tides,

        /** @var array<Hour> */
        public readonly array $hours
    ) {
        //
    }
}

