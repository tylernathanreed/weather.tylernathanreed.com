<?php

namespace Reedware\Weather\Drivers\WeatherApi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class From
{
    /**
     * Creates a new #[From] attribute.
     */
    public function __construct(
        public readonly string $key
    ) {
        //
    }
}
