<?php

namespace Reedware\DomainObjects\Contracts;

interface DefaultCastersProvider
{
    /**
     * Returns the default caster classes as an array.
     */
    public function get(): array;
}
