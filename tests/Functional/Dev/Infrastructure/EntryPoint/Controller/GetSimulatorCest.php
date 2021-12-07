<?php

declare(strict_types=1);

namespace DevBodas\Tests\Functional\Dev\Infrastructure\EntryPoint\Controller;

use Codeception\Util\HttpCode;
use DevBodas\Tests\Functional\Shared\Infrastructure\Codeception\FunctionalCestCase;
use FunctionalTester;

class GetSimulatorCest extends FunctionalCestCase
{
    private const TOKEN = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyb2wiOiJhZG1pbiIsImV4cCI6MTgwNjMwNjUyMH0.-wz9SQstNzcX1QdzppCWwRzYvAOjba5XrbeQuGe44Nc';

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

    public function testErrorWhenUnauthorizedRole(FunctionalTester $I)
    {
        // phpcs:ignore Generic.Files.LineLength -- JWT cannot be shortened
        $jwtRoleGuest = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJyb2wiOiJndWVzdCIsImV4cCI6MTgwNjMwNjUyMH0.teAzg9HalGvJnGPcNWYGY7vTWZtbcmoCePJEEUwAPHY';
        $I->haveHttpHeader('Authorization', 'Bearer ' . $jwtRoleGuest);
        $I->sendPost('v1/simulator', '');
        $I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
    }

    public function testNotFound(FunctionalTester $I){
        $I->haveHttpHeader('Authorization', 'Bearer ' . self::TOKEN);
        $I->sendGet('v1/simulator/023b5652-c1c0-33ad-8cde-84f6aeae84e6');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::NOT_FOUND);
    }

    public function testGet(FunctionalTester $I){
        $I->haveHttpHeader('Authorization', 'Bearer ' . self::TOKEN);
        $I->sendGet('v1/simulator/03bd64ba-b257-48bc-8f07-5cde33b4e745');
        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseMatchesJsonType(
            [
                'status' => 'integer',
                'data' => [
                    0 => [
                        'id' => 'string',
                        'name' => 'string',
                        'number' => 'integer',
                        'direction' => 'string',
                        'route' => 'integer'
                    ]
                ]
            ]
        );
    }
}
