<?php

namespace App\Services\Weather\Drivers\WeatherAPI;

use App\Services\Weather\Drivers\WeatherAPI\Requests\AstronomyRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\CurrentRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\Enums\YesNo;
use App\Services\Weather\Drivers\WeatherAPI\Requests\ForecastRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\FutureRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\HistoryRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\SearchRequest;
use App\Services\Weather\Drivers\WeatherAPI\Requests\TimeZoneRequest;
use App\Services\Weather\Drivers\WeatherAPI\Responses\AstronomyResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\CurrentResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\ErrorResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\ForecastResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\FutureResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\HistoryResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\SearchResponse;
use App\Services\Weather\Drivers\WeatherAPI\Responses\TimeZoneResponse;
use Illuminate\Support\Carbon;

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
    public function astronomy(string $q, Carbon $dt): AstronomyResponse|ErrorResponse
    {
        $request = new AstronomyRequest($q, $dt);

        return $this->client->astronomy($request);
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(string $q, int $days = 3, bool $aqi = false, bool $alerts = false): ForecastResponse|ErrorResponse
    {
        $request = new ForecastRequest($q, $days, $aqi, $alerts);

        return $this->client->forecast($request);
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(string $q, Carbon $dt): FutureResponse|ErrorResponse
    {
        $request = new FutureRequest($q, $dt);

        return $this->client->future($request);
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(string $q, Carbon $dt): HistoryResponse|ErrorResponse
    {
        $request = new HistoryRequest($q, $dt);

        return $this->client->history($request);
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(string $q, bool $aqi = false): CurrentResponse|ErrorResponse
    {
        $request = new CurrentRequest($q, YesNo::from($aqi));

        return $this->client->current($request);
    }

    /**
     * Returns the response for the specified search request.
     */
    public function search(string $q): SearchResponse|ErrorResponse
    {
        $request = new SearchRequest($q);

        return $this->client->search($request);
    }

    /**
     * Returns the response for the specified timeZone request.
     */
    public function timeZone(string $q): TimeZoneResponse|ErrorResponse
    {
        $request = new TimeZoneRequest($q);

        return $this->client->timeZone($request);
    }
}
