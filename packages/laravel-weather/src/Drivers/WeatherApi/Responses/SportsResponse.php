<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\SportEvent;

class SportsResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        /** @var array<SportEvent> */
        public readonly array $football,

        /** @var array<SportEvent> */
        public readonly array $cricket,

        /** @var array<SportEvent> */
        public readonly array $golf
    ) {
        //
    }
}
