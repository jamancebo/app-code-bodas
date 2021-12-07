<?php

declare(strict_types=1);

namespace DevAway\Tests\Unit\KartCompetition\Competition\Application\Command\Handler;

use DevBodas\Dev\Application\Command\Handler\CreateSimulatorHandler;
use DevBodas\Dev\Domain\Exception\SendSequenceWithoutIdError;
use DevBodas\Tests\Mother\Dev\Application\Command\CreateSimulatorMother;
use DevBodas\Tests\Mother\Dev\Domain\Entity\SimulatorMother;
use DevBodas\Tests\Unit\Dev\Infrastructure\PhpUnit\ModuleUnitCase;

class CreateSimulatorTest extends ModuleUnitCase
{
    private CreateSimulatorHandler $handler;

    public function setUp(): void
    {
        parent::setUp();
        $this->handler = new CreateSimulatorHandler($this->simulatorRepository(),$this->cacheSimulatorRepository());
    }

    public function testCreateSimulatorWithWrongParameters()
    {
        $command = CreateSimulatorMother::randomWithWrongParameters();

        $this->expectException(SendSequenceWithoutIdError::class);
        $this->expectExceptionCode(404);

        $this->shouldCacheLogSimulator();

        $this->handler->handle($command);
    }

    public function testCreateSimulatorWithIdNull()
    {
        $command = CreateSimulatorMother::randomWithIdNull();

        $this->shouldCreateSimulator();
        $this->shouldCacheCreateSimulator();


        $simulator = $this->handler->handle($command);

        $this->assertEquals($command->name(), $simulator->name());
        $this->assertEquals($command->number(), $simulator->number());
        $this->assertEquals($command->direction(), $simulator->direction());
        $this->assertEquals($command->route(), $simulator->route());
        $this->assertEquals($command->date(), $simulator->date());
        $this->assertEquals($command->attempts(), $simulator->attempts());
    }

    public function testCreateSimulator()
    {
        $command = CreateSimulatorMother::random();
        $arraySimulator = [SimulatorMother::randomWithId($command->id())];

        $this->shouldFindBySimulator($arraySimulator);
        $this->shouldCreateSimulator();
        $this->shouldCacheCreateSimulator();

        $simulator = $this->handler->handle($command);

        $this->assertEquals($command->id(), $simulator->id());
        $this->assertEquals($command->name(), $simulator->name());
        $this->assertEquals($command->number(), $simulator->number());
        $this->assertEquals($command->direction(), $simulator->direction());
        $this->assertEquals($command->route(), $simulator->route());
        $this->assertEquals($command->date(), $simulator->date());
    }

    public function testFindCacheAndCreateSimulator()
    {
        $command = CreateSimulatorMother::random();
        $arraySimulator = [SimulatorMother::randomWithId($command->id())];

        $this->shouldFindBySimulator($arraySimulator);
        $this->shouldCreateSimulator();
        $this->shouldCacheCreateSimulator();

        $simulator = $this->handler->handle($command);

        $this->assertEquals($command->id(), $simulator->id());
        $this->assertEquals($command->name(), $simulator->name());
        $this->assertEquals($command->number(), $simulator->number());
        $this->assertEquals($command->direction(), $simulator->direction());
        $this->assertEquals($command->route(), $simulator->route());
        $this->assertEquals($command->date(), $simulator->date());
    }
}
