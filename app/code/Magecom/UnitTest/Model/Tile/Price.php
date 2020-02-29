<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Model\Tile;

use Exception;
use Magecom\UnitTest\Model\Shape\Circle;
use Magecom\UnitTest\Model\Tile;

/**
 * Class Tile
 * @package Magecom\UnitTest\Model
 */
class Price
{
    private $circle;

    /**
     * Tile constructor.
     * @param Circle $circle
     */
    public function __construct(Circle $circle)
    {
        $this->circle = $circle;
    }

    /**
     * @param Tile $tile
     * @param float $radius
     * @return float
     * @throws Exception
     */
    public function calculate(Tile $tile, float $radius): float
    {
        $tileLength = $tile->getLength();
        $tileWidth = $tile->getWidth();
        $price = $tile->getPrice();

        $amount = $this->circle->getRectanglesCount($tileWidth, $tileLength, $radius);
        return $price * $amount;
    }
}
