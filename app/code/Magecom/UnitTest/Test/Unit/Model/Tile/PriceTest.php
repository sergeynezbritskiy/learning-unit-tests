<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Model\Tile;

use Exception;
use Magecom\UnitTest\Model\Shape\Circle;
use Magecom\UnitTest\Model\Tile;
use Magecom\UnitTest\Model\Tile\Price;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class PriceTest
 * @package Magecom\UnitTest\Test\Unit\Model\Tile
 */
class PriceTest extends TestCase
{
    /**
     * @throws Exception
     */
    public function testPriceCalculation(): void
    {
        /** @var Circle|MockObject $circle */
        $circle = $this->createMock(Circle::class);
        $circle->method('getRectanglesCount')->willReturn(5);
        $price = new Price($circle);
        $tile = new Tile(['width' => 2, 'length' => 3, 'price' => 4]);
        $this->assertEquals(20, $price->calculate($tile, 2));
    }

    /**
     * @throws Exception
     */
    public function testCalculationForInvalidRadius(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('some exception');

        /** @var Circle|MockObject $circle */
        $circle = $this->createMock(Circle::class);
        $circle->method('getRectanglesCount')->willThrowException(new Exception('some exception'));

        $price = new Price($circle);
        $tile = new Tile(['width' => 2, 'length' => 3, 'price' => 4]);
        $price->calculate($tile, 2);
    }
}
