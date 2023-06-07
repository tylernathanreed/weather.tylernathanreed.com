<?php

namespace Reedware\DomainObjects\Contracts;

use Reedware\DomainObjects\Domain;

interface Factory
{
    /**
     * Creates and returns a new domain instance.
     */
    public function make(): Domain;
}
