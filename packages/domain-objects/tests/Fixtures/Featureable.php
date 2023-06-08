<?php

namespace Reedware\DomainObjects\Tests\Fixtures;

use Carbon\Carbon;
use Reedware\DomainObjects\Attributes\ArrayOf;
use Reedware\DomainObjects\DomainObject;
use Reedware\DomainObjects\Attributes\From;

class Featureable implements DomainObject
{
    public function __construct(
        public readonly string $name,

        #[From('description')]
        public readonly string $notes,

        #[ArrayOf(Castable::class)]
        public readonly array $castables,

        public readonly Carbon $datetime,

        public readonly Enumerable $enum,

        public readonly bool $success = true
    ) {
        //
    }
}
