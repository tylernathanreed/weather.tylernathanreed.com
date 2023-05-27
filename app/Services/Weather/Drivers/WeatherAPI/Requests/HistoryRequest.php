<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

use Illuminate\Support\Carbon;

class HistoryRequest extends Request
{
    /**
     * Creates a new history request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Date on or after 1st Jan, 2010. */
        public Carbon $dt
    ) {
        parent::__construct($q);
    }

    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'history.json';
    }
}
