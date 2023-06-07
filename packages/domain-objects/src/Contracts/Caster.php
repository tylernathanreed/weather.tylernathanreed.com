<?php

namespace Reedware\DomainObjects\Contracts;

use ReflectionProperty;

interface Caster
{
    /**
     * Returns whether or not this cast applies to the specified property and value.
     */
    public function appliesTo(ReflectionProperty $property, mixed $value): bool;

    /**
     * Returns the casted value for the specified property.
     */
    public function get(
        ObjectResolver $resolver,
        ReflectionProperty $property,
        mixed $value,
        array $array
    ): mixed;
}
