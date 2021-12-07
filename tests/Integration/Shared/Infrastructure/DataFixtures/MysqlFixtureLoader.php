<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Shared\Infrastructure\DataFixtures;

use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Tests\Integration\Dev\Infrastructure\DataFixtures\SimulatorFixture;
use DevBodas\Tests\Integration\Shared\Domain\DataFixtures\FixtureLoader;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Loader;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\DBAL\Exception;
use Doctrine\ORM\EntityManager;

class MysqlFixtureLoader implements FixtureLoader
{
    private EntityManager $entityManager;
    private Loader $loader;
    private SimulatorRepository $repository;
    private ORMPurger $purger;

    /**
     * @var ORMExecutor
     */
    private ORMExecutor $executor;

    /**
     * @param EntityManager $entityManager
     * @param SimulatorRepository $repository
     */
    public function __construct(
        EntityManager $entityManager,
        SimulatorRepository $repository
    ) {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
        $this->loader = new Loader();
        $this->loader->addFixture(new SimulatorFixture($this->repository));
        $this->purger = new ORMPurger();
        $this->executor = new ORMExecutor($this->entityManager, $this->purger);
    }

    /**
     * @return void
     */
    public function loadFixtures(): void
    {
        $this->executor->execute($this->loader->getFixtures(), true);
    }

    /**
     * @throws Exception
     */
    public function purge(): void
    {
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS=0');
        $this->executor->purge();
        $this->entityManager->getConnection()->executeQuery('SET FOREIGN_KEY_CHECKS=1');
        $this->entityManager->getConnection()->close();
    }

    /**
     * @return void
     */
    private function addCustomFixtures(): void
    {
        $this->loader->addFixture(
            new SimulatorFixture(
                $this->repository
            )
        );
    }
}
