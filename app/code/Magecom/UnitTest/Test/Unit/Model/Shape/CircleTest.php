<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Model\Shape;

use Exception;
use Magecom\UnitTest\Model\Shape\Circle;
use PHPUnit\Framework\TestCase;

/**
 * Class CircleTest
 * @package Magecom\UnitTest\Test\Unit\Model\Shape
 */
class CircleTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testPositiveValue(): void
    {
        $circle = new Circle();
        $this->assertEquals(2 * 2 * pi(), $circle->calculateSquare(2));
    }

    /**
     * @throws Exception
     */
    public function testZeroValue(): void
    {
        $circle = new Circle();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Radius must be greater then zero');
        $circle->calculateSquare(0);
    }

    /**
     * @throws Exception
     */
    public function testNegativeValue(): void
    {
        $circle = new Circle();
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Radius must be greater then zero');
        $circle->calculateSquare(-1);
    }
}
