<?php

namespace App\Services\Weather\Drivers\WeatherAPI\DTO;

use App\Services\Weather\Drivers\WeatherAPI\Attributes\From;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
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

            $attributes = $property->getAttributes(From::class);

            /** @var ?From */
            $from = ! empty($attributes)
                ? head($attributes)->newInstance()
                : null;

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

            if (! is_null($typeClass) && is_a($typeClass, DTO::class, true) && is_array($value)) {
                $value = $typeClass::createFromArray($value);
            }

            if (! is_null($typeClass) && is_a($typeClass, UnitEnum::class, true) && ! is_null($value)) {
                $value = $typeClass::from($value);
            }

            $parameters[$property->getName()] = $value;
        }

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
    }
}
