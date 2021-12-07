<?php

declare(strict_types=1);

namespace DevBodas\Dev\Infrastructure\Repository\Persistence;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Shared\Domain\Criteria\Criteria;
use DevBodas\Shared\Infrastructure\Repository\Doctrine\DoctrineRepository;
use Doctrine\ORM\EntityManager;

class MysqlSimulatorRepository extends DoctrineRepository implements SimulatorRepository
{
    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        parent::__construct($entityManager);
    }

    /**
     * @inheritDoc
     */
    public function create(Simulator $simulator): void
    {
        $this->persist($simulator);
    }

    /**
     * @inheritDoc
     */
    public function findBy(Criteria $criteria): array
    {
        return $this->repository(Simulator::class)->findBy(
            $criteria->plainFilters(),
            $criteria->plainOrders(),
            $criteria->limit(),
            $criteria->offset()
        );
    }

    /**
     * @inheritDoc
     */
    public function update(Simulator $simulator): void
    {
        $this->persist($simulator);
    }
}
