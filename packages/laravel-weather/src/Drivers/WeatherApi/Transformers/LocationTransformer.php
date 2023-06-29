<?php

namespace Reedware\Weather\Drivers\WeatherApi\Transformers;

use Reedware\DomainObjects\Contracts\Transformer;
use Reedware\DomainObjects\DomainObject;
use Reedware\Weather\Drivers\WeatherApi\DTO\Location;

class LocationTransformer implements Transformer
{
    /**
     * Transforms the specified data into a domain object.
     */
    public function transform(array $data): DomainObject
    {
        if (! empty($data['localtime'])) {
            $data['localtime']->shiftTimezone($data['tz_id']);
        }

        return new Location(...$data);
    }
}
