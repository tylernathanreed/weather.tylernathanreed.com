<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Reedware\Weather\Drivers\WeatherApi\Attributes\Collect;
use Reedware\Weather\Drivers\WeatherApi\Attributes\From;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Throwable;
use UnitEnum;

abstract class DTO
{
    /**
     * Creates a new DTO instance using the specified array.
     */
    public static function createFromArray(array $array): static
    {
        $class = new ReflectionClass(static::class);

        $properties = $class->getProperties(
            ReflectionProperty::IS_PUBLIC
        );

        $parameters = [];

        foreach ($properties as $property) {
            $type = $property->getType();
            $typeClass = $type?->getName();

            $isRequired = ! $property->hasDefaultValue() && ! $type?->allowsNull();

            /** @var ?From */
            $from = static::getPropertyAttribute($property, From::class);

            $key = $from?->key ?? $property->getName();

            if (! array_key_exists($key, $array) && $isRequired) {
                throw new InvalidArgumentException(sprintf(
                    'Missing required property [%s] for instance of [%s] in array [%s].',
                    $key,
                    static::class,
                    json_encode($array)
                ));
            }

            $value = $array[$key] ?? $property->getDefaultValue();

            // Cast array values into DTOs when type-hinted
            if (static::shouldCastToDTO($property, $value)) {
                $value = $typeClass::createFromArray($value);
            }

            // Cast scalar values into Enums when type-hinted
            if (static::shouldCastToEnum($property, $value)) {
                $value = $typeClass::from($value);
            }

            // Cast array values into DTO collections when type-hinted and attributed
            if (static::shouldCastToDTOCollection($property, $value)) {
                /** @var Collect */
                $collect = static::getPropertyAttribute($property, Collect::class);
                $collectClass = $collect->class;

                $value = array_map(function (array $value) use ($collectClass) {
                    return $collectClass::createFromArray($value);
                }, $value);
            }

            // Cast string values into Carbon instances when type-hinted
            if (static::shouldCastToCarbon($property, $value)) {
                $value = Carbon::parse($value);
            }

            $parameters[$property->getName()] = $value;
        }

        try {
            /** @var ?static */
            $instance = $class->newInstanceArgs($parameters);

            if (is_null($instance)) {
                throw new RuntimeException(sprintf(
                    'Failed to create an instance of [%s] using parameters [%s].',
                    static::class,
                    json_encode($parameters)
                ));
            }

            return $instance;
        } catch (Throwable $e) {
            throw new RuntimeException(sprintf(
                'Failed to create an instance of [%s] due to Error [%s] using parameters [%s].',
                static::class,
                $e->getMessage(),
                json_encode($parameters)
            ), 0, $e);
        }
    }

    /**
     * Returns whether or not the specified property should be casted to a DTO.
     */
    protected static function shouldCastToDTO(ReflectionProperty $property, mixed $value): bool
    {
        $class = $property->getType()?->getName();

        return ! is_null($class)
            && is_a($class, DTO::class, true)
            && is_array($value);
    }

    /**
     * Returns whether or not the specified property should be casted to an Enum.
     */
    protected static function shouldCastToEnum(ReflectionProperty $property, mixed $value): bool
    {
        $class = $property->getType()?->getName();

        return ! is_null($class)
            && is_a($class, UnitEnum::class, true)
            && ! is_null($value);
    }

    /**
     * Returns whether or not the specified property should be casted to a DTO collection.
     */
    protected static function shouldCastToDTOCollection(ReflectionProperty $property, mixed $value): bool
    {
        /** @var ?Collect */
        $collect = static::getPropertyAttribute($property, Collect::class);
        $class = $collect?->class;

        return ! is_null($class)
            && is_a($class, DTO::class, true)
            && is_array($value);
    }

    /**
     * Returns whether or not the specified property should be casted to a Carbon instance.
     */
    protected static function shouldCastToCarbon(ReflectionProperty $property, mixed $value): bool
    {
        $class = $property->getType()?->getName();

        return ! is_null($class)
            && is_a($class, Carbon::class, true)
            && is_string($value);
    }

    /**
     * Returns the specified property attribute.
     */
    protected static function getPropertyAttribute(ReflectionProperty $property, string $class): ?object
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
