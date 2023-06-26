<?php

namespace Reedware\DomainObjects\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Timezone
{
    /**
     * Creates a new #[Timezone] attribute.
     */
    public function __construct(
        public readonly string $tz_id,
        public readonly bool $isProperty = false
    ) {
        //
    }
}
