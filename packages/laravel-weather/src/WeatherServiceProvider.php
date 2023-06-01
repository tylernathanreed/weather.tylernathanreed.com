<?php

namespace Reedware\Weather;

use Illuminate\Support\ServiceProvider;

class WeatherServiceProvider extends ServiceProvider
{
    /**
     * Registers the provided services.
     */
    public function register()
    {
        $this->app->singleton(Manager::class, function ($app) {
            return new Manager($app);
        });

        $this->app->alias(Manager::class, 'weather');
    }
}
