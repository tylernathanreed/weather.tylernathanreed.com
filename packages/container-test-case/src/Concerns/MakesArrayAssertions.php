<?php

namespace Reedware\ContainerTestCase\Concerns;

use PHPUnit\Framework\Assert as PHPUnit;
use Illuminate\Testing\Constraints\ArraySubset;

trait MakesArrayAssertions
{
    /**
     * Asserts that an array has a specified subset.
     */
    public static function assertArraySubset(
        iterable $subset,
        iterable $array,
        bool $checkForIdentity = false,
        string $msg = ''
    ): void {
        $constraint = new ArraySubset($subset, $checkForIdentity);

        PHPUnit::assertThat($array, $constraint, $msg);
    }
}
