<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\DomainObjects\Attributes\From;
use Reedware\Weather\Drivers\WeatherApi\DTO\IpLocation;

class IpLookupResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        #[From(null)]
        public readonly IpLocation $location
    ) {
        //
    }
}
