<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\EntryPoint\Controller;

use DevBodas\Dev\Domain\Service\JWTDecoder;
use Exception;
use Symfony\Component\HttpFoundation\Request;

abstract class JwtAuthorizedController
{
    protected JWTDecoder $jwtDecoder;

    /**
     * @param JWTDecoder $jwtDecoder
     */
    public function __construct(
        JWTDecoder $jwtDecoder
    ) {
        $this->jwtDecoder = $jwtDecoder;
    }

    /**
     * @param Request $request
     * @return string|null
     */
    protected function getToken(Request $request): ?string
    {
        if (
            !$request->headers->has('Authorization')
            || 0 !== strpos($request->headers->get('Authorization'), 'Bearer ')
        ) {
            return null;
        }

        $authorizationHeader = $request->headers->get('Authorization');
        return substr($authorizationHeader, 7);
    }

    /**
     * @param string $role
     * @param Request $request
     * @return boolean
     */
    protected function isAuthorised(string $role, Request $request): bool
    {
        try {
            $jwtData = $this->jwtDecoder->decode($this->getToken($request) ?? '');
        } catch (Exception $e) {
            return false;
        }

        if (!$this->jwtDecoder->isAuthorized($role, $jwtData)) {
            return false;
        }

        return true;
    }
}
