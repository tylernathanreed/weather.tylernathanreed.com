<?php

namespace Reedware\DomainObjects\Contracts;

interface TransformerFactory
{
    /**
     * Returns whether or not a transformer for the specified class exists.
     */
    public function exists(string $class): bool;

    /**
     * Returns the transformer, for the specified domain object class.
     */
    public function make(string $class): Transformer;
}
