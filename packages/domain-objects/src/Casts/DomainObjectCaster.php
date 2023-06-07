<?php

namespace Reedware\DomainObjects\Casts;

use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObject;
use ReflectionProperty;

class DomainObjectCaster extends Caster
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
            && is_a($class, DomainObject::class, true)
            && is_array($value);
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

        return $resolver->resolve($class, $value);
    }
}
