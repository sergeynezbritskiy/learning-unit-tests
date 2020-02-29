<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Model;

use Magento\Framework\DataObject;

/**
 * Class Tile
 * @package Magecom\UnitTest\Test\Unit\Model
 */
class Tile extends DataObject
{
    /**
     * @return float
     */
    public function getWidth(): float
    {
        return $this->getData('width');
    }

    /**
     * @return float
     */
    public function getLength(): float
    {
        return $this->getData('length');
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->getData('price');
    }
}
