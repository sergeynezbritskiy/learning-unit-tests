<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Command;

use Magecom\UnitTest\Command\GetOutOfStockProductsCommand;
use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetOutOfStockProductsCommandTest
 * @package Magecom\UnitTest\Test\Unit\Command
 */
class GetOutOfStockProductsCommandTest extends TestCase
{
    /**
     * @inheritDoc
     * @return void
     * @throws LocalizedException
     */
    public function testOutput(): void
    {
        $objectManager = new ObjectManager($this);
        $items = [];
        $item = $this->createMock(Product::class);
        $item->expects($this->once())->method('getSku')->willReturn('SKU_1');
        $items[] = $item;
        $item = $this->createMock(Product::class);
        $item->expects($this->once())->method('getSku')->willReturn('SKU_2');
        $items[] = $item;
        $item = $this->createMock(Product::class);
        $item->expects($this->once())->method('getSku')->willReturn('SKU_3');
        $items[] = $item;

        $collection = $objectManager->getCollectionMock(Collection::class, $items);

        /** @var CollectionFactory|MockObject $collectionFactory */
        $collectionFactory = $this->createMock(CollectionFactory::class);
        $collectionFactory->expects($this->once())->method('create')->willReturn($collection);

        $command = $objectManager->getObject(GetOutOfStockProductsCommand::class,[
            'collectionFactory' => $collectionFactory
        ]);

        /** @var InputInterface|MockObject $input */
        $input = $this->createMock(InputInterface::class);
        /** @var OutputInterface|MockObject $output */
        $output = $this->createMock(OutputInterface::class);

        $output->expects($this->exactly(3))->method('writeln')->withConsecutive(
            ['Product SKU_1 is out of stock'],
            ['Product SKU_2 is out of stock'],
            ['Product SKU_3 is out of stock']
        );

        $command->execute($input, $output);

    }
}
