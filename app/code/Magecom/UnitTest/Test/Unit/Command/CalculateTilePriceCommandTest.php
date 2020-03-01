<?php

declare(strict_types=1);

namespace Magecom\UnitTest\Test\Unit\Command;

use Exception;
use Magecom\UnitTest\Command\CalculateTilePriceCommand;
use Magecom\UnitTest\Model\Tile;
use Magecom\UnitTest\Model\Tile\Price;
use Magecom\UnitTest\Model\TileRepositoryInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class CalculateTilePriceCommandTest
 * @package Magecom\UnitTest\Test\Unit\Command
 */
class CalculateTilePriceCommandTest extends TestCase
{
    /**
     * @var MockObject|TileRepositoryInterface
     */
    private $tileRepository;
    /**
     * @var MockObject|Price
     */
    private $price;
    /**
     * @var MockObject|InputInterface
     */
    private $input;

    /**
     * @var MockObject|OutputInterface
     */
    private $output;
    /**
     * @var CalculateTilePriceCommand|CalculateTilePriceCommand
     */
    private $command;

    /**
     * @inheritDoc
     * @return void
     */
    protected function setUp(): void
    {
        $this->tileRepository = $this->createMock(TileRepositoryInterface::class);
        $this->price = $this->createMock(Price::class);

        $this->input = $this->createMock(InputInterface::class);
        $this->output = $this->createMock(OutputInterface::class);

        $this->command = new CalculateTilePriceCommand($this->tileRepository, $this->price);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function testValidSkuAndRadius(): void
    {
        $this->input->expects($this->exactly(2))->method('getArgument')->willReturnCallback(function ($argument) {
            if ($argument === 'sku') {
                return 'some_sku';
            } elseif ($argument === 'radius') {
                return 10;
            } else {
                return null;
            }
        });

        $tile = $this->createMock(Tile::class);
        $tile->expects($this->any())->method('getWidth')->willReturn(3);
        $tile->expects($this->any())->method('getLength')->willReturn(2);
        $tile->expects($this->any())->method('getPrice')->willReturn(3);

        $this->tileRepository->expects($this->once())->method('getBySku')->willReturn($tile);
        $this->price->expects($this->once())->method('calculate')->with($tile, 10)->willReturn(15);
        $this->output->expects($this->once())->method('writeln')->with('<info>Price for tile some_sku with radius 10 is 15');

        $this->command->execute($this->input, $this->output);
    }
}
