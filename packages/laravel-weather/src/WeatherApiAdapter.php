<?php

namespace Reedware\Weather;

use Barryvdh\Debugbar\Facades\Debugbar;
use Carbon\Carbon;
use Closure;
use Illuminate\Contracts\Cache\Repository;
use Reedware\Weather\Drivers\WeatherApi\Decorator;
use Reedware\Weather\Drivers\WeatherApi\Exceptions\ErrorResponseException;
use Reedware\Weather\Drivers\WeatherApi\Responses\AstronomyResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\CurrentResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\ForecastResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\FutureResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\HistoryResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\IpLookupResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\Response;
use Reedware\Weather\Drivers\WeatherApi\Responses\SearchResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\SportsResponse;
use Reedware\Weather\Drivers\WeatherApi\Responses\TimeZoneResponse;

class WeatherApiAdapter
{
    /**
     * The location being searched.
     */
    protected ?string $q = null;

    /**
     * Creates a new adapter instance.
     */
    public function __construct(
        protected Decorator $api,
        protected Repository $cache,
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
     * Remembers the specified request and its response.
     */
    protected function remember(array $context, Closure $callback): Response
    {
        [$key, $ttl] = $this->parameterize($context);

        return $this->cache->remember($key, $ttl, function () use ($context, $callback) {
            $benchmark = microtime(true);
            $response = $callback();
            $runtime = microtime(true) - $benchmark;

            Debugbar::addMessage('Context: ' . json_encode($context) . '; Runtime: ' . $runtime);

            return $response;
        });
    }

    /**
     * Converts the specified context into a cache key and ttl.
     */
    protected function parameterize(array $context): array
    {
        return [
            json_encode($context),
            15 * 1000
        ];
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
            $ipLocation = $this->api->ipLookup()->location;

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
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q', 'dt'),
            fn () => $this->api->astronomy($q, $dt)
        );
    }

    /**
     * Returns the response for the specified forecast request.
     */
    public function forecast(int $days = 3, bool $aqi = false, bool $alerts = false): ForecastResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q', 'days', 'aqi', 'alerts'),
            fn () => $this->api->forecast($q, $days, $aqi, $alerts)
        );
    }

    /**
     * Returns the response for the specified future request.
     */
    public function future(?Carbon $dt = null): FutureResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q', 'dt'),
            fn () => $this->api->future($q, $dt)
        );
    }

    /**
     * Returns the response for the specified history request.
     */
    public function history(?Carbon $dt = null): HistoryResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q', 'dt'),
            fn () => $this->api->history($q, $dt)
        );
    }

    /**
     * Returns the response for the specified current request.
     */
    public function current(string $q, bool $aqi = false): CurrentResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q', 'aqi'),
            fn () => $this->api->current($q, $aqi)
        );
    }

    /**
     * Returns the response for the specified search request.
     */
    public function search(string $q): SearchResponse
    {
        $m = __METHOD__;

        return $this->remember(
            compact('m', 'q'),
            fn () => $this->api->search($q)
        );
    }

    /**
     * Returns the response for the specified ip lookup request.
     */
    public function ipLookup(string $q): IpLookupResponse
    {
        $m = __METHOD__;

        return $this->remember(
            compact('m', 'q'),
            fn () => $this->api->ipLookup($q)
        );
    }

    /**
     * Returns the response for the specified timezone request.
     */
    public function timeZone(): TimeZoneResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q'),
            fn () => $this->api->timeZone($q)
        );
    }

    /**
     * Returns the response for the specified sports request.
     */
    public function sports(): SportsResponse
    {
        $m = __METHOD__;
        $q = $this->getLocationString();

        return $this->remember(
            compact('m', 'q'),
            fn () => $this->api->sports($q)
        );
    }

    /**
     * Returns the underlying api decorator.
     */
    public function getApi(): Decorator
    {
        return $this->api;
    }
}