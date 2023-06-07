<?php

namespace Reedware\Weather\Drivers\WeatherAPI;

use Illuminate\Http\Client\Response as HttpResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;

class ResponseResolver extends DomainObjectResolver
{
    /**
     * Resolves the domain response from the specified http response.
     */
    public function resolveUsingBaseResponse(string $class, HttpResponse $response): Response
    {
        $array = $response->json();

        if (! is_null($error = $this->tryResolve(ErrorResponse::class, $array))) {
            return $error;
        }

        return $this->resolve($class, $array);
    }
}
