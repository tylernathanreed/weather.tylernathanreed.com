<?php

use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\UkDefraIndex;

it('returns a band', function (UkDefraIndex $enum, string $expected) {
    expect($enum->band())->toBe($expected);
})->with([
    [UkDefraIndex::ONE, 'Low'],
    [UkDefraIndex::TWO, 'Low'],
    [UkDefraIndex::THREE, 'Low'],
    [UkDefraIndex::FOUR, 'Moderate'],
    [UkDefraIndex::FIVE, 'Moderate'],
    [UkDefraIndex::SIX, 'Moderate'],
    [UkDefraIndex::SEVEN, 'High'],
    [UkDefraIndex::EIGHT, 'High'],
    [UkDefraIndex::NINE, 'High'],
    [UkDefraIndex::TEN, 'Very High'],
]);

it('returns a concenration range', function (UkDefraIndex $enum, string $expected) {
    expect($enum->concentrationRange())->toBe($expected);
})->with([
    [UkDefraIndex::ONE, '0-11'],
    [UkDefraIndex::TWO, '12-23'],
    [UkDefraIndex::THREE, '24-35'],
    [UkDefraIndex::FOUR, '36-41'],
    [UkDefraIndex::FIVE, '42-47'],
    [UkDefraIndex::SIX, '48-53'],
    [UkDefraIndex::SEVEN, '54-58'],
    [UkDefraIndex::EIGHT, '59-64'],
    [UkDefraIndex::NINE, '65-70'],
    [UkDefraIndex::TEN, '71 or more'],
]);
