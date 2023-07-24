<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO\Enums;

enum UsEpaIndex: int
{
    case GOOD = 1;
    case MODERATE = 2;
    case UNHEALTHY_FOR_SENSITIVE_GROUP = 3;
    case UNHEALTHY = 4;
    case VERY_UNHEALTHY = 5;
    case HAZARDOUS = 6;

    /**
     * Returns the index for the specified concentration.
     */
    public static function fromConcentration(float $concentration): static
    {
        foreach (static::cases() as $case) {
            [$min, $max] = $case->concentrationRange();

            if ($concentration <= $min) {
                return $case;
            }
        }

        return $case;
    }

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

    /**
     * Returns the concentration range of air pollution in micrograms per cubic meter of air (or µg/m^3).
     */
    public function concentrationRange(): array
    {
        return match ($this) {
            self::GOOD => [0, 50],
            self::MODERATE => [51, 100],
            self::UNHEALTHY_FOR_SENSITIVE_GROUP => [101, 150],
            self::UNHEALTHY => [151, 200],
            self::VERY_UNHEALTHY => [151, 200],
            self::HAZARDOUS => [301, 500]
        };
    }
}
