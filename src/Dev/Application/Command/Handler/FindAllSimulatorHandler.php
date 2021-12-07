<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command\Handler;

use DevBodas\Dev\Application\Command\FindSimulator;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use Exception;

class FindSimulatorHandler
{
    private SimulatorRepository $repository;

    /**
     *  FindSimulatorHandler constructor.
     * @param SimulatorRepository $repository
     */
    public function __construct(SimulatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param FindSimulator $command
     * @return array
     * @throws Exception
     */
    public function handle(FindSimulator $command): array
    {
        $user = $this->repository->find(
            Id::fromString($command->id())
        );

        if ($user === null) {
            throw new Exception("No User found", 404);
        }

        if ($user->deletedAt() !== null) {
            throw new Exception("User deleted", 404);
        }

        return $user;
    }
}
