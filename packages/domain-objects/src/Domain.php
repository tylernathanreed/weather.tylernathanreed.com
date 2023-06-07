<?php

namespace Reedware\DomainObjects;

use Reedware\DomainObjects\Contracts\Caster;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\DomainObject;
use Throwable;

class Domain
{
    /**
     * Creates a new domain instance.
     */
    public function __construct(
        protected CastResolver $casts,
        protected ObjectResolver $resolver
    ) {
        //
    }

    /**
     * Resolves the specified array into the given domain object class.
     */
    public function resolve(string $class, array $array): DomainObject
    {
        return $this->resolver->resolve($class, $array);
    }

    /**
     * Tries to create a instance of the specified class using the given array.
     */
    public function tryResolve(string $class, array $array): ?DomainObject
    {
        try {
            return $this->resolve($class, $array);
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Adds the specified caster into the caster array.
     */
    public function addCast(Caster $caster): static
    {
        $this->casts->add($caster);

        return $this;
    }

    /**
     * Replaces the specified caster with another.
     */
    public function replaceCast(string $class, Caster $replacement): static
    {
        $this->casts->replace($class, $replacement);

        return $this;
    }

    /**
     * Removes the specified caster.
     */
    public function removeCast(string $caster): static
    {
        $this->casts->remove($caster);

        return $this;
    }

    /**
     * Returns the cast resolver implementation.
     */
    public function getCastResolver(): CastResolver
    {
        return $this->casts;
    }

    /**
     * Returns the object resolver implementation.
     */
    public function getObjectResolver(): ObjectResolver
    {
        return $this->resolver;
    }
}
