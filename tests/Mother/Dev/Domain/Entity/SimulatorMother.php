<?php

declare(strict_types=1);

namespace DevBodas\Tests\Mother\Dev\Domain\Entity;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\ValueObject\Id;
use DevBodas\Tests\Mother\Dev\Domain\ValueObject\IdMother;
use Faker\Factory;

class SimulatorMother
{
    private const points = ["este","sur","norte","oeste"];
    public static function create(
        Id $id,
        String $name,
        Int $number,
        String $direction,
        Int $route,
        string $date,
        Int $attempts
    ): Simulator {
        return Simulator::instantiate($id, $name, $number, $direction, $route,$date,$attempts);
    }

    /**
     * @return Simulator
     */
    public static function random(): Simulator
    {
        $faker = Factory::create('es_ES');
        return self::create(
            IdMother::random(),
            'NUPTIC-43',
            $faker->numberBetween(1,60),
            self::points[$faker->numberBetween(0,3)],
           $faker->numberBetween(10,20),
            $faker->date(),
            $faker->numberBetween(0,1)
        );
    }

    /**
     * @return array
     */
    public static function randomArray(): array
    {
        $faker = Factory::create('es_ES');
        return [
            'id' => IdMother::random()->value(),
            'name' => 'NUPTIC-43',
            'number' =>  $faker->numberBetween(1,60),
            'direction' => self::points[$faker->numberBetween(0,3)],
            'route' => $faker->numberBetween(10,20),
            'date' => $faker->date()
        ];
    }

    /**
     * @param string $id
     * @return Simulator
     */
    public static function randomWithId(string $id): Simulator
    {
        $faker = Factory::create('es_ES');
        return self::create(
            IdMother::create($id),
            'NUPTIC-43',
            $faker->numberBetween(1,60),
            self::points[$faker->numberBetween(0,3)],
            $faker->numberBetween(10,20),
            $faker->date(),
            $faker->numberBetween(0,1)
        );
    }

}
