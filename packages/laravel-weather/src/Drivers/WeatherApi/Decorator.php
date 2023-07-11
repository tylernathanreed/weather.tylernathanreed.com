<?php

namespace Reedware\Weather\Drivers\WeatherApi;

use Carbon\Carbon;
use Illuminate\Support\Facades\Request;
use Reedware\Weather\Drivers\WeatherApi\Exceptions\ErrorResponseException;
use Reedware\Weather\Drivers\WeatherApi\Requests\AstronomyRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\CurrentRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;
use Reedware\Weather\Drivers\WeatherApi\Requests\ForecastRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\FutureRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\HistoryRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\IpLookupRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\SearchRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\SportsRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\TimeZoneRequest;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ErrorResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\IpLookupResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\SportsResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;

class Decorator
{
    /**
     * The location being searched.
     */
    protected ?string $q = null;

    /**
     * Creates a new decorator instance.
     */
    public function __construct(
        protected Client $client,
        protected string $fallbackLocation
    ) {
        //
    }

    /**
     * Sets the location being searched.
     */
    public function for(string $q): self
    {
        $this->q = $q;

        return $this;
    }

    /**
     * Returns the location being searched.
     */
    public function getLocationString(): string
    {
        return $this->q ??= $this->resolveLocationString();
    }

    /**
     * Resolves an automatic location to search based on IP address.
     */
    protected function resolveLocationString(): string
    {
        try {
            $ipLocation = $this->ipLookup()->location;

            return $ipLocation->lat . ',' . $ipLocation->lon;
        } catch (ErrorResponseException $e) {
            return $this->fallbackLocation;
        }
    }

    /**
     * Returns the response for the specified astronomy request.
     */
    public function astronomy(?Carbon $dt = null): AstronomyResponse
    {
        $q = $this->getLocationString();
        $dt ??= Carbon::now();

        $request = new AstronomyRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->astronomy($request)
        );
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(int $days = 3, bool $aqi = false, bool $alerts = false): ForecastResponse
    {
        $q = $this->getLocationString();
        $request = new ForecastRequest($q, $days, YesNo::from($aqi), YesNo::from($alerts));

        return $this->returnOrThrow(
            $this->client->forecast($request)
        );
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(?Carbon $dt = null): FutureResponse
    {
        $q = $this->getLocationString();
        $dt ??= Carbon::now()->addDays(14);

        $request = new FutureRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->future($request)
        );
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(?Carbon $dt = null): HistoryResponse
    {
        $q = $this->getLocationString();
        $dt ??= Carbon::now()->subDay();

        $request = new HistoryRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->history($request)
        );
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(bool $aqi = false): CurrentResponse
    {
        $q = $this->getLocationString();
        $request = new CurrentRequest($q, YesNo::from($aqi));

        return $this->returnOrThrow(
            $this->client->current($request)
        );
    }

    /**
     * Returns the response for the specified search request.
     */
    public function search(string $q): SearchResponse
    {
        $request = new SearchRequest($q);

        return $this->returnOrThrow(
            $this->client->search($request)
        );
    }

    /**
     * Returns the response for the specified ip lookup request.
     */
    public function ipLookup(string $q = null): IpLookupResponse
    {
        $request = new IpLookupRequest($q ?: Request::ip());

        return $this->returnOrThrow(
            $this->client->ipLookup($request)
        );
    }

    /**
     * Returns the response for the specified timezone request.
     */
    public function timeZone(): TimeZoneResponse
    {
        $q = $this->getLocationString();
        $request = new TimeZoneRequest($q);

        return $this->returnOrThrow(
            $this->client->timeZone($request)
        );
    }

    /**
     * Returns the response for the specified sports request.
     */
    public function sports(): SportsResponse
    {
        $q = $this->getLocationString();
        $request = new SportsRequest($q);

        return $this->returnOrThrow(
            $this->client->sports($request)
        );
    }

    /**
     * Returns the underlying client.
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * Returns the specified response if it is not an error, otherwise, an exception is thrown.
     */
    protected function returnOrThrow(Response $response): Response
    {
        if ($response instanceof ErrorResponse) {
            throw new ErrorResponseException($response);
        }

        return $response;
    }
}
