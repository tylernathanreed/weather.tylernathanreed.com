<?php

namespace Reedware\DomainObjects;

use Attribute;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionClass;
use ReflectionParameter;
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
        if ($property->hasDefaultValue() || $property->getType()?->allowsNull()) {
            return $property->getDefaultValue() ?: null;
        }

        if (! is_null($parameter = $this->getConstructorParameter($property))) {
            return $parameter->getDefaultValue();
        }

        return null;
    }

    /**
     * Returns whether or not the specified property is required.
     */
    public function isRequired(ReflectionProperty $property): bool
    {
        if ($property->hasDefaultValue() || $property->getType()?->allowsNull()) {
            return false;
        }

        if (is_null($parameter = $this->getConstructorParameter($property))) {
            return true;
        }

        if ($parameter->isOptional() || $parameter->isDefaultValueAvailable()) {
            return false;
        }

        return true;
    }

    /**
     * Returns the constructor parameter for the specified property.
     */
    public function getConstructorParameter(ReflectionProperty $property): ?ReflectionParameter
    {
        $parameters = array_filter(
            $property->getDeclaringClass()->getConstructor()->getParameters(),
            function (ReflectionParameter $parameter) use ($property) {
                return $parameter->getName() == $property->getName();
            }
        );

        if (empty($parameters)) {
            return null;
        }

        return reset($parameters);
    }

    /**
     * Returns the specified class attribute.
     */
    public function getClassAttribute(ReflectionClass $class, string $attributeClass): ?object
    {
        if (! is_attribute($attributeClass, Attribute::TARGET_CLASS, TARGET_MATCH_INCLUDES)) {
            return null;
        }

        $attributes = $class->getAttributes($attributeClass);

        if (empty($attributes)) {
            return null;
        }

        return head($attributes)->newInstance();
    }

    /**
     * Returns the specified property attribute.
     */
    public function getAttribute(ReflectionProperty $property, string $class): ?object
    {
        if (! is_attribute($class, Attribute::TARGET_PROPERTY, TARGET_MATCH_INCLUDES)) {
            return null;
        }

        $attributes = $property->getAttributes($class);

        if (empty($attributes)) {
            return null;
        }

        return head($attributes)->newInstance();
    }
}
