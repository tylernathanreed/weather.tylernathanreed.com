<?php

namespace Reedware\DomainObjects\Casts;

use Carbon\Carbon;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionProperty;

class CarbonCaster extends Caster
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
            && is_a($class, Carbon::class, true)
            && is_string($value);
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

        return $class::parse($value);
    }
}
