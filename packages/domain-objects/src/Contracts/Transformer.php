<?php

namespace Reedware\DomainObjects\Contracts;

use Reedware\DomainObjects\DomainObject;

interface Transformer
{
    /**
     * Transforms the specified data into a domain object.
     */
    public function transform(array $data): DomainObject;
}
