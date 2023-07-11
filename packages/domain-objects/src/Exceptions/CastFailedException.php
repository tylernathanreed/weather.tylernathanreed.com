<?php

namespace Reedware\DomainObjects\Exceptions;

use Reedware\DomainObjects\Casts\Caster;
use ReflectionProperty;
use RuntimeException;
use Throwable;

class CastFailedException extends RuntimeException
{
    /**
     * Creates a new exception instance.
     */
    public function __construct(Caster $caster, ReflectionProperty $property, mixed $value, Throwable $e)
    {
        return parent::__construct(sprintf(
            'Failed to apply caster [%s] to property [%s] with %s value%s. (%s)',
            get_class($caster),
            $property->getName(),
            gettype($value),
            is_scalar($value)
                ? ' [' . $value . ']'
                : '',
            $e->getMessage()
        ), 0, $e);
    }
}
