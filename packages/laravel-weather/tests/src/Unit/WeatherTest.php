<?php

use Reedware\Weather\Weather;
use Reedware\Weather\Manager;

it('is a facade to the weather service', function () {
    expect(Weather::getFacadeAccessor())->toBe('weather');

    $manager = Weather::getFacadeRoot();

    expect($manager)->toBeInstanceOf(Manager::class);
});
