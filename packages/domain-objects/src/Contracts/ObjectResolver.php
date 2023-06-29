<?php

namespace Reedware\DomainObjects\Contracts;

use Reedware\DomainObjects\DomainObject;

interface ObjectResolver
{
    /**
     * Resolves an instance of the specified class using the given array.
     */
    public function resolve(string $class, array $array): DomainObject;

    /**
     * Returns the cast resolver implementation.
     */
    public function getCastResolver(): CastResolver;
}
