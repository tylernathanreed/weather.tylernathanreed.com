<?php

namespace Reedware\DomainObjects\Facades;

use Illuminate\Support\Facades\Facade;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;
use Reedware\DomainObjects\Contracts\Domain as DomainContract;

/**
 * @method static \Reedware\DomainObjects\DomainObject resolve(string $class, array $array)
 * @method static ?\Reedware\DomainObjects\DomainObject tryResolve(string $class, array $array)
 * @method static static addCast(\Reedware\DomainObjects\Contracts\Caster $caster)
 * @method static static replaceCast(string $class, \Reedware\DomainObjects\Contracts\Caster $replacement)
 * @method static static removeCast(string $caster)
 * @method static void setTimezone(DateTime|string|null $tz)
 */
class Domain extends Facade
{
    /**
     * Returns the registered name of the component.
     */
    protected static function getFacadeAccessor()
    {
        return DomainContract::class;
    }

    /**
     * Returns the default casters.
     */
    public static function getDefaultCasters(): array
    {
        return static::getFacadeApplication()->make(DefaultCastersProvider::class)->get();
    }
}
