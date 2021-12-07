<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Dev\Infrastructure\Repository\Persistence;

use DevBodas\Dev\Application\DataTransformer\SimulatorToArray;
use DevBodas\Tests\Integration\Dev\Infrastructure\Repository\PhpUnit\ModuleIntegrationTestCase;
use DevBodas\Tests\Mother\Dev\Domain\Entity\SimulatorMother;

class CacheSimulatorRepositoryTest extends ModuleIntegrationTestCase
{
    public const ID = '023b5652-c1c0-33ad-8cde-84f6aeae84e2';

    public function testFindAndCreate()
    {
        $datatransformer = new SimulatorToArray();
        $simulator = SimulatorMother::randomWithId(self::ID);
        $this->cacheSimulatorRepository()->create(
            self::ID,
            "1",
            json_encode($datatransformer->transform($simulator))
        );

        $findSimulator = json_decode($this->cacheSimulatorRepository()->find(self::ID, "1"), true);

        $this->assertEquals($findSimulator['id'], $simulator->id());
        $this->assertEquals($findSimulator['name'], $simulator->name());
        $this->assertEquals($findSimulator['direction'], $simulator->direction());
        $this->assertEquals($findSimulator['number'], $simulator->number());
        $this->assertEquals($findSimulator['route'], $simulator->route());

    }
}
