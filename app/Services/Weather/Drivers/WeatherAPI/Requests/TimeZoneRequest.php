<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

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
