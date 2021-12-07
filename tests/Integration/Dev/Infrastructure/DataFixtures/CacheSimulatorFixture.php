<?php

namespace DevBodas\Tests\Integration\Dev\Infrastructure\DataFixtures;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Tests\Mother\Dev\Domain\ValueObject\IdMother;
use Exception;
use Faker\Factory;
use Predis\Client;

class CacheSimulatorFixture
{
    public const ID = '023b5652-c1c0-33ad-8cde-84f6aeae84e2';
    private const points = ["este","sur","norte","oeste"];
    /**
     * @var CacheSimulatorRepository
     */
    private CacheSimulatorRepository $repository;

    /**
     * @param CacheSimulatorRepository $repository
     */
    public function __construct(CacheSimulatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Client $client
     * @throws Exception
     */
    public function load(Client $client)
    {
        $faker = Factory::create('es_ES');
        $simulator = Simulator::instantiate(
            IdMother::create(self::ID),
            'NUPTIC-43',
            $faker->numberBetween(1,60),
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            $faker->numberBetween(0,1)
        );

        $this->repository->create(
            $simulator->id()->value(),
            $simulator->number(),
            json_encode($simulator)
        );
    }

    /**
     * @param Client $client
     */
    public function purge(Client $client) {
        $client->del(self::ID);
    }
}
