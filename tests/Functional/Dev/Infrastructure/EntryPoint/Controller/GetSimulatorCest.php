<?php

declare(strict_types=1);

namespace DevBodas\Tests\Functional\Dev\Infrastructure\EntryPoint\Controller;

use Codeception\Util\HttpCode;
use DevBodas\Tests\Functional\Shared\Infrastructure\Codeception\FunctionalCestCase;
use FunctionalTester;

class GetSimulatorTest extends FunctionalCestCase
{
    //private const TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyb2wiOiJhZG1pbiIsImV4cCI6MTgwNjMwNjUyMH0.T0EnxMFv95p-n-HTUEmRDlHAJD7YUzXqZpc9YDP2824';

    public function _before(FunctionalTester $I)
    {
        parent::setUp($I);
        $this->purge();
        $this->loadFixtures();
    }

    public function _after(FunctionalTester $I)
    {
        $this->purge();
    }

    public function testGet(FunctionalTester $I){

    }
}
