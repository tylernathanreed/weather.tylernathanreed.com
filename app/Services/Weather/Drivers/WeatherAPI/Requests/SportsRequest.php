<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

class SportsRequest extends Request
{
    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'sports.json';
    }
}
