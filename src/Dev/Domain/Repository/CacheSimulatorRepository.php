<?php

namespace DevBodas\Dev\Domain\Repository;

use Exception;

interface SimulatoracheRepository
{
    /**
     * @param string $key
     * @throws Exception
     */
    public function find(string $key): void;

    /**
     * @param string $key
     * @param string $content
     * @throws Exception
     */
    public function create(string $key,string $content): void;
}
