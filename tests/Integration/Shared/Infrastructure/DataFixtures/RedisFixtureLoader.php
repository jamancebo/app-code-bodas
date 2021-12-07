<?php

namespace DevBodas\Tests\Integration\Shared\Infrastructure\DataFixtures;

use DevBodas\Dev\Domain\Repository\CacheSimulatorRepository;
use DevBodas\Tests\Integration\Dev\Infrastructure\DataFixtures\CacheSimulatorFixture;
use DevBodas\Tests\Integration\Shared\Domain\DataFixtures\FixtureLoader;
use Exception;
use Predis\Client;

class RedisFixtureLoader implements FixtureLoader
{
    private Client $client;
    private CacheSimulatorRepository $repository;
    private CacheSimulatorFixture $loader;

    /**
     * @param CacheSimulatorRepository $repository
     */
    public function __construct(
        CacheSimulatorRepository $repository
    ) {
        $this->repository = $repository;
        $this->client = new Client([
            'scheme' => 'tcp',
            'host'   => 'redis',
            'port'   => 6379,
            'password' => 'bodas'
        ]);
        $this->loader = new CacheSimulatorFixture($this->repository);
    }

    /**
     * @return void
     * @throws Exception
     */
    public function loadFixtures()
    {
        $this->loader->load($this->client);
    }

    /**
     * @return void
     */
    public function purge()
    {
        $this->loader->purge($this->client);
    }
}
