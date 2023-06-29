<?php

namespace Reedware\DomainObjects\Exceptions;

use RuntimeException;

class TransformerNotFoundException extends RuntimeException
{
    /**
     * Creates a new exception instance.
     */
    public function __construct(string $class)
    {
        return parent::__construct(sprintf(
            'Unable to find transformer for class [%s].',
            $class
        ));
    }
}
