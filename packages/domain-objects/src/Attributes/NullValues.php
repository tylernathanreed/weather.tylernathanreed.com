<?php

namespace Reedware\DomainObjects\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class NullValues
{
    /**
     * Creates a new #[NullValues] attribute.
     */
    public function __construct(
        public readonly array $values,
        public readonly bool $strict = false
    ) {
        //
    }
}
