<?php

namespace Reedware\Weather;

use Illuminate\Contracts\Cache\Factory as CacheFactory;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\MultipleInstanceManager;
use InvalidArgumentException;
use Reedware\Weather\Drivers\WeatherApi\Client as WeatherApiClient;
use Reedware\Weather\Drivers\WeatherApi\Decorator;
use Reedware\Weather\Drivers\WeatherApi\ResponseResolver;

class Manager extends MultipleInstanceManager
{
    /**
     * Returns the specified weather api connection.
     */
    public function connection(?string $name = null)
    {
        return $this->instance($name);
    }

    /**
     * Returns the default instance name.
     */
    public function getDefaultInstance(): string
    {
        return $this->app->make('config')->get('weather.default');
    }

    /**
     * Returns the default instance name.
     */
    public function setDefaultInstance($name): void
    {
        $this->app->make('config')->set('weather.default', $name);
    }

    /**
     * Returns the instance specific configuration.
     */
    public function getInstanceConfig($name): array
    {
        return $this->app->make('config')->get("weather.connections.{$name}");
    }

    /**
     * Creates a new weather api driver.
     */
    protected function createWeatherApiDriver(array $config)
    {
        if (! isset($config['key'])) {
            throw new InvalidArgumentException('Missing api key for WeatherApi driver.');
        }

        $client = new WeatherApiClient(
            $this->app->make(HttpFactory::class),
            $this->app->make(ResponseResolver::class),
            $config['key']
        );

        $fallbackLocation = $this->app->make('config')->get('weather.fallback-location');

        $api = new Decorator($client);
        $cache = $this->app->make(CacheFactory::class)->store($config['cache']);
        $events = $this->app->make(Dispatcher::class);

        return new WeatherApiAdapter(
            $api,
            $cache,
            $events,
            $fallbackLocation
        );
    }
}
