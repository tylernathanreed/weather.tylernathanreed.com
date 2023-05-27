<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Requests;

use Illuminate\Support\Carbon;

class AstronomyRequest extends Request
{
    /**
     * Creates a new astronomy request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Date. */
        public Carbon $dt
    ) {
        parent::__construct($q);
    }

    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'astronomy.json';
    }
}
