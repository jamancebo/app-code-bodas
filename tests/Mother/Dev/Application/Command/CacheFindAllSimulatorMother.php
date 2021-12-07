<?php

declare(strict_types=1);

namespace DevBodas\Tests\Mother\Dev\Application\Command;

use DevBodas\Dev\Application\Command\CacheFindAllSimulator;
use DevBodas\Dev\Domain\ValueObject\Id;

class CacheFindAllSimulatorMother
{
    /**
     *  constructor.
     * @param String $id
     * @return CacheFindAllSimulator
     */
    public static function create(string $id) {
        return new CacheFindAllSimulator($id);
    }

    /**
     * @return CacheFindAllSimulator
     */
    public static function random()
    {
        return self::create(Id::random()->value());
    }
}
