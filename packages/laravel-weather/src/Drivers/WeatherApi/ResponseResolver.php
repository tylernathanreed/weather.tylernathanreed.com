<?php

namespace Reedware\Weather\Drivers\WeatherApi;

use Illuminate\Http\Client\Response as HttpResponse;
use Reedware\DomainObjects\Contracts\Domain;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;

class ResponseResolver
{
    /**
     * Creates a new response resolver instance.
     */
    public function __construct(
        protected Domain $domain
    ) {
        //
    }

    /**
     * Resolves the specified response from the specified http response.
     */
    public function resolve(string $class, HttpResponse $baseResponse): Response
    {
        $response = $this->getResponseFromArray($class, $baseResponse->json());

        return $response->setBaseResponse($baseResponse);
    }

    /**
     * Resolves the speocified response from the given array.
     */
    protected function getResponseFromArray(string $class, array $array): Response
    {
        if (! is_null($error = $this->domain->tryResolve(ErrorResponse::class, $array))) {
            return $error;
        }

        return $this->domain->resolve($class, $array);
    }
}
