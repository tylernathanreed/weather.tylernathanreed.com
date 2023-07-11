<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

class IpLookupRequest extends Request
{
    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'ip.json';
    }
}
