<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO\Enums;

enum MoonPhase: string
{
    case NEW_MOON = 'New Moon';
    case WAXING_CRESCENT = 'Waxing Crescent';
    case FIRST_QUARTER = 'First Quarter';
    case WAXING_GIBBOUS = 'Waxing Gibbous';
    case FULL_MOON = 'Full Moon';
    case WANING_GIBBOUS = 'Waning Gibbous';
    case LAST_QUARTER = 'Last Quarter';
    case WANING_CRESCENT = 'Waning Crescent';
}
