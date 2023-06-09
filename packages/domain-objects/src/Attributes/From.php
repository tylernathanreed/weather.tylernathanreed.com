<?php

namespace Reedware\DomainObjects\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class From
{
    /**
     * Creates a new #[From] attribute.
     */
    public function __construct(
        public readonly ?string $key
    ) {
        //
    }
}
