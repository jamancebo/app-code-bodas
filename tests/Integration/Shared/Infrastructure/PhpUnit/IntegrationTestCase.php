<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Shared\Infrastructure\PhpUnit;

use DevBodas\Tests\Integration\Shared\Infrastructure\DataFixtures\MysqlFixtureLoader;
use DevBodas\Tests\Integration\Shared\Infrastructure\DataFixtures\RedisFixtureLoader;
use Doctrine\DBAL\Exception;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class IntegrationTestCase extends KernelTestCase
{
    private MysqlFixtureLoader $mysqlFixtureLoader;
    private RedisFixtureLoader $redisFixtureLoader;
    /**
     * @return void
     */
    protected function setUp(): void
    {
        self::bootKernel(['environment' => 'test']);
        $this->mysqlFixtureLoader = $this->service(MysqlFixtureLoader::class);
        $this->redisFixtureLoader = $this->service(RedisFixtureLoader::class);
        parent::setUp();
    }

    /**
     * @param string $className
     * @return object
     */
    protected function service($className)
    {
        return self::$container->get($className);
    }

    /**
     * @return void
     */
    protected function loadFixtures(): void
    {
        $this->mysqlFixtureLoader->loadFixtures();
        $this->redisFixtureLoader->loadFixtures();
    }

    /**
     * @return void
     * @throws Exception
     */
    protected function purge(): void
    {
        $this->mysqlFixtureLoader->purge();
        $this->redisFixtureLoader->purge();
    }
}
