<?php

declare(strict_types=1);

namespace DevBodas\Dev\Domain\Repository;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Shared\Domain\Criteria\Criteria;

interface SimulatorRepository
{
    /**
     * @param Simulator $Simulator
     */
    public function create(Simulator $Simulator): void;

    /**
     * @param  Criteria $criteria
     * @return Simulator[]
     */
    public function findBy(Criteria $criteria): array;

    /**
     * @param Simulator $Simulator
     */
    public function update(Simulator $Simulator): void;
}
