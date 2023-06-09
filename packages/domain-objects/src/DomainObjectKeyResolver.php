<?php

namespace Reedware\DomainObjects;

use Reedware\DomainObjects\Attributes\From;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionProperty;

class DomainObjectKeyResolver implements KeyResolver
{
    /**
     * Creates a new domain object key resolver instance.
     */
    public function __construct(
        protected Reflector $reflector
    ) {
        //
    }

    /**
     * Returns the array key for the specified property.
     */
    public function resolve(ReflectionProperty $property): ?string
    {
        /** @var ?From */
        $from = $this->reflector->getAttribute($property, From::class);

        return ! is_null($from)
            ? $from->key
            : $property->getName();
    }
}
