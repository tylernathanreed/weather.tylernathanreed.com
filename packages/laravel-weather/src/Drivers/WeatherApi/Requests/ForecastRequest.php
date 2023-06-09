<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;

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
        public YesNo $aqi = YesNo::no,

        /** Get weather alert data data. */
        public YesNo $alerts = YesNo::no
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
