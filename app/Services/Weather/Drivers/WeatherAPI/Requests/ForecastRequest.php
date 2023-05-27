<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

class ForecastRequest extends Request
{
    /**
     * Creates a new current request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Number of days (1-10) of weather forecast. */
        public int $days = 3,

        /** Get air quality data. */
        public bool $aqi = false,

        /** Get weather alert data data. */
        public bool $alerts = false
    ) {
        parent::__construct($q);
    }

    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'forecast.json';
    }
}
