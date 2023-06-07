<?php

namespace Reedware\DomainObjects\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class ArrayOf
{
    /**
     * Creates a new #[ArrayOf] attribute.
     */
    public function __construct(
        public readonly string $class
    ) {
        //
    }
}
