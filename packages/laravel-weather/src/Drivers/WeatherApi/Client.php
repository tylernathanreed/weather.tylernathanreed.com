<?php

namespace Reedware\Weather\Drivers\WeatherApi;

use Reedware\Weather\Drivers\WeatherApi\Requests\AstronomyRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\CurrentRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\ForecastRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\FutureRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\HistoryRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\Request;
use Reedware\Weather\Drivers\WeatherApi\Requests\SearchRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\TimeZoneRequest;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;
use Illuminate\Http\Client\Factory as Http;
use Illuminate\Http\Client\Response as HttpResponse;
use Reedware\Weather\Drivers\WeatherApi\Requests\IpLookupRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\SportsRequest;
use Reedware\Weather\Drivers\WeatherAPI\ResponseResolver;
use Reedware\Weather\Drivers\WeatherApi\Responses\IpLookupResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\SportsResponse;

class Client
{
    /**
     * Creates a new client instance.
     */
    public function __construct(
        protected Http $http,
        protected ResponseResolver $resolver,
        protected string $apiKey,
        protected string $baseUrl = 'https://api.weatherapi.com/v1/'
    ) {
        //
    }

    /**
     * Returns the response for the specified astronomy request.
     */
    public function astronomy(AstronomyRequest $request): AstronomyResponse|ErrorResponse
    {
        return $this->create(AstronomyResponse::class, $request);
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(ForecastRequest $request): ForecastResponse|ErrorResponse
    {
        return $this->create(ForecastResponse::class, $request);
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(FutureRequest $request): FutureResponse|ErrorResponse
    {
        return $this->create(FutureResponse::class, $request);
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(HistoryRequest $request): HistoryResponse|ErrorResponse
    {
        return $this->create(HistoryResponse::class, $request);
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(CurrentRequest $request): CurrentResponse|ErrorResponse
    {
        return $this->create(CurrentResponse::class, $request);
    }

    /**
     * Returns the response for the specified search request.
     */
    public function search(SearchRequest $request): SearchResponse|ErrorResponse
    {
        return $this->create(SearchResponse::class, $request);
    }

    /**
     * Returns the response for the specified ip lookup request.
     */
    public function ipLookup(IpLookupRequest $request): IpLookupResponse|ErrorResponse
    {
        return $this->create(IpLookupResponse::class, $request);
    }

    /**
     * Returns the response for the specified timezone request.
     */
    public function timeZone(TimeZoneRequest $request): TimeZoneResponse|ErrorResponse
    {
        return $this->create(TimeZoneResponse::class, $request);
    }

    /**
     * Returns the response for the specified sports request.
     */
    public function sports(SportsRequest $request): SportsResponse|ErrorResponse
    {
        return $this->create(SportsResponse::class, $request);
    }

    /**
     * Creates the specified response from the given request.
     */
    protected function create(string $responseClass, Request $request): Response
    {
        $baseResponse = $this->send($request);

        return $this->resolver->resolve($responseClass, $baseResponse);
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
            ->get($uri, array_merge($parameters, [
                'key' => $this->apiKey
            ]));
    }
}
