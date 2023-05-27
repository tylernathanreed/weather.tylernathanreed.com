<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO\Enums;

enum UkDefraIndex: int
{
    case ONE = 1;
    case TWO = 2;
    case THREE = 3;
    case FOUR = 4;
    case FIVE = 5;
    case SIX = 6;
    case SEVEN = 7;
    case EIGHT = 8;
    case NINE = 9;
    case TEN = 10;

    /**
     * Returns the band for this index.
     */
    public function band(): string
    {
        return match ($this) {
            self::ONE,
            self::TWO,
            self::THREE => 'Low',

            self::FOUR,
            self::FIVE,
            self::SIX => 'Moderate',

            self::SEVEN,
            self::EIGHT,
            self::NINE => 'High',

            self::TEN => 'Very High'
        };
    }

    /**
     * Returns the concentration range of air pollution in micrograms per cubic meter of air (or µg/m^3).
     */
    public function concentrationRange(): string
    {
        return match ($this) {
            self::ONE => '0-11',
            self::TWO => '12-23',
            self::THREE => '24-35',
            self::FOUR => '36-41',
            self::FIVE => '42-47',
            self::SIX => '48-53',
            self::SEVEN => '54-58',
            self::EIGHT => '59-64',
            self::NINE => '65-70',
            self::TEN => '71 or more'
        };
    }
}