<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\Bus;

use DevBodas\Shared\Domain\Bus\CommandBus;
use League\Tactician\CommandBus as LeagueTacticianCommandBus;

class TacticianCommandBus implements CommandBus
{
    /**
     * @var LeagueTacticianCommandBus
     */
    private LeagueTacticianCommandBus $commandBus;

    /**
     * @param LeagueTacticianCommandBus $commandBus
     */
    public function __construct(LeagueTacticianCommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    /**
     * @param  object $command
     * @return mixed
     */
    public function handle($command)
    {
        return $this->commandBus->handle($command);
    }
}
