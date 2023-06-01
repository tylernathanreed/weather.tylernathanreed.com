<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Reedware\Weather\Drivers\WeatherApi\DTO\DTO;
use Reedware\Weather\Drivers\WeatherApi\Attributes\From;
use Illuminate\Http\Client\Response as HttpResponse;
use ReflectionClass;
use ReflectionProperty;
use RuntimeException;
use Throwable;

abstract class Response
{
    /**
     * The base response.
     */
    protected HttpResponse $response;

    /**
     * Creates a new response instance from the specified base response.
     */
    public static function createFromBaseResponse(HttpResponse $response): static
    {
        $class = (new ReflectionClass(static::class));

        $properties = $class->getProperties(
            ReflectionProperty::IS_PUBLIC
        );

        $parameters = [];

        foreach ($properties as $property) {
            $attributes = $property->getAttributes(From::class);

            /** @var ?From */
            $from = ! empty($attributes)
                ? head($attributes)->newInstance()
                : null;

            $key = $from?->key ?? $property->getName();

            $value = $response->json($key);

            $type = $property->getType()?->getName();

            if (is_a($type, DTO::class, true)) {
                $value = $type::createFromArray($value);
            }

            $parameters[$property->getName()] = $value;
        }

        /** @var ?static */
        $instance = $class->newInstanceArgs($parameters);

        if (is_null($instance)){
            throw new RuntimeException(sprintf(
                'Failed to create response [%s] from body [%s].',
                static::class,
                json_encode($response->json())
            ));
        }

        $instance->setBaseResponse($response);

        return $instance;
    }

    /**
     * Tries to create a new response instnace from the specified base response.
     */
    public static function tryFromBaseResponse(HttpResponse $response): ?static
    {
        try {
            return static::createFromBaseResponse($response);
        } catch (Throwable $e) {
            return null;
        }
    }

    /**
     * Sets the base response.
     */
    protected function setBaseResponse(HttpResponse $response): void
    {
        $this->response = $response;
    }

    /**
     * Returns the base response.
     */
    public function getBaseResponse(): HttpResponse
    {
        return $this->response;
    }
}