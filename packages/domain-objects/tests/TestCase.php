<?php

namespace Reedware\DomainObjects\Tests;

use Reedware\ContainerTestCase\ContainerTestCase;
use Reedware\DomainObjects\DomainObjectServiceProvider;

abstract class TestCase extends ContainerTestCase
{
    /**
     * Sets up the environment before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->registerServiceProvider(DomainObjectServiceProvider::class);
    }
}
