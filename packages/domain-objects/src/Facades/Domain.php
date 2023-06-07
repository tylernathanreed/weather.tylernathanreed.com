<?php

namespace Reedware\DomainObjects\Facades;

use Illuminate\Support\Facades\Facade;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;
use Reedware\DomainObjects\Contracts\Factory;

class Domain extends Facade
{
    /**
     * Returns the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return Factory::class;
    }

    /**
     * Returns the default casters.
     */
    public static function getDefaultCasters(): array
    {
        return static::getFacadeApplication()->make(DefaultCastersProvider::class)->get();
    }
}
