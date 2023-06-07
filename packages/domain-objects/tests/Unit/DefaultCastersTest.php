<?php

use Reedware\DomainObjects\Casts\CarbonCaster;
use Reedware\DomainObjects\Casts\DomainObjectArrayCaster;
use Reedware\DomainObjects\Casts\DomainObjectCaster;
use Reedware\DomainObjects\Casts\EnumCaster;
use Reedware\DomainObjects\DefaultCasters;

it('returns the default casters', function () {
    expect((new DefaultCasters)->get())->toBe([
        DomainObjectCaster::class,
        EnumCaster::class,
        CarbonCaster::class,
        DomainObjectArrayCaster::class
    ]);
});
