<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

class SearchResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        #[From(null)]
        #[ArrayOf(Location::class)]
        public readonly array $locations
    ) {
        //
    }
}
