<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

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
