<?php

use Carbon\Carbon;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;
use Reedware\Weather\Weather;

it('works', function () {
    $this->fakeResponse('timezone', [
        'q' => '75068'
    ], 'timezone-central');

    $expected = new TimeZoneResponse(
        location: new Location(
            id: null,
            name: 'Little Elm',
            region: 'Texas',
            country: 'USA',
            lat: 33.22,
            lon: -96.91,
            localtime: Carbon::parse('2023-06-01 11:46', 'UTC'),
            localtime_epoch: 1685637979,
            tz_id: 'America/Chicago',
            url: null
        )
    );

    /** @var TimeZoneResponse */
    $actual = Weather::timezone('75068');
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
});