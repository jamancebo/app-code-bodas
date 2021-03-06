<?php

declare(strict_types=1);

namespace DevBodas\Tests\Mother\Dev\Domain\ValueObject;

use DevBodas\Dev\Domain\ValueObject\Id;
use Faker\Factory;

class IdMother
{
    /**
     * @param string $id
     * @return Id
     */
    public static function create(string $id): Id
    {
        return Id::fromString($id);
    }

    /**
     * @return Id
     */
    public static function random(): Id
    {
        $faker = Factory::create('es_ES');
        return self::create($faker->uuid());
    }
}
