<?php

use Reedware\Weather\Drivers\WeatherApi\Exceptions\ErrorResponseException;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Weather;

it('throws an error', function () {
    $this->fakeResponse('search', [
        'q' => '75068'
    ], 'error');

    expect(fn () => Weather::search('75068'))->toThrow(function (ErrorResponseException $e) {
        expect($e->getMessage())->toBe('No matching location found.');
        expect($e->getResponse())->toBeInstanceOf(ErrorResponse::class);
    });
});