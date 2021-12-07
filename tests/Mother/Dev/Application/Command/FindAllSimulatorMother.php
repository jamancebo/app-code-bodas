<?php

declare(strict_types=1);

namespace DevBodas\Tests\Mother\Dev\Application\Command;

use DevBodas\Dev\Application\Command\FindAllSimulator;
use DevBodas\Dev\Domain\ValueObject\Id;

class FindAllSimulatorMother
{

    /**
     *  constructor.
     * @param String $id
     * @return FindAllSimulator
     */
    public static function create($id) {
        return new FindAllSimulator($id);
    }

    /**
     * @return FindAllSimulator
     */
    public static function random()
    {
        return self::create(Id::random()->value());
    }
}
