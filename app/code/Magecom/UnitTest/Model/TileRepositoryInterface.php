<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Model;

use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class TileRepositoryInterface
 * @package Magecom\UnitTest\Model
 */
interface TileRepositoryInterface
{

    /**
     * @param string $sku
     * @return Tile
     * @throws NoSuchEntityException
     */
    public function getBySku(string $sku): Tile;
}
