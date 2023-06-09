<?php

use Reedware\Weather\Drivers\WeatherApi\DTO\Location;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, string $q, array $locations) {
    $this->fakeResponse('search', [
        'q' => $q
    ], $file);

    $expected = new SearchResponse(
        locations: $locations
    );

    /** @var SearchResponse */
    $actual = Weather::search($q);
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    '0 results' => ['search-0-results', 'qwerty', []],
    '1 result' => ['search-1-result', '75068', [
        new Location(
            id: 4050689,
            name: 'Little Elm',
            region: 'Texas',
            country: 'United States of America',
            lat: 33.22,
            lon: -96.91,
            url: 'little-elm-texas-united-states-of-america',
            localtime: null,
            localtime_epoch: null,
            tz_id: null
        )
    ]],
    '2 results' => ['search-2-results', 'Dallas', [
        new Location(
            id: 2654932,
            name: 'Dallas',
            region: 'Texas',
            country: 'United States of America',
            lat: 32.78,
            lon: -96.8,
            url: 'dallas-texas-united-states-of-america',
            localtime: null,
            localtime_epoch: null,
            tz_id: null
        ),
        new Location(
            id: 2633429,
            name: 'Dallas',
            region: 'Oregon',
            country: 'United States of America',
            lat: 44.92,
            lon: -123.32,
            url: 'dallas-oregon-united-states-of-america',
            localtime: null,
            localtime_epoch: null,
            tz_id: null
        )
    ]]
]);