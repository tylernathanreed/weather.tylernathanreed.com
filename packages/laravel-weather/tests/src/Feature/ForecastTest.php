<?php

use Reedware\Weather\Drivers\WeatherApi\DTO\Forecast;
use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, int $days, bool $aqi, Forecast $forecast, ?array $alerts = null) {
    $this->fakeResponse('forecast', [
        'q' => '75068',
        'days' => $days,
        'aqi' => YesNo::from($aqi)->name,
        'alerts' => YesNo::from(! empty($alerts))->name
    ], $file);

    $location = $this->newLocation();
    $current = $this->newCurrent($aqi);

    $expected = new ForecastResponse(
        location: $location,
        current: $current,
        forecast: $forecast,
        alerts: $alerts
    );

    /** @var ForecastResponse */
    $actual = Weather::forecast('75068', $days, $aqi, ! empty($alerts));
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    '1 day w/o aqi w/o alerts' => fn() => [
        'forecast-days-1-aqi-no-alerts-no',
        1,
        false,
        new Forecast([
            $this->newForecastDay('2023-06-01', false)
        ])
    ],
    '1 day w/o aqi w/ alerts' => fn() => [
        'forecast-days-1-aqi-no-alerts-yes',
        1,
        false,
        new Forecast([
            $this->newForecastDay('2023-06-01', false)
        ]),
        [ $this->newAlert() ]
    ],
    '1 day w/ aqi w/o alerts' => fn() => [
        'forecast-days-1-aqi-yes-alerts-no',
        1,
        true,
        new Forecast([
            $this->newForecastDay('2023-06-01', true)
        ])
    ],
    '1 day w/ aqi w/ alerts' => fn() => [
        'forecast-days-1-aqi-yes-alerts-yes',
        1,
        true,
        new Forecast([
            $this->newForecastDay('2023-06-01', true)
        ]),
        [ $this->newAlert() ]
    ],
]);