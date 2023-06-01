<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

class FutureRequest extends Request
{
    /**
     * Creates a new future request instance.
     */
    public function __construct(
        /** {@inheritDoc} */
        public string $q,

        /** Date between 14 days and 300 days from today in the future in YYYY-MM-DD format. */
        public string $dt
    ) {
        parent::__construct($q);
    }

    /**
     * Returns the uri for this request.
     */
    public function uri(): string
    {
        return 'future.json';
    }
}
