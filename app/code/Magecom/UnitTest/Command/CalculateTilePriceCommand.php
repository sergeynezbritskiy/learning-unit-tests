<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Command;

use Exception;
use Magecom\UnitTest\Model\Tile\Price;
use Magecom\UnitTest\Model\TileRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateTilePriceCommand
 * @package Magecom\UnitTest\Command
 */
class CalculateTilePriceCommand extends Command
{
    const ARGUMENT_SKU = 'sku';
    const ARGUMENT_RADIUS = 'radius';
    /**
     * @var TileRepositoryInterface
     */
    private $tileRepository;
    /**
     * @var Price
     */
    private $tilePrice;

    /**
     * CalculateTilePrice constructor.
     * @param TileRepositoryInterface $tileRepository
     * @param Price $tilePrice
     * @param string|null $name
     */
    public function __construct(TileRepositoryInterface $tileRepository, Price $tilePrice, string $name = null)
    {
        parent::__construct($name);
        $this->tileRepository = $tileRepository;
        $this->tilePrice = $tilePrice;
    }


    /**
     * @inheritDoc
     */
    protected function configure(): void
    {
        $this->setName("magecom:tile:calculate-price");
        $this->setDescription("Calculates tile price for a given radius");
        $this->addArgument(self::ARGUMENT_SKU, InputArgument::REQUIRED, 'SKU');
        $this->addArgument(self::ARGUMENT_RADIUS, InputArgument::REQUIRED, 'Radius.');
        parent::configure();
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     * @throws Exception
     */
    public function execute(InputInterface $input, OutputInterface $output): void
    {
        $sku = $input->getArgument(self::ARGUMENT_SKU);
        $radius = (float)$input->getArgument(self::ARGUMENT_RADIUS);
        try {
            $tile = $this->tileRepository->getBySku($sku);
            $price = $this->tilePrice->calculate($tile, $radius);
            $output->writeln('<info>Price for tile '. $sku .' with radius ' . $radius. ' is ' . $price);
        }catch (NoSuchEntityException $e){
            $output->writeln('<error>'.$e->getMessage().'</error>');
        }
    }
}
