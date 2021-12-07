<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Dev\Infrastructure\Repository\PhpUnit;

use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Tests\Integration\Shared\Infrastructure\PhpUnit\IntegrationTestCase;

class ModuleIntegrationTestCase extends IntegrationTestCase
{
    private SimulatorRepository $simulatorRepository;
    private CacheSimulatorRepository $cacheSimulatorRepository;
    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->loadFixtures();
    }

    /**
     * @return void
     * @throws \Doctrine\DBAL\Exception
     */
    public function tearDown(): void
    {
        parent::tearDown();
        $this->purge();
    }

    /**
     * @return SimulatorRepository
     */
    public function simulatorRepository(): SimulatorRepository
    {
        if (empty($this->simulatorRepository)) {
            return $this->service(SimulatorRepository::class);
        }
    }

    /**
     * @return CacheSimulatorRepository
     */
    public function cacheSimulatorRepository(): CacheSimulatorRepository
    {
        if (empty($this->cacheSimulatorRepository)) {
            return $this->service(CacheSimulatorRepository::class);
        }
    }
}
