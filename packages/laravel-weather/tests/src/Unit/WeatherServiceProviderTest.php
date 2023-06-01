<?php

use Reedware\Weather\Manager;

it('registers the manager as a singleton', function () {
    $managerA = $this->container->make(Manager::class);
    $managerB = $this->container->make(Manager::class);

    expect($managerA)->toBe($managerB);
});

it('registers "weather" as an alias', function () {
    $managerA = $this->container->make(Manager::class);
    $managerB = $this->container->make('weather');

    expect($managerA)->toBe($managerB);
});
