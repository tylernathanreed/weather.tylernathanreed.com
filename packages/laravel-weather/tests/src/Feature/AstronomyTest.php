<?php

use Carbon\Carbon;
use Reedware\Weather\Drivers\WeatherApi\DTO\Astro;
use Reedware\Weather\Drivers\WeatherApi\DTO\Enums\MoonPhase;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Weather;

it('works', function (string $file, string $dt, Astro $astro) {
    $this->fakeResponse('astronomy', [
        'q' => '75068',
        'dt' => $dt
    ], $file);

    $location = $this->newLocation();

    $expected = new AstronomyResponse(
        location: $location,
        astronomy: $astro
    );

    /** @var AstronomyResponse */
    $actual = Weather::astronomy('75068', Carbon::parse($dt));
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
})->with([
    'today' => ['astro-today', '2023-06-01', new Astro(
        sunrise: '06:19 AM',
        sunset: '08:32 PM',
        moonrise: '06:13 PM',
        moonset: '04:24 AM',
        moon_phase: MoonPhase::WAXING_GIBBOUS,
        moon_illumination: 88,
        is_moon_up: true,
        is_sun_up: true
    )],
    'tomorrow' => ['astro-tomorrow', '2023-06-02', new Astro(
        sunrise: '06:19 AM',
        sunset: '08:32 PM',
        moonrise: '07:22 PM',
        moonset: '04:57 AM',
        moon_phase: MoonPhase::WAXING_GIBBOUS,
        moon_illumination: 94,
        is_moon_up: true,
        is_sun_up: true
    )],
    'tomorrow' => ['astro-yesterday', '2023-05-31', new Astro(
        sunrise: '06:20 AM',
        sunset: '08:30 PM',
        moonrise: '04:08 PM',
        moonset: '03:29 AM',
        moon_phase: MoonPhase::WAXING_GIBBOUS,
        moon_illumination: 72,
        is_moon_up: true,
        is_sun_up: true
    )]
]);