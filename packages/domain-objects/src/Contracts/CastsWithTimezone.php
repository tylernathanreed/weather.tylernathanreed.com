<?php

namespace Reedware\DomainObjects\Contracts;

use DateTimeZone;

interface CastsWithTimezone
{
    /**
     * Returns the timezone that timestamps are parsed in.
     */
    public function getTimezone();

    /**
     * Sets the timezone to parse timestamps in.
     */
    public function setTimezone(DateTimeZone|string|null $tz): void;
}
