<?php

namespace Reedware\DomainObjects\Contracts;

use ReflectionProperty;

interface KeyResolver
{
    /**
     * Returns the array key for the specified property.
     */
    public function resolve(ReflectionProperty $property): string;
}
