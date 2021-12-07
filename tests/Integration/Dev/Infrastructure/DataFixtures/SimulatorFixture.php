<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Dev\Infrastructure\DataFixtures;


use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\Repository\SimulatorRepository;
use DevBodas\Tests\Mother\Dev\Domain\ValueObject\IdMother;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class SimulatorFixture implements FixtureInterface
{
    public const ID = '023b5652-c1c0-33ad-8cde-84f6aeae84e1';
    private const points = ["este","sur","norte","oeste"];
    /**
     * @var SimulatorRepository
     */
    private SimulatorRepository $repository;

    /**
     * @param SimulatorRepository $repository
     */
    public function __construct(SimulatorRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create('es_ES');
        $simulator = Simulator::instantiate(
            IdMother::random(),
            'NUPTIC-43',
            $faker->numberBetween(1,60),
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            0
        );


        $this->repository->create($simulator);
    }
}
