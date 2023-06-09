<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\Weather\Drivers\WeatherApi\DTO\SportEvent;

class SportsResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        #[ArrayOf(SportEvent::class)]
        public readonly array $football,

        #[ArrayOf(SportEvent::class)]
        public readonly array $cricket,

        #[ArrayOf(SportEvent::class)]
        public readonly array $golf
    ) {
        //
    }
}
