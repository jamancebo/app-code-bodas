<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\DataTransformer;

use DevBodas\Dev\Domain\Entity\Simulator;
use DevBodas\Dev\Domain\ValueObject\Id;
use Exception;

class SimulatorToArray
{
    /**
     * @param  Simulator $Simulator
     * @return array
     */
    public function transform(Simulator $Simulator): array
    {
        return [
            'id' => $Simulator->id()->value(),
            'name' => $Simulator->name(),
            'number' => $Simulator->number(),
            'direction' => $Simulator->direction(),
            'route' => $Simulator->route(),
            'date' => $Simulator->date(),
            'attempts' => $Simulator->attempts()
        ];
    }

    /**
     * @param  array $data
     * @return Simulator
     * @throws Exception
     */
    public function reverseTransform(array $data): Simulator
    {
        return Simulator::instantiate(
            Id::fromString($data['id']),
            $data['name'],
            $data['number'],
            $data['direction'],
            $data['route'],
            $data['date'],
            $data['attempts']
        );
    }
}
