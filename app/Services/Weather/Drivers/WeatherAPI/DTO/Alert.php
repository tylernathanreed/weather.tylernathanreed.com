<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

use Illuminate\Support\Carbon;

class Alert extends DTO
{
    /**
     * Creates a new alert DTO instance.
     */
    public function __construct(
        public readonly string $headline,
        public readonly string $msgType,
        public readonly string $severity,
        public readonly string $urgency,
        public readonly string $areas,
        public readonly string $category,
        public readonly string $certainty,
        public readonly string $event,
        public readonly string $note,
        public readonly Carbon $effective,
        public readonly string $expires,
        public readonly string $desc,
        public readonly string $instruction
    ) {
        //  
    }
}