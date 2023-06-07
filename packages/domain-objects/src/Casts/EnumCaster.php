<?php

namespace Reedware\DomainObjects\Casts;

use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionProperty;
use UnitEnum;

class EnumCaster extends Caster
{
    /**
     * Creates a new caster instance.
     */
    public function __construct(
        protected Reflector $reflector
    ) {
        //
    }

    /**
     * Returns whether or not this cast applies to the specified property and value.
     */
    public function appliesTo(ReflectionProperty $property, mixed $value): bool
    {
        $class = $this->reflector->getTypeClass($property);

        return ! is_null($class)
            && is_a($class, UnitEnum::class, true)
            && (
                is_string($value)
                || is_int($value)
            );
    }

    /**
     * Returns the casted value for the specified property.
     */
    public function get(
        ObjectResolver $resolver,
        ReflectionProperty $property,
        mixed $value,
        array $array
    ): mixed {
        $class = $this->reflector->getTypeClass($property);

        return $class::from($value);
    }
}
