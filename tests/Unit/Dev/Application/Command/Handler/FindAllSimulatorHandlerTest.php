<?php

namespace DevAway\Tests\Unit\KartCompetition\Competition\Application\Command\Handler;

use DevBodas\Dev\Application\Command\Handler\FindAllSimulatorHandler;
use DevBodas\Dev\Domain\Exception\NotFoundSimulator;
use DevBodas\Tests\Mother\Dev\Application\Command\FindAllSimulatorMother;
use DevBodas\Tests\Mother\Dev\Domain\Entity\SimulatorMother;
use DevBodas\Tests\Unit\Dev\Infrastructure\PhpUnit\ModuleUnitCase;

class FindAllSimulatorHandlerTest extends ModuleUnitCase
{
    private FindAllSimulatorHandler $handler;

    public function setUp(): void
    {
        parent::setUp();
        $this->handler = new FindAllSimulatorHandler($this->simulatorRepository());
    }

    public function testFindAllSimulator()
    {
        $command = FindAllSimulatorMother::random();
        $simulatorMother = [SimulatorMother::random()];

        $this->shouldFindBySimulator($simulatorMother);

        $arraySimulators = $this->handler->handle($command);

        foreach ($arraySimulators as $key => $simulator) {
            $this->assertEquals($simulatorMother[$key]->id(), $simulator->id());
            $this->assertEquals($simulatorMother[$key]->number(), $simulator->number());
            $this->assertEquals($simulatorMother[$key]->direction(), $simulator->direction());
            $this->assertEquals($simulatorMother[$key]->route(), $simulator->route());
            $this->assertEquals($simulatorMother[$key]->date(), $simulator->date());
        }
    }

    public function testNotFindAllSimulator()
    {
        $command = FindAllSimulatorMother::random();
        $this->expectException(NotFoundSimulator::class);
        $this->expectExceptionCode(404);
        $this->shouldNotFindAllSimulator();
        $arraySimulators = $this->handler->handle($command);
        $this->assertEquals([], $arraySimulators);

    }
}
