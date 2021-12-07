<?php

declare(strict_types=1);

namespace DevBodas\Tests\Functional\Dev\Infrastructure\EntryPoint\Controller;

use Codeception\Util\HttpCode;
use DevBodas\Tests\Functional\Shared\Infrastructure\Codeception\FunctionalCestCase;
use FunctionalTester;

class PostSimulatorCest extends FunctionalCestCase
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

    /**
     * @param FunctionalTester $I
     */
    public function testErrorOnEmptyRequestBody(FunctionalTester $I)
    {
        $simulator = [
            [
                "id" => "e775b66c-5096-11ec-bf63-0242ac130002",
                "number" => null,
                "nameServer" => "nuptic-43",
            ]
        ];
        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . self::TOKEN);
        $I->sendPost('v1/simulator', $simulator);
        $I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY);
    }

    /**
     * @param FunctionalTester $I
     */
    public function testPost(FunctionalTester $I)
    {
        $simulator = [
            "id" => "03bd64ba-b257-48bc-8f07-5cde33b4e745",
            "number" =>  51,
            "nameServer" =>  "nuptic-43",
            "direction" =>  "este",
            "route" =>  10,
            "attempts" => 1
        ];

        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->haveHttpHeader('Authorization', 'Bearer ' . self::TOKEN);
        $I->sendPOST('/v1/simulator', $simulator);

        $I->seeResponseIsJson();
        $I->seeResponseCodeIs(HttpCode::CREATED);
    }
}
