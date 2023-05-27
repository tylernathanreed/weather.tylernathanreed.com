<?php

namespace App\Services\Weather\Drivers\WeatherAPI\Responses;

use App\Services\Weather\Drivers\WeatherAPI\DTO\Error;

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
