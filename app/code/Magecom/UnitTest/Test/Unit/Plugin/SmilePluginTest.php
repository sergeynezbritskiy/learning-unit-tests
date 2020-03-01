<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Plugin;

use Magecom\UnitTest\Plugin\SmilePlugin;
use Magento\Catalog\Model\Product;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

/**
 * Class SmilePluginTest
 * @package Magecom\UnitTest\Test\Unit\Plugin
 */
class SmilePluginTest extends TestCase
{
    /**
     * @var SmilePlugin
     */
    private $plugin;

    /**
     * @var MockObject|Product
     */
    private $product;

    /**
     * @inheritDoc
     * @return void
     */
    protected function setUp(): void
    {
        $objectManager = new ObjectManager($this);
        $this->plugin = $objectManager->getObject(SmilePlugin::class);
        $this->product = $this->createMock(Product::class);
    }

    /**
     * @inheritDoc
     * @return void
     */
    protected function tearDown(): void
    {
        $this->plugin = null;
        $this->product = null;
    }

    /**
     * @param bool $status
     * @param int $qty
     * @param string $expectedResult
     * @return void
     * @dataProvider getProductInfo
     */
    public function testGetProductName(bool $status, int $qty, string $expectedResult): void
    {
        $this->product->method('isInStock')->willReturn($status);
        $this->product->method('getQty')->willReturn($qty);
        $this->assertEquals($expectedResult, $this->plugin->afterGetName($this->product, 'Test Product'));
    }

    /**
     * @param bool $status
     * @param int $qty
     * @param string $expectedResult
     * @return void
     * @dataProvider getProductInfo
     */
    public function testGetData(bool $status, int $qty, string $expectedResult): void
    {
        $this->product->method('isInStock')->willReturn($status);
        $this->product->method('getQty')->willReturn($qty);
        $this->assertEquals($expectedResult, $this->plugin->afterGetData($this->product, 'Test Product', 'name'));
    }

    public function testGetDataForOtherKeys(): void
    {
        $this->product->method('isInStock')->willReturn(false);
        $this->product->method('getQty')->willReturn(0);
        $this->assertEquals('Test Description', $this->plugin->afterGetData($this->product, 'Test Description', 'description'));
        $this->assertEquals(15, $this->plugin->afterGetData($this->product, 15, 'qty'));
        $this->assertEquals(15.3, $this->plugin->afterGetData($this->product, 15.3, 'price'));
    }

    /**
     * @return array
     */
    public function getProductInfo(): array
    {
        return [
            [true, 10, 'Test Product'],
            [true, 0, 'Test Product :-('],
            [false, 10, 'Test Product :-('],
            [false, 0, 'Test Product :-('],
        ];
    }
}
