<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

use App\Services\Weather\Drivers\WeatherAPI\Requests\Enums\YesNo;

class CurrentRequest extends Request
{
    /**
     * Creates a new current request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Get air quality data. */
        public YesNo $aqi = YesNo::no
    ) {
        parent::__construct($q);
    }

    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'current.json';
    }
}
