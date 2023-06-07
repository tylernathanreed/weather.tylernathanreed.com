<?php

namespace Reedware\DomainObjects\Tests\Fixtures;

use Reedware\DomainObjects\DomainObject;
use Reedware\DomainObjects\Attributes\From;

class Reflectable implements DomainObject
{
    public $notReadOnly;
    protected $protected;
    protected readonly bool $readOnlyProtected;
    private $private;

    public function __construct(
        public readonly string $name,

        #[From('notes')]
        public readonly ?string $description,

        public readonly int $value = 0
    ) {
        //
    }
}
