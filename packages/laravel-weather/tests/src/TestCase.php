<?php

namespace Reedware\Weather\Tests;

use Reedware\ContainerTestCase\ContainerTestCase;
use Reedware\DomainObjects\DomainObjectServiceProvider;
use Reedware\Weather\WeatherServiceProvider;

abstract class TestCase extends ContainerTestCase
{
    /**
     * Sets up the environment before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerServiceProvider(DomainObjectServiceProvider::class);
        $this->registerServiceProvider(WeatherServiceProvider::class);
    }
}
