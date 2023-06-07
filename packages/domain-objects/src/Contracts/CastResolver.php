<?php

namespace Reedware\DomainObjects\Contracts;

use ReflectionProperty;

interface CastResolver
{
    /**
     * Casts the specified domain object property.
     */
    public function cast(
        ObjectResolver $resolver,
        ReflectionProperty $property,
        mixed $value,
        array $array
    ): mixed;

    /**
     * Adds the specified caster into the caster array.
     */
    public function add(Caster $caster): static;

    /**
     * Replaces the specified caster with another.
     */
    public function replace(string $class, Caster $replacement): static;

    /**
     * Removes the specified caster.
     */
    public function remove(string $class): static;

    /**
     * Returns the casters.
     */
    public function getCasters(): array;
}
