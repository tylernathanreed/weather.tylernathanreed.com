<?php

namespace Reedware\DomainObjects;

use Closure;
use Illuminate\Support\Arr;
use InvalidArgumentException;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\DomainObject;
use ReflectionProperty;

class DomainObjectResolver implements ObjectResolver
{
    /**
     * Creates a new resolver instance.
     */
    public function __construct(
        protected Reflector $reflector,
        protected KeyResolver $keys,
        protected CastResolver $casts
    ) {
        //
    }

    /**
     * Resolves an instance of the specified class using the given array.
     */
    public function resolve(string $class, array $array): DomainObject
    {
        $properties = $this->reflector->getProperties($class);

        foreach ($properties as $property) {
            $key = $this->reflector->getName($property);
            $value = $this->getPropertyValue($class, $property, $array);

            $parameters[$key] = $value;
        }

        $parameters = array_map(function ($value) use ($parameters) {
            return $value instanceof Closure
                ? ($value)($parameters)
                : $value;
        }, $parameters);

        return $this->reflector->newInstance($class, $parameters ?? []);
    }

    /**
     * Returns the value for the specified property using the given array.
     */
    protected function getPropertyValue(string $class, ReflectionProperty $property, array $array): mixed
    {
        $key = $this->keys->resolve($property);

        if ($this->isMissingProperty($key, $array, $property)) {
            throw new InvalidArgumentException(sprintf(
                'Missing required property [%s] for instance of [%s] in array [%s].',
                $key,
                $class,
                json_encode($array)
            ));
        }

        $value = Arr::get($array, $key) ?? $this->reflector->getDefaultValue($property);

        return $this->casts->cast($this, $property, $value, $array);
    }

    /**
     * Returns whether or not the specified property is missing within the given array.
     */
    protected function isMissingProperty(?string $key, array $array, ReflectionProperty $property): bool
    {
        return ! is_null($key)
            && ! Arr::has($array, $key)
            && $this->reflector->isRequired($property);
    }

    /**
     * Returns the reflector implementation.
     */
    public function getReflector(): Reflector
    {
        return $this->reflector;
    }

    /**
     * Returns the key resolver implementation.
     */
    public function getKeyResolver(): KeyResolver
    {
        return $this->keys;
    }

    /**
     * Returns the cast resolver implementation.
     */
    public function getCastResolver(): CastResolver
    {
        return $this->casts;
    }
}
