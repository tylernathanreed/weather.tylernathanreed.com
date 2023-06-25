<?php

use Reedware\Weather\Manager;

it('registers the manager as a singleton', function () {
    $managerA = $this->make(Manager::class);
    $managerB = $this->make(Manager::class);

    expect($managerA)->toBe($managerB);
});

it('registers "weather" as an alias', function () {
    $managerA = $this->make(Manager::class);
    $managerB = $this->make('weather');

    expect($managerA)->toBe($managerB);
});
