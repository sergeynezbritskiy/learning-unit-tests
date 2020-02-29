<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Model\Shape;

use Exception;

/**
 * Class Rectangle
 * @package Magecom\UnitTest\Model\Shape
 */
class Rectangle
{
    /**
     * @param float $length
     * @param float $width
     * @return float
     * @throws Exception
     */
    public function calculateSquare(float $length, float $width): float
    {
        if ($length > 0 && $width > 0) {
            return $width * $length;
        }
        throw new Exception("Length and width must be greater then zero");
    }
}
