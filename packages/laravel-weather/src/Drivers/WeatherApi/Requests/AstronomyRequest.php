<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

class AstronomyRequest extends Request
{
    /**
     * Creates a new astronomy request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Date in YYYY-MM-DD format. */
        public string $dt
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
