<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO\Enums;

enum UsEpaIndex: int
{
    case GOOD = 1;
    case MODERATE = 2;
    case UNHEALTHY_FOR_SENSITIVE_GROUP = 3;
    case UNHEALTHY = 4;
    case VERY_UNHEALTHY = 5;
    case HAZARDOUS = 6;

    /**
     * Returns the label for this index.
     */
    public function label(): string
    {
        return match ($this) {
            self::GOOD => 'Good',
            self::MODERATE => 'Moderate',
            self::UNHEALTHY_FOR_SENSITIVE_GROUP => 'Unhealthy for sensitive group',
            self::UNHEALTHY => 'Unhealthy',
            self::VERY_UNHEALTHY => 'Very Unhealthy',
            self::HAZARDOUS => 'Hazardous'
        };
    }
}