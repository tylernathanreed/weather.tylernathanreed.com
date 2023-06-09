<?php

use Reedware\Weather\Drivers\WeatherApi\DTO\Current;
use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, bool $aqi, Current $current) {
    $this->fakeResponse('current', [
        'q' => '75068',
        'aqi' => YesNo::from($aqi)->name
    ], $file);

    $location = $this->newLocation();

    $expected = new CurrentResponse(
        location: $location,
        current: $current
    );

    /** @var CurrentResponse */
    $actual = Weather::current('75068', $aqi);
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    'w/o aqi' => fn() => ['current-aqi-no', false, $this->newCurrent(false)],
    'w/ aqi' => fn() => ['current-aqi-yes', true, $this->newCurrent(true)]
]);