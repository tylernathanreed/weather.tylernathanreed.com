<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

class Condition extends DTO
{
    /**
     * Creates a new condition DTO instance.
     */
    public function __construct(
        /** Weather condition text. */
        public readonly string $text,

        /** Weather condition icon. */
        public readonly string $icon,

        /** Weather condition code. */
        public readonly int $code,
    ) {
        //
    }
}
