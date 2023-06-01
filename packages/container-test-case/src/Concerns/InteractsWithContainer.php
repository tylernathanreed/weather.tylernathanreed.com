<?php

namespace Reedware\ContainerTestCase\Concerns;

use Closure;
use Mockery;
use Mockery\MockInterface;
use Carbon\CarbonImmutable;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Container\Container;
use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;
use Mockery\Exception\InvalidCountException;
use Illuminate\Contracts\Config\Repository as Config;

trait InteractsWithContainer
{
    /**
     * The container implementation.
     */
    protected ?Container $container = null;

    /**
     * Sets up an empty IoC container.
     */
    protected function setUpContainer(): void
    {
        $this->container = Container::getInstance();

        Facade::setFacadeApplication($this->container);
    }

    /**
     * Creates the specified service provider.
     */
    protected function newServiceProvider(string $class): ServiceProvider
    {
        return new $class($this->container);
    }

    /**
     * Registers the specified service provider.
     */
    protected function registerServiceProvider(string $class): void
    {
        $this->newServiceProvider($class)->register();
    }

    /**
     * Boots the specified service provider.
     */
    protected function bootServiceProvider(string $class): void
    {
        $provider = $this->newServiceProvider($class);

        if (method_exists($provider, 'boot')) {
            $provider->boot();
        }
    }

    /**
     * Creates a mock of the specified service and binds it to the container.
     */
    protected function mock(string|object $service, ?Closure $callback = null): MockInterface
    {
        $alias = is_string($service)
            ? $service
            : get_class($service);

        return $this->mockAs($service, $alias, $callback);
    }

    /**
     * Creates a mock of the specified service and binds it to the container under the given alias.
     */
    protected function mockAs(string|object $service, string $alias, ?Closure $callback = null): MockInterface
    {
        $mock = Mockery::mock($service);

        if (! is_null($callback)) {
            $callback($mock);
        }

        $this->container->instance($alias, $mock);

        return $mock;
    }

    /**
     * Creates a mock of the configuration service and binds it to the container.
     */
    protected function mockConfig(array $config): MockInterface
    {
        return $this->mockAs(Config::class, 'config', function (MockInterface $mock) use ($config) {
            $mock
                ->shouldReceive('get')
                ->andReturnUsing(function (string $key, mixed $default = null) use ($config) {
                    return Arr::get($config, $key, $default);
                });
        });
    }

    /**
     * Tears down the IoC container.
     */
    protected function tearDownContainer(): void
    {
        $this->container->flush();
        $this->container = null;

        Facade::clearResolvedInstances();
        Facade::setFacadeApplication(null);
    }

    /**
     * Tears down Mockery.
     */
    protected function tearDownMockery(): void
    {
        if (! is_null($container = Mockery::getContainer())) {
            $this->addToAssertionCount($container->mockery_getExpectationCount());
        }

        try {
            Mockery::close();
        } catch (InvalidCountException $e) {
            if (! Str::contains($e->getMethodName(), ['doWrite', 'askQuestion'])) {
                throw $e;
            }
        }
    }

    /**
     * Tears down Carbon.
     */
    protected function tearDownCarbon(): void
    {
        Carbon::setTestNow();
        CarbonImmutable::setTestNow();
    }
}