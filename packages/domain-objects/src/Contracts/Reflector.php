<?php

namespace Reedware\DomainObjects\Contracts;

use Reedware\DomainObjects\DomainObject;
use ReflectionProperty;

interface Reflector
{
    /**
     * Returns a new instance of the specified class using the given parameters.
     */
    public function newInstance(string $class, array $parameters): DomainObject;

    /**
     * Returns the properties for the specified class.
     *
     * @return array<ReflectionProperty>
     */
    public function getProperties(string $class): array;

    /**
     * Returns the name of the specified property.
     */
    public function getName(ReflectionProperty $property): string;

    /**
     * Returns the class of the type of the specified property.
     */
    public function getTypeClass(ReflectionProperty $property): ?string;

    /**
     * Returns the default value for the specified property.
     */
    public function getDefaultValue(ReflectionProperty $property): mixed;

    /**
     * Returns whether or not the specified property is required.
     */
    public function isRequired(ReflectionProperty $property): bool;

    /**
     * Returns the specified property attribute.
     */
    public function getAttribute(ReflectionProperty $property, string $class): ?object;
}
