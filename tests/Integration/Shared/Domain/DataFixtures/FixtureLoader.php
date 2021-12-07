<?php

declare(strict_types=1);

namespace DevBodas\Tests\Integration\Shared\Domain\DataFixtures;

interface FixtureLoader
{
    public function loadFixtures();
    public function purge();
}
