<?php

declare(strict_types=1);

namespace DevBodas\Dev\Infrastructure\Repository\Persistence;

use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use Predis\Client;

class RedisSimulatorRepository implements CacheSimulatorRepository
{
    private Client $client;

    public function __construct()
    {
        $this->client = new Client(
            [
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
            'password' => 'bodas'
            ]
        );
    }

    /**
     * @inheritDoc
     */
    public function find(string $key, string $field): ?string
    {
        return $this->client->hget($key, $field);
    }

    /**
     * @inheritDoc
     */
    public function create(string $key, string $field , string $content): void
    {
        $this->client->hset($key, $field, $content);
    }

    /**
     * @inheritDoc
     */
    public function log(string $key, string $content): void
    {
        $this->client->set($key, $content);
    }

    /**
     * @inheritDoc
     */
    public function findAll(string $key): array
    {
        return $this->client->hvals($key);
    }
}
