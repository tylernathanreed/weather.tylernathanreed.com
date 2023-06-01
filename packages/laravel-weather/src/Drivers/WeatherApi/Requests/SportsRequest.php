<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

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
