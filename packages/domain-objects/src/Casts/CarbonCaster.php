<?php

namespace Reedware\DomainObjects\Casts;

use Carbon\Carbon;
use Carbon\CarbonTimeZone;
use DateTimeZone;
use Reedware\DomainObjects\Attributes\Timezone;
use Reedware\DomainObjects\Contracts\CastsWithTimezone;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use ReflectionProperty;

class CarbonCaster extends Caster implements CastsWithTimezone
{
    /**
     * Creates a new caster instance.
     */
    public function __construct(
        protected Reflector $reflector,
        protected ?CarbonTimeZone $tz = null
    ) {
        //
    }

    /**
     * Returns the timezone that timestamps are parsed in.
     */
    public function getTimezone(): ?CarbonTimeZone
    {
        return $this->tz;
    }

    /**
     * Sets the timezone to parse timestamps in.
     */
    public function setTimezone(DateTimeZone|string|null $tz): void
    {
        $this->tz = $tz ? new CarbonTimeZone($tz) : null;
    }

    /**
     * Returns whether or not this cast applies to the specified property and value.
     */
    public function appliesTo(ReflectionProperty $property, mixed $value): bool
    {
        $class = $this->reflector->getTypeClass($property);

        return ! is_null($class)
            && is_a($class, Carbon::class, true)
            && is_string($value);
    }

    /**
     * Returns the casted value for the specified property.
     */
    public function get(
        ObjectResolver $resolver,
        ReflectionProperty $property,
        mixed $value,
        array $array
    ): mixed {
        $class = $this->reflector->getTypeClass($property);

        /** @var ?Timezone */
        $tz = $this->reflector->getAttribute($property, Timezone::class);
        $tzId = $this->tz;

        if (! is_null($tz)) {
            if ($tz->isProperty) {
                return function ($attributes) use ($resolver, $class, $value, $tz) {
                    $tzId = $attributes[$tz->tz_id];

                    if ($tz->useGlobally) {
                        $resolver->getCastResolver()->setTimezone($tzId);
                    }

                    return $class::parse($value, $tzId);
                };
            } else {
                if ($tz->useGlobally) {
                    $resolver->getCastResolver()->setTimezone($tzId);
                }

                $tzId = $tz->tz_id;
            }
        }

        return $class::parse($value, $tzId);
    }
}
