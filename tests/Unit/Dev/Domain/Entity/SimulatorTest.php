<?php

declare(strict_types=1);

namespace DevBodas\Dev\Unit\Signings\Domain\Entity;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Tests\Mother\Dev\Domain\ValueObject\IdMother;
use DevBodas\Tests\Unit\Dev\Infrastructure\PhpUnit\ModuleUnitCase;
use Faker\Factory;

class SimulatorTest extends ModuleUnitCase
{
    private const points = ["este","sur","norte","oeste"];
    public function testIniciate()
    {
        $faker = Factory::create('es_ES');
        $id = IdMother::random();
        $name = 'NUPTIC-43';
        $number = $faker->numberBetween(1,60);
        $direction = self::points[$faker->numberBetween(0,3)];
        $route = $faker->numberBetween(10,20);
        $date = $faker->date();
        $attempts = $faker->numberBetween(0,1);

        $user = Simulator::instantiate(
            $id,
            $name,
            $number,
            $direction,
            $route,
            $date,
            $attempts
        );

        $this->assertInstanceOf(Simulator::class, $user);
        $this->assertEquals($id, $user->id());
        $this->assertEquals($name, $user->name());
        $this->assertEquals($number, $user->number());
        $this->assertEquals($direction, $user->direction());
        $this->assertEquals($route, $user->route());
        $this->assertEquals($date, $user->date());
    }
}
