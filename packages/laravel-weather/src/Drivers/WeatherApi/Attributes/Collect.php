<?php

namespace Reedware\Weather\Drivers\WeatherApi\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_PROPERTY)]
class Collect
{
    /**
     * Creates a new #[Collect] attribute.
     */
    public function __construct(
        public readonly string $class
    ) {
        //
    }
}
