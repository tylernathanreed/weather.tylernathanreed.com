<?php

namespace Reedware\ContainerTestCase;

use PHPUnit\Framework\TestCase;

/**
 * This type of test offers an IoC container, but does not boot the
 * Laravel framework. This results in limited functionality, but
 * offers a significant performance boost. Extend this wisely.
 */
abstract class ContainerTestCase extends TestCase
{
    use Concerns\InteractsWithContainer,
        Concerns\MakesArrayAssertions;

    /**
     * Sets up the environment before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();

        $this->setUpContainer();
    }

    /**
     * Tears down the application after each test.
     */
    protected function tearDown(): void
    {
        $this->tearDownContainer();
        $this->tearDownMockery();
        $this->tearDownCarbon();

        parent::tearDown();
    }
}
