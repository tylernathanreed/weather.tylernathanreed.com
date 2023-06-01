<?php

namespace Reedware\Weather\Drivers\WeatherApi;

use Illuminate\Support\Carbon;
use Reedware\Weather\Drivers\WeatherApi\Exceptions\ErrorResponseException;
use Reedware\Weather\Drivers\WeatherApi\Requests\AstronomyRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\CurrentRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\Enums\YesNo;
use Reedware\Weather\Drivers\WeatherApi\Requests\ForecastRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\FutureRequest;
use Reedware\Weather\Drivers\WeatherApi\Requests\HistoryRequest;
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

class Decorator
{
    /**
     * Creates a new decorator instance.
     */
    public function __construct(
        protected Client $client
    ) {
        //
    }

    /**
     * Returns the response for the specified astronomy request.
     */
    public function astronomy(string $q, ?Carbon $dt = null): AstronomyResponse
    {
        $dt ??= Carbon::now();

        $request = new AstronomyRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->astronomy($request)
        );
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(string $q, int $days = 3, bool $aqi = false, bool $alerts = false): ForecastResponse
    {
        $request = new ForecastRequest($q, $days, $aqi, $alerts);

        return $this->returnOrThrow(
            $this->client->forecast($request)
        );
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(string $q, ?Carbon $dt = null): FutureResponse
    {
        $dt ??= Carbon::now()->addDays(14);

        $request = new FutureRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->future($request)
        );
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(string $q, ?Carbon $dt = null): HistoryResponse
    {
        $dt ??= Carbon::now()->subDay();

        $request = new HistoryRequest($q, $dt->toDateString());

        return $this->returnOrThrow(
            $this->client->history($request)
        );
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(string $q, bool $aqi = false): CurrentResponse
    {
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
     * Returns the response for the specified timeZone request.
     */
    public function timeZone(string $q): TimeZoneResponse
    {
        $request = new TimeZoneRequest($q);

        return $this->returnOrThrow(
            $this->client->timeZone($request)
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
