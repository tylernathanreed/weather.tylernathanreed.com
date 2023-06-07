<?php

namespace Reedware\DomainObjects\Tests\Fixtures;

use Reedware\DomainObjects\DomainObject;

class Castable implements DomainObject
{
    public function __construct(
        public readonly string $name
    ) {
        //
    }
}
