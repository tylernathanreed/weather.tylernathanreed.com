<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\Error;

class ErrorResponse extends Response
{
    /**
     * Creates a new response instance.
     */
    public function __construct(
        public readonly Error $error
    ) {
        //
    }
}
