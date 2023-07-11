<?php

namespace Reedware\DomainObjects\Contracts;

use DateTime;
use Reedware\DomainObjects\Contracts\Caster;
use Reedware\DomainObjects\DomainObject;

interface Domain
{
    /**
     * Resolves the specified array into the given domain object class.
     */
    public function resolve(string $class, array $array): DomainObject;

    /**
     * Tries to create a instance of the specified class using the given array.
     */
    public function tryResolve(string $class, array $array): ?DomainObject;

    /**
     * Adds the specified caster into the caster array.
     */
    public function addCast(Caster $caster);

    /**
     * Replaces the specified caster with another.
     */
    public function replaceCast(string $class, Caster $replacement);

    /**
     * Removes the specified caster.
     */
    public function removeCast(string $caster);

    /**
     * Sets the timezone for casters that use them.
     */
    public function setTimezone(DateTime|string|null $tz): void;
}
