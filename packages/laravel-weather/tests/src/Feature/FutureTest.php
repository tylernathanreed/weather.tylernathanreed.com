<?php

use Carbon\Carbon;
use Reedware\Weather\Drivers\WeatherApi\DTO\Forecast;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, string $dt, Forecast $forecast) {
    $this->fakeResponse('future', [
        'q' => '75068',
        'dt' => $dt
    ], $file);

    $location = $this->newLocation();

    $expected = new FutureResponse(
        location: $location,
        forecast: $forecast
    );

    /** @var FutureResponse */
    $actual = Weather::future('75068', Carbon::parse($dt));
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    '1 month from now' => fn() => [
        'future-dt-1-month-from-now',
        '2023-07-01',
        new Forecast([
            $this->newFutureForecastDay('2023-07-01')
        ])
    ]
]);