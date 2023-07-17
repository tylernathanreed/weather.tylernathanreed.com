<?php

namespace Reedware\Weather\Events;

class ApiRequestHandled
{
    /**
     * Creates a new event instance.
     */
    public function __construct(
        public readonly array $context,
        public readonly object $response,
        public readonly float $runtime
    ) {
        //
    }
}
