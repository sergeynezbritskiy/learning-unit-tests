<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit;


use PHPUnit\Framework\TestCase;

class SampleTest extends TestCase
{
    /**
     * @test
     */
    public function assertTruePositive(): void
    {
        $this->assertTrue(true);
    }
}
