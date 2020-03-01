<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Command;

use Magento\Catalog\Model\Product;
use Magento\Catalog\Model\ResourceModel\Product\Collection;
use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Exception\LocalizedException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class GetOutOfStockProductsCommand
 * @package Magecom\UnitTest\Command
 */
class GetOutOfStockProductsCommand extends Command
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * GetOutOfStockProductsCommand constructor.
     * @param CollectionFactory $collectionFactory
     * @param string|null $name
     */
    public function __construct(CollectionFactory $collectionFactory, string $name = null)
    {
        parent::__construct($name);
        $this->collectionFactory = $collectionFactory;
    }


    /**
     * @inheritDoc
     * @return void
     */
    protected function configure(): void
    {
        $this->setName("catalog:products:outOfStock:list");
        $this->setDescription("Get the list of out of stock products");
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return void
     * @throws LocalizedException
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->joinField('stock_item', 'cataloginventory_stock_item', 'qty', 'product_id=entity_id', 'qty=0');
        /** @var Product $item */
        foreach ($collection as $item) {
            $output->writeln(sprintf('Product %s is out of stock', $item->getSku()));
        }
    }
}
