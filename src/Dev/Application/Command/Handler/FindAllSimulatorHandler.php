<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command\Handler;

use DevBodas\Dev\Application\Command\FindAllSimulator;
use DevBodas\Dev\Domain\Exception\NotFoundSimulator;
use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Shared\Domain\Criteria\Criteria;
use DevBodas\Shared\Domain\Criteria\Filters;
use Exception;

class FindAllSimulatorHandler
{
    private SimulatorRepository $repository;
    private CacheSimulatorRepository $cacheRepository;
    private const UNIQUESIMULATOR = 'nuptic-43';

    /**
     *  FindSimulatorHandler constructor.
     *
     * @param SimulatorRepository $repository
     */
    public function __construct(SimulatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param  FindAllSimulator $command
     * @return array
     * @throws Exception
     */
    public function handle(FindAllSimulator $command): array
    {
        $filters = ['id' => $command->id(),'name' => self::UNIQUESIMULATOR];
        $criteria = Criteria::create(Filters::fromValues($filters));

        $simulators = $this->repository->findBy($criteria);

        if (empty($simulators)) {
            throw new NotFoundSimulator("No simulator found", 404);
        }

        return $simulators;
    }
}
