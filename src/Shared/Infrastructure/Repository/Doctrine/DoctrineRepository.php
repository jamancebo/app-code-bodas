<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\Repository\Doctrine;

use DevBodas\Shared\Domain\Aggregate\AggregateRoot;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

abstract class DoctrineRepository
{
    /**
     * @var EntityManager
     */
    protected EntityManager $entityManager;

    protected function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return EntityManager
     */
    protected function entityManager(): EntityManager
    {
        return $this->entityManager;
    }

    /**
     * @param AggregateRoot $entity
     */
    protected function persist(AggregateRoot $entity): void
    {
        $this->entityManager()->persist($entity);
        $this->entityManager()->flush();
    }

    /**
     * @param AggregateRoot $entity
     */
    protected function remove(AggregateRoot $entity): void
    {
        $this->entityManager()->remove($entity);
        $this->entityManager()->flush();
    }

    /**
     * @param  $entityClass
     * @return EntityRepository
     */
    protected function repository($entityClass): EntityRepository
    {
        return $this->entityManager->getRepository($entityClass);
    }

}
