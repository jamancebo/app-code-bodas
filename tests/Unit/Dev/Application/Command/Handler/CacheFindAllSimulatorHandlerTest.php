<?php

declare(strict_types=1);

namespace DevAway\Tests\Unit\KartCompetition\Competition\Application\Command\Handler;

use DevBodas\Dev\Application\Command\Handler\CacheFindAllSimulatorHandler;
use DevBodas\Tests\Mother\Dev\Application\Command\CacheFindAllSimulatorMother;
use DevBodas\Tests\Mother\Dev\Domain\Entity\SimulatorMother;
use DevBodas\Tests\Unit\Dev\Infrastructure\PhpUnit\ModuleUnitCase;

class CacheFindAllSimulatorHandlerTest extends ModuleUnitCase
{
    private CacheFindAllSimulatorHandler $handler;

    public function setUp(): void
    {
        parent::setUp();
        $this->handler = new CacheFindAllSimulatorHandler($this->cacheSimulatorRepository());
    }

    public function testCacheFindAllSimulator()
    {
        $command = CacheFindAllSimulatorMother::random();
        $simulatorMother = [json_encode(SimulatorMother::randomArray())];

        $this->shouldCacheFindAllSimulator($simulatorMother);

        $arraySimulators = $this->handler->handle($command);

        foreach ($arraySimulators as $key => $simulator) {
            $this->assertEquals($simulatorMother[$key]->id(), $simulator->name());
            $this->assertEquals($simulatorMother[$key]->number(), $simulator->number());
            $this->assertEquals($simulatorMother[$key]->direction(), $simulator->direction());
            $this->assertEquals($simulatorMother[$key]->route(), $simulator->route());
            $this->assertEquals($simulatorMother[$key]->date(), $simulator->date());
        }
    }

    public function testNotFindAllSimulator()
    {
        $command = CacheFindAllSimulatorMother::random();
        $this->shouldCacheNotFindAllSimulator();
        $arraySimulators = $this->handler->handle($command);
        $this->assertEquals([], $arraySimulators);

    }
}
