<?php

namespace Reedware\DomainObjects\Casts;

use Reedware\DomainObjects\Attributes\NullValues;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionProperty;

class NullCaster extends Caster
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
        return ! is_null(
            $this->reflector->getAttribute($property, NullValues::class)
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
        /** @var NullValues */
        $attribute = $this->reflector->getAttribute($property, NullValues::class);

        foreach ($attribute->values as $nullValue) {
            if ($nullValue === $value) {
                return null;
            }

            if (! $attribute->strict && $nullValue == $value) {
                return null;
            }
        }

        return $value;
    }
}
