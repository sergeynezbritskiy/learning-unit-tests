<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Model\Shape;

use Exception;
use Magecom\UnitTest\Model\Shape\Rectangle;
use PHPUnit\Framework\TestCase;

/**
 * Class RectangleTest
 * @package Magecom\UnitTest\Test\Unit\Model\Shape
 */
class RectangleTest extends TestCase
{
    /**
     * @var Rectangle
     */
    private $rectangle;

    /**
     * @inheritDoc
     * @return void
     */
    protected function setUp(): void
    {
        $this->rectangle = new Rectangle();
    }

    /**
     * @inheritDoc
     * @return void
     */
    protected function tearDown(): void
    {
        $this->rectangle = null;
    }

    /**
     * @param float $length
     * @param float $width
     * @param float $result
     * @throws Exception
     * @dataProvider positiveScenarios
     */
    public function testPositiveScenarios(float $length, float $width, float $result): void
    {
        $this->assertEquals($result, $this->rectangle->calculateSquare($length, $width));
    }

    /**
     * @param float $length
     * @param float $width
     * @throws Exception
     * @dataProvider exceptionalScenarios
     */
    public function testExceptionalScenarios(float $length, float $width): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Length and width must be greater then zero');
        $this->rectangle->calculateSquare($length, $width);
    }

    /**
     * @return array
     */
    public function exceptionalScenarios(): array
    {
        return [
            [0, 0],
            [0, 1],
            [1, 0],
            [-1, -1],
            [-1, 4],
            [4, -1],
        ];
    }

    /**
     * @return array
     */
    public function positiveScenarios(): array
    {
        return [
            [1, 1, 1],
            [2, 3, 6],
            [4, 2, 8],
            [3, 3, 9]
        ];
    }
}
