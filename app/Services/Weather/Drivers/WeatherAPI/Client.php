<?php

namespace App\Services\Weather\Drivers\WeatherAPI;

use App\Services\Weather\Drivers\WeatherAPI\Requests\AstronomyRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\CurrentRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\ForecastRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\FutureRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\HistoryRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\Request;
use App\Services\Weather\Drivers\WeatherAPI\Requests\SearchRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\TimeZoneRequest;
use App\Services\Weather\Drivers\WeatherAPI\Responses\AstronomyResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\CurrentResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\ErrorResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\ForecastResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\FutureResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\HistoryResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\Response;
use App\Services\Weather\Drivers\WeatherAPI\Responses\SearchResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\TimeZoneResponse;
use Illuminate\Http\Client\Factory as Http;
use Illuminate\Http\Client\Response as HttpResponse;

class Client
{
    /**
     * Creates a new client instance.
     */
    public function __construct(
        protected Http $http,
        protected string $apiKey,
        protected string $baseUrl = 'https://api.weatherapi.com/v1/'
    ) {
        //
    }

    /**
     * Returns the response for the specified astronomy request.
     */
    public function astronomy(AstronomyRequest $request): Response
    {
        return $this->create(AstronomyResponse::class, $request);
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(ForecastRequest $request): Response
    {
        return $this->create(ForecastResponse::class, $request);
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(FutureRequest $request): Response
    {
        return $this->create(FutureResponse::class, $request);
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(HistoryRequest $request): Response
    {
        return $this->create(HistoryResponse::class, $request);
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(CurrentRequest $request): Response
    {
        return $this->create(CurrentResponse::class, $request);
    }

    /**
     * Returns the response for the specified search request.
     */
    public function search(SearchRequest $request): Response
    {
        return $this->create(SearchResponse::class, $request);
    }

    /**
     * Returns the response for the specified timeZone request.
     */
    public function timeZone(TimeZoneRequest $request): Response
    {
        return $this->create(TimeZoneResponse::class, $request);
    }

    /**
     * Creates the specified response from the given request.
     */
    protected function create(string $responseClass, Request $request): Response
    {
        $baseResponse = $this->send($request);

        if (! is_null($error = $this->getErrorResponse($baseResponse))) {
            return $error;
        }

        /** {@see Response::createFromBaseResponse} */
        return $responseClass::createFromBaseResponse($baseResponse);
    }

    /**
     * Returns whether or not the specified base response is an error response.
     */
    protected function getErrorResponse(HttpResponse $baseResponse): ?ErrorResponse
    {
        if (! is_null($response = ErrorResponse::tryFromBaseResponse($baseResponse))) {
            return $response;
        }

        return null;
    }

    /**
     * Sends the specified request.
     */
    protected function send(Request $request): HttpResponse
    {
        return $this->call($request->uri(), $request->parameters());
    }

    /**
     * Makes the specified api call.
     */
    protected function call(string $uri, array $parameters): HttpResponse
    {
        return $this
            ->http
            ->baseUrl($this->baseUrl)
            ->acceptJson()
            ->dump()
            ->get($uri, array_merge($parameters, [
                'key' => $this->apiKey
            ]));
    }
}
