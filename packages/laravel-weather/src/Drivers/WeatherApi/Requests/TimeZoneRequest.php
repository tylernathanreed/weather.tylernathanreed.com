<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

class TimeZoneRequest extends Request
{
    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'timezone.json';
    }
}
