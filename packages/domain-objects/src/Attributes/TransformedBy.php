<?php

namespace Reedware\DomainObjects\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class TransformedBy
{
    /**
     * Creates a new #[TransformedBy] attribute.
     */
    public function __construct(
        public readonly string $class
    ) {
        //
    }
}
