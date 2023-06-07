<?php

namespace Reedware\DomainObjects;

use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Throwable;

class DomainObjectReflector implements Reflector
{
    /**
     * Returns a new instance of the specified class using the given parameters.
     */
    public function newInstance(string $class, array $parameters): DomainObject
    {
        $reflection = new ReflectionClass($class);

        try {
            /** @var ?object */
            $instance = $reflection->newInstanceArgs($parameters);

            return $instance;
        } catch (Throwable $e) {
            throw new RuntimeException(sprintf(
                'Failed to create an instance of [%s] due to %s [%s] using parameters [%s].',
                $class,
                get_class($e),
                $e->getMessage(),
                json_encode($parameters)
            ), 0, $e);
        }
    }

    /**
     * Returns the properties for the specified class.
     *
     * @return array<ReflectionProperty>
     */
    public function getProperties(string $class): array
    {
        $reflection = new ReflectionClass($class);

        $public = $reflection->getProperties(
            ReflectionProperty::IS_PUBLIC
        );

        return array_values(array_filter($public, function (ReflectionProperty $property) {
            return $property->isReadOnly();
        }));
    }

    /**
     * Returns the name of the specified property.
     */
    public function getName(ReflectionProperty $property): string
    {
        return $property->getName();
    }

    /**
     * Returns the class of the type of the specified property.
     */
    public function getTypeClass(ReflectionProperty $property): ?string
    {
        return $property->getType()?->getName();
    }

    /**
     * Returns the default value for the specified property.
     */
    public function getDefaultValue(ReflectionProperty $property): mixed
    {
        return $property->getDefaultValue();
    }

    /**
     * Returns whether or not the specified property is required.
     */
    public function isRequired(ReflectionProperty $property): bool
    {
        $type = $property->getType();

        return ! $property->hasDefaultValue()
            && ! $type?->allowsNull();
    }

    /**
     * Returns the specified property attribute.
     */
    public function getAttribute(ReflectionProperty $property, string $class): ?object
    {
        $attributes = $property->getAttributes($class);

        if (empty($attributes)) {
            return null;
        }

        $attribute = head($attributes)->newInstance();
        
        return is_attribute($attribute)
            ? $attribute
            : null;
    }
}
