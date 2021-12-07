<?php

declare(strict_types=1);

namespace DevBodas\Tests\Mother\Dev\Application\Command;

use DevBodas\Dev\Application\Command\CreateSimulator;
use DevBodas\Dev\Domain\ValueObject\Id;
use Faker\Factory;

class CreateSimulatorMother
{
    private const points = ["este","sur","norte","oeste"];

    /**
     *  constructor.
     * @param String|null $id
     * @param String $name
     * @param Int $number
     * @param String $direction
     * @param Int $route
     * @param string $date
     * @param Int $attempts
     * @return CreateSimulator
     */
    public static function create(
        ?String $id,
        String $name,
        Int $number,
        String $direction,
        Int $route,
        string $date,
        int $attempts
    ) {
        return new CreateSimulator($id,$name, $number, $direction, $route,$date,$attempts);
    }

    /**
     * @return CreateSimulator
     */
    public static function random()
    {
        $faker = Factory::create('es_ES');
        return self::create(
            Id::random()->value(),
            'NUPTIC-43',
            $faker->numberBetween(1,60),
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            $attempts = $faker->numberBetween(0,1)
        );
    }

    /**
     * @return CreateSimulator
     */
    public static function randomWithIdNull()
    {
        $faker = Factory::create('es_ES');
        return self::create(
            null,
            'NUPTIC-43',
            1,
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            $attempts = $faker->numberBetween(0,1)
        );
    }

    /**
     * @return CreateSimulator
     */
    public static function randomWithWrongParameters()
    {
        $faker = Factory::create('es_ES');
        return self::create(
            null,
            'NUPTIC-43',
            5,
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            $attempts = $faker->numberBetween(0,1)
        );
    }
}
