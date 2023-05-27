<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

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
