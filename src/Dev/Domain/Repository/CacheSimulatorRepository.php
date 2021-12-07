<?php

namespace DevBodas\Dev\Domain\Repository;

use Exception;

interface CacheSimulatorRepository
{
    /**
     * @param  string $key
     * @param  string $field
     * @return string|null
     * @throws Exception
     */
    public function find(string $key, string $field): ?string;

    /**
     * @param  string $key
     * @param  string $field
     * @param  string $content
     * @throws Exception
     */
    public function create(string $key, string $field , string $content): void;

    /**
     * @param  string $key
     * @param  string $content
     * @throws Exception
     */
    public function log(string $key, string $content): void;

    /**
     * @param  string $key
     * @throws Exception
     */
    public function findAll(string $key): array;

}
