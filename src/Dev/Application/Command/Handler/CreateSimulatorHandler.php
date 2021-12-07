<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command\Handler;

use DateTime;
use DevBodas\Dev\Application\DataTransformer\SimulatorToArray;
use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\Exception\PercentageError;
use DevBodas\Dev\Domain\Exception\SendSequenceWithoutIdError;
use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Dev\Domain\ValueObject\Id;
use DevBodas\Dev\Application\Command\CreateSimulator;
use DevBodas\Shared\Domain\Criteria\Criteria;
use DevBodas\Shared\Domain\Criteria\Filters;
use Exception;

class CreateSimulatorHandler
{
    private SimulatorRepository $repository;
    private CacheSimulatorRepository $cacheRepository;
    private CONST PERCENTAGEERROR = 6;

    /**
     * CreateSimulatorHandler constructor.
     *
     * @param SimulatorRepository      $repository
     * @param CacheSimulatorRepository $cacheRepository
     */
    public function __construct(SimulatorRepository $repository,CacheSimulatorRepository $cacheRepository)
    {
        $this->repository = $repository;
        $this->cacheRepository = $cacheRepository;
    }

    /**
     * @param  CreateSimulator $command
     * @return Simulator
     * @throws SimulatorRepository|Exception
     */
    public function handle(CreateSimulator $command): Simulator
    {
        $id = Id::random();
        $date = new DateTime();
        $dataTransformer = new SimulatorToArray();
        if ($command->id() && $command->id() !== null) {

            $filters = ['id' => $command->id()];
            $criteria = Criteria::create(Filters::fromValues($filters));
            $foundSimulator = $this->repository->findBy($criteria);

            if (!empty($foundSimulator)) {
                $id = $foundSimulator[0]->id();
            }

            if (count($foundSimulator)%(self::PERCENTAGEERROR-1) === 0) {
                if ($command->attempts() === 0) {
                    $this->cacheRepository->log(
                        "Error: " . $date->format('Y-m-d H:i:s'),
                        "Percentage control error"
                    );
                    throw new PercentageError("Percentage control error", 423);
                }
            }

            foreach ($foundSimulator as $simulator) {
                if($simulator->number() === $command->number()) {
                    $this->cacheRepository->log(
                        "Error: " . $date->format('Y-m-d H:i:s'),
                        "Id and sequence repeated"
                    );
                    throw new Exception("Id and sequence repeated", 404);
                }
            }
        } else if ($command->id() == null && $command->number()>1) {
            $this->cacheRepository->log(
                "Error: " . $date->format('Y-m-d H:i:s'),
                "Sequence without Id"
            );
            throw new SendSequenceWithoutIdError("Sequence without Id", 404);

        }

        $simulator = Simulator::instantiate(
            $id,
            $command->name(),
            $command->number(),
            $command->direction(),
            $command->route(),
            $command->date(),
            $command->attempts()
        );

        $this->cacheRepository->create(
            $id->value(),
            (string)$command->number(),
            json_encode($dataTransformer->transform($simulator), JSON_THROW_ON_ERROR)
        );
        $this->repository->create($simulator);

        return $simulator;
    }
}
