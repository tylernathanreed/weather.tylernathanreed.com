<?php

namespace Reedware\Weather\Drivers\WeatherApi\DTO;

use Carbon\Carbon;
use Reedware\DomainObjects\Attributes\From;

class Alert extends DTO
{
    /**
     * Creates a new alert DTO instance.
     */
    public function __construct(
        /** Alert headline. */
        public readonly string $headline,

        /** Type of alert. */
        public readonly string $msgtype,

        /** Severity of alert. */
        public readonly string $severity,

        /** Urgency. */
        public readonly string $urgency,

        /** Areas covered. */
        public readonly string $areas,

        /** Category. */
        public readonly string $category,

        /** Certainty. */
        public readonly string $certainty,

        /** Event. */
        public readonly string $event,

        /** Note. */
        public readonly string $note,

        /** Effective. */
        public readonly Carbon $effective,

        /** Expires. */
        public readonly Carbon $expires,

        /** Description. */
        #[From('desc')]
        public readonly string $description,

        /** Instruction. */
        public readonly string $instruction
    ) {
        //  
    }
}