<?php

use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\UsEpaIndex;

it('returns a label', function (UsEpaIndex $enum, string $expected) {
    expect($enum->label())->toBe($expected);
})->with([
    [UsEpaIndex::GOOD, 'Good'],
    [UsEpaIndex::MODERATE, 'Moderate'],
    [UsEpaIndex::UNHEALTHY_FOR_SENSITIVE_GROUP, 'Unhealthy for sensitive group'],
    [UsEpaIndex::UNHEALTHY, 'Unhealthy'],
    [UsEpaIndex::VERY_UNHEALTHY, 'Very Unhealthy'],
    [UsEpaIndex::HAZARDOUS, 'Hazardous'],
]);
