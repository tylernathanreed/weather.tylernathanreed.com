<?php

namespace Reedware\Weather\Tests;

use Reedware\ContainerTestCase\ContainerTestCase;
use Reedware\Weather\WeatherServiceProvider;

abstract class TestCase extends ContainerTestCase
{
    /**
     * Sets up the environment before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerServiceProvider(WeatherServiceProvider::class);
    }
}
