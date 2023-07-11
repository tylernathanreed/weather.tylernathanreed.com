<?php

namespace Reedware\DomainObjects;

use Reedware\DomainObjects\Casts\CarbonCaster;
use Reedware\DomainObjects\Casts\DomainObjectArrayCaster;
use Reedware\DomainObjects\Casts\DomainObjectCaster;
use Reedware\DomainObjects\Casts\EnumCaster;
use Reedware\DomainObjects\Casts\NullCaster;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;

class DefaultCasters implements DefaultCastersProvider
{
    /**
     * The default casters.
     */
    protected array $casters;

    /**
     * Create a new default casters instance.
     */
    public function __construct()
    {
        $this->casters = [
            NullCaster::class,
            DomainObjectCaster::class,
            EnumCaster::class,
            CarbonCaster::class,
            DomainObjectArrayCaster::class
        ];
    }

    /**
     * Returns the default caster classes as an array.
     */
    public function get(): array
    {
        return $this->casters;
    }
}
