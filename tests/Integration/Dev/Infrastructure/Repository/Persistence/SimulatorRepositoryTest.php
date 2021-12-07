<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Dev\Infrastructure\Repository\Persistence;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\ValueObject\Id;
use DevBodas\Shared\Domain\Criteria\Criteria;
use DevBodas\Shared\Domain\Criteria\Filters;
use DevBodas\Tests\Integration\Dev\Infrastructure\Repository\PhpUnit\ModuleIntegrationTestCase;
use DevBodas\Tests\Mother\Dev\Domain\Entity\SimulatorMother;

class SimulatorRepositoryTest extends ModuleIntegrationTestCase
{
    public function testFindAndCreate()
    {
        $simulator = SimulatorMother::random();
        $this->simulatorRepository()->create($simulator);

        $filters = ['id' => $simulator->id()->value(),'number' => $simulator->number()];
        $criteria = Criteria::create(Filters::fromValues($filters));
        $createdSimulators = $this->simulatorRepository()->findBy($criteria);

        foreach ($createdSimulators as $createdSimulator) {
            $this->assertIsObject($createdSimulator);
            $this->assertInstanceOf(Simulator::class, $createdSimulator);

            $this->assertInstanceOf(Id::class, $createdSimulator->id());
            $this->assertIsString($createdSimulator->name());
            $this->assertIsString($createdSimulator->direction());
            $this->assertIsString($createdSimulator->date());
            $this->assertIsInt($createdSimulator->number());
            $this->assertIsInt($createdSimulator->route());

            $this->assertEquals($createdSimulator->id(), $simulator->id());
            $this->assertEquals($createdSimulator->name(), $simulator->name());
            $this->assertEquals($createdSimulator->direction(), $simulator->direction());
            $this->assertEquals($createdSimulator->date(), $simulator->date());
            $this->assertEquals($createdSimulator->number(), $simulator->number());
            $this->assertEquals($createdSimulator->route(), $simulator->route());
        }
    }

}
