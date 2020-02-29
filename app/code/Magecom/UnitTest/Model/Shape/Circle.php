<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Model\Shape;

use Exception;

/**
 * Class Circle
 * @package Magecom\UnitTest\Model\Shape
 */
class Circle
{

    /**
     * Calculates the square of the circle with a given radius
     * @param float $radius
     * @return float
     * @throws Exception
     */
    public function calculateSquare(float $radius): float
    {
        if ($radius > 0) {
            return pi() * $radius * $radius;
        }
        throw new Exception('Radius must be greater then zero');
    }

    /**
     * @param float $tileWidth
     * @param float $tileLength
     * @param float $circleRadius
     * @return int
     * @throws Exception
     */
    public function getRectanglesCount(float $tileWidth, float $tileLength, float $circleRadius): int
    {
        $index = 1.15; //TODO get from indexProvider
        $tileSquare = $tileLength * $tileWidth;
        $circleSquare = $this->calculateSquare($circleRadius);
        return (int) ceil($circleSquare / $tileSquare * $index);
    }
}
