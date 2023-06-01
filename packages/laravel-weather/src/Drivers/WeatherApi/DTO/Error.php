<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

class Error extends DTO
{
    /**
     * Creates a new error DTO instance.
     */
    public function __construct(
        public readonly int $code,
        public readonly string $message
    ) {
        //
    }
}
