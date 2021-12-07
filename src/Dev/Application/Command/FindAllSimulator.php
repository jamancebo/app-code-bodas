<?php

declare(strict_types=1);

namespace DevBodas\Dev\Application\Command;

class FindSimulator
{
    private string $id;

    /**
     * FindSimulator constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function id(): string
    {
        return $this->id;
    }
}
