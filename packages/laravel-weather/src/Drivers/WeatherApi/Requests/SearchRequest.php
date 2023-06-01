<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

class SearchRequest extends Request
{
    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'search.json';
    }
}
