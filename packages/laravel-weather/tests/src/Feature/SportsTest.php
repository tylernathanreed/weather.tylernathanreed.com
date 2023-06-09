<?php

use Carbon\Carbon;
use Reedware\Weather\Drivers\WeatherApi\DTO\SportEvent;
use Reedware\Weather\Drivers\WeatherApi\Responses\SportsResponse;
use Reedware\Weather\Weather;

it('works', function () {
    $this->fakeResponse('sports', [
        'q' => '75068'
    ], 'sports');

    $expected = new SportsResponse(
        football: [
            new SportEvent(
                'Bohemian Fc',
                'Ireland',
                '',
                'League of Ireland Premier Division',
                Carbon::parse('2023-06-02 19:45', 'UTC'),
                'Bohemians vs Sligo Rovers'
            )
        ],
        cricket: [
            new SportEvent(
                'Lord\'s, London',
                'United Kingdom',
                '',
                'Ireland In England',
                Carbon::parse('2023-06-01 11:00', 'UTC'),
                'England vs Ireland'
            )
        ],
        golf: [
            new SportEvent(
                'Muirfield Village Gc',
                'United States of America',
                '',
                'The Memorial Tournament presented by Workday Round 1',
                Carbon::parse('2023-06-01 17:12', 'UTC'),
                'Ben Griffin, S.H. Kim, David Lipsky'
            )
        ]
    );

    /** @var SportsResponse */
    $actual = Weather::sports('75068');
    $expected->setBaseResponse($actual->getBaseResponse());

    expect($actual)->toEqual($expected);
});