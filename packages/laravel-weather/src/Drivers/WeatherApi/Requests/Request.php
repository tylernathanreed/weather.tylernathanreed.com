<?php

namespace Reedware\Weather\Drivers\WeatherApi\Requests;

use ReflectionClass;
use ReflectionProperty;
use UnitEnum;

abstract class Request
{
    /**
     * Creates a new request instance.
     */
    public function __construct(
        /**
         * Pass US Zipcode, UK Postcode, Canada Postalcode, IP address,
         * Latitude/Longitude (decimal degree), or city name.
         */
        public string $q
    ) {
        //
    }

    /**
     * Returns the uri for this request.
     */
    abstract public function uri(): string;

    /**
     * Returns the parameters for this request.
     */
    public function parameters(): array
    {
        $parameters = [];

        $properties = (new ReflectionClass($this))->getProperties(
            ReflectionProperty::IS_PUBLIC
        );

        foreach ($properties as $property) {
            $value = $property->getValue($this);

            if ($value instanceof UnitEnum) {
                $value = $value->name;
            }

            $parameters[$property->getName()] = $value;
        }

        return $parameters;
    }
}
