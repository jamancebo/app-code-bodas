<?php

declare(strict_types=1);

namespace DevBodas\Dev\Domain\Service;

use DevBodas\Shared\Infrastructure\Service\Token\FirebaseJWTDecoder;

class JWTDecoder extends FirebaseJWTDecoder
{
    /**
     * CompanyJWTDecoder constructor.
     * @param string $key
     * @param string|null $encrypt
     */
    public function __construct(string $key, ?string $encrypt = null)
    {
        parent::__construct($key, $encrypt);
    }

    /**
     * @param string $expectedRole
     * @param object|null $decodedJwtData
     * @return bool
     */
    public function isAuthorized(string $expectedRole, ?object $decodedJwtData): bool
    {
        if (is_null($decodedJwtData)) {
            return false;
        }

        if (!isset($decodedJwtData->rol) || !is_string($decodedJwtData->rol) || !isset($decodedJwtData->exp)) {
            return false;
        }

        if (strtolower($expectedRole) != strtolower($decodedJwtData->rol)) {
            return false;
        }

        return true;
    }
}
