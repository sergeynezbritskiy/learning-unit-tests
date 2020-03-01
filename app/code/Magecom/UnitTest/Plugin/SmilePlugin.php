<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Plugin;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Product;

/**
 * Class SmilePlugin
 * @package Magecom\UnitTest\Plugin
 */
class SmilePlugin
{
    /**
     * @param Product $subject
     * @param string $result
     * @return string
     */
    public function afterGetName(Product $subject, string $result): string
    {
        if ($subject->isInStock() === false || $subject->getQty() === 0) {
            $result .= ' :-(';
        }
        return $result;
    }

    /**
     * @param Product $subject
     * @param mixed $result
     * @param string $key
     * @return mixed
     */
    public function afterGetData(Product $subject, $result, string $key)
    {
        if ($key === ProductInterface::NAME) {
            if ($subject->isInStock() === false || $subject->getQty() === 0) {
                $result .= ' :-(';
            }
        }
        return $result;
    }
}
