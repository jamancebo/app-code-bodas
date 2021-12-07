<?php

declare(strict_types=1);

namespace DevBodas\Tests\Unit\Dev\Infrastructure\PhpUnit;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use Mockery\MockInterface;

class ModuleUnitCase extends UnitTestCase
{
    private SimulatorRepository $simulatorRepository;
    private CacheSimulatorRepository $cacheSimulatorRepository;

    /**
     * @return SimulatorRepository|MockInterface
     */
    protected function simulatorRepository(): MockInterface
    {
        if (empty($this->simulatorRepository)) {
            $this->simulatorRepository = $this->mock(SimulatorRepository::class);
        }
        return $this->simulatorRepository;
    }

    /**
     * @return CacheSimulatorRepository|MockInterface
     */
    protected function cacheSimulatorRepository(): MockInterface
    {
        if (empty($this->cacheSimulatorRepository)) {
            $this->cacheSimulatorRepository = $this->mock(CacheSimulatorRepository::class);
        }
        return $this->cacheSimulatorRepository;
    }

    /**
     * @return void
     */
    public function shouldCreateSimulator(): void
    {
        $this->simulatorRepository()
            ->expects('create');
    }

    /**
     * @return void
     */
    public function shouldCacheCreateSimulator(): void
    {
        $this->cacheSimulatorRepository()
            ->expects('create');
    }

    /**
     * @param array $simulator
     * @return void
     */
    public function shouldFindBySimulator(array $simulator): void
    {
        $this->simulatorRepository()
            ->expects('findBy')
            ->andReturn($simulator);
    }

    /**
     * @return void
     */
    public function shouldNotFindAllSimulator(): void
    {
        $this->simulatorRepository()
            ->expects('findBy')
            ->andReturn([]);
    }

    /**
     * @return array
     */
    public function shouldCacheFindAllSimulator(array $simulators): void
    {
        $this->cacheSimulatorRepository()
            ->expects('findAll')
            ->andReturn($simulators);
    }

    /**
     * @return void
     */
    public function shouldCacheNotFindAllSimulator(): void
    {
        $this->cacheSimulatorRepository()
            ->expects('findAll')
            ->andReturn([]);
    }

    /**
     * @return void
     */
    public function shouldCacheLogSimulator(): void
    {
        $this->cacheSimulatorRepository()
            ->expects('log');
    }
}
