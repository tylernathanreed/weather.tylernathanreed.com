<?php

namespace Reedware\DomainObjects;

use Carbon\CarbonTimeZone;
use DateTime;
use Reedware\DomainObjects\Contracts\Caster;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\CastsWithTimezone;
use Reedware\DomainObjects\Contracts\ObjectResolver;
use Reedware\DomainObjects\Exceptions\CastFailedException;
use ReflectionProperty;
use Throwable;

class DomainObjectCastResolver implements CastResolver
{
    /**
     * Creates a new cast resolver instance.
     */
    public function __construct(
        /** @var array<Caster> */
        protected array $casters = []
    ) {
        //
    }

    /**
     * Casts the specified domain object property.
     */
    public function cast(
        ObjectResolver $resolver,
        ReflectionProperty $property,
        mixed $value,
        array $array
    ): mixed {
        foreach ($this->casters as $caster) {
            if (! $caster->appliesTo($property, $value)) {
                continue;
            }

            try {
                $value = $caster->get($resolver, $property, $value, $array);
            } catch (Throwable $e) {
                throw new CastFailedException($caster, $property, $value, $e);
            }
        }

        return $value;
    }

    /**
     * Adds the specified caster into the caster array.
     */
    public function add(Caster $caster): static
    {
        $this->casters[] = $caster;

        return $this;
    }

    /**
     * Replaces the specified caster with another.
     */
    public function replace(string $class, Caster $replacement): static
    {
        $this->casters = array_map(function (Caster $caster) use ($class, $replacement) {
            if (is_a($caster, $class, true)) {
                return $replacement;
            }

            return $caster;
        }, $this->casters);

        return $this;
    }

    /**
     * Removes the specified caster.
     */
    public function remove(string $class): static
    {
        $this->casters = array_values(array_filter($this->casters, function (Caster $caster) use ($class) {
            if (is_a($caster, $class, true)) {
                return false;
            }

            return true;
        }));

        return $this;
    }

    /**
     * Returns the timezone for the first cast that uses it.
     */
    public function getTimezone(): ?CarbonTimeZone
    {
        foreach ($this->getCasters() as $caster) {
            if ($caster instanceof CastsWithTimezone) {
                return $caster->getTimezone();
            }
        }
    }

    /**
     * Sets the timezone for casters that use them.
     */
    public function setTimezone(DateTime|string|null $tz): void
    {
        foreach ($this->getCasters() as $caster) {
            if ($caster instanceof CastsWithTimezone) {
                $caster->setTimezone($tz);
            }
        }
    }

    /**
     * Returns the casters.
     */
    public function getCasters(): array
    {
        return $this->casters;
    }
}
