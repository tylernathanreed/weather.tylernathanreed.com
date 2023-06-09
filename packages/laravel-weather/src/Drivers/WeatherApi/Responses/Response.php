<?php

namespace Reedware\Weather\Drivers\WeatherApi\Responses;

use Illuminate\Http\Client\Response as HttpResponse;
use Reedware\DomainObjects\DomainObject;

abstract class Response implements DomainObject
{
    /**
     * The base response.
     */
    protected ?HttpResponse $response = null;

    /**
     * Sets the base response.
     */
    public function setBaseResponse(?HttpResponse $response): static
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Returns the base response.
     */
    public function getBaseResponse(): ?HttpResponse
    {
        return $this->response;
    }
}
