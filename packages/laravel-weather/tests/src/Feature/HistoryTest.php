<?php

use Carbon\Carbon;
use Reedware\Weather\Drivers\WeatherApi\DTO\Forecast;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, string $dt, Forecast $forecast) {
    $this->fakeResponse('history', [
        'q' => '75068',
        'dt' => $dt
    ], $file);

    $location = $this->newLocation();

    $expected = new HistoryResponse(
        location: $location,
        forecast: $forecast
    );

    /** @var HistoryResponse */
    $actual = Weather::history('75068', Carbon::parse($dt));
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    '3 days ago' => fn() => [
        'history-dt-3-days-ago',
        '2023-05-28',
        new Forecast([
            $this->newForecastDay('2023-05-28', false, false)
        ])
    ]
]);