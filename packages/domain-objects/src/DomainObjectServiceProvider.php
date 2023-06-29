<?php

namespace Reedware\DomainObjects;

use Illuminate\Support\ServiceProvider;
use Reedware\DomainObjects\Contracts\CastResolver;
use Reedware\DomainObjects\Contracts\DefaultCastersProvider;
use Reedware\DomainObjects\Contracts\Factory;
use Reedware\DomainObjects\Contracts\KeyResolver;
use Reedware\DomainObjects\Contracts\Reflector;
use Reedware\DomainObjects\Contracts\TransformerFactory;
use Reedware\DomainObjects\Domain;
use Reedware\DomainObjects\Facades\Domain as Facade;

class DomainObjectServiceProvider extends ServiceProvider
{
    /**
     * Registers the services to the container.
     */
    public function register()
    {
        $this->registerDomain();
        $this->registerFactory();
        $this->registerReflector();
        $this->registerKeyResolver();
        $this->registerCastResolver();
        $this->registerDefaultCastersProvider();
        $this->registerTransformerFactory();
    }

    /**
     * Registers the domain implementation.
     */
    protected function registerDomain(): void
    {
        $this->app->singleton(Domain::class, function ($app) {
            return $app->make(Factory::class)->make();
        });
    }

    /**
     * Registers the manager implementation.
     */
    protected function registerFactory(): void
    {
        $this->app->singleton(Factory::class, DomainFactory::class);
    }

    /**
     * Registers the reflector implementation.
     */
    protected function registerReflector(): void
    {
        $this->app->singleton(Reflector::class, DomainObjectReflector::class);
    }

    /**
     * Registers the key resolver implementation.
     */
    protected function registerKeyResolver(): void
    {
        $this->app->singleton(KeyResolver::class, DomainObjectKeyResolver::class);
    }

    /**
     * Registers the cast resolver implementation.
     */
    protected function registerCastResolver(): void
    {
        // Each domain has its own unique cast resolver. This is why the
        // contract isn't bound as a singleton. Instead, this creates
        // a new instance each time, and starts with the default.

        $this->app->bind(CastResolver::class, function ($app) {
            $classes = Facade::getDefaultCasters();

            $casters = array_map(function ($class) use ($app) {
                return $app->make($class);
            }, $classes);

            return new DomainObjectCastResolver($casters);
        });
    }

    /**
     * Registers the default casters provider implementation.
     */
    protected function registerDefaultCastersProvider(): void
    {
        $this->app->singleton(DefaultCastersProvider::class, DefaultCasters::class);
    }

    /**
     * Registers the transformer factory implementation.
     */
    protected function registerTransformerFactory(): void
    {
        $this->app->singleton(TransformerFactory::class, TransformerMatrix::class);
    }
}
