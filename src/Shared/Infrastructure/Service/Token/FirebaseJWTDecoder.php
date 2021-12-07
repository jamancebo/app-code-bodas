<?php

declare(strict_types=1);

namespace DevBodas\Shared\Infrastructure\Service\Token;

use Firebase\JWT\JWT;

class FirebaseJWTDecoder extends TokenJWTAbstract
{
    /** @var string */
    private string $encrypt;

    /**
     * @param string $key
     * @param string|null $encrypt
     */
    public function __construct(string $key, ?string $encrypt = null)
    {
        parent::__construct($key);
        $this->encrypt = $encrypt ?? 'HS256';
    }

    /**
     * @param string $token
     * @return object|null
     */
    public function decode(string $token): ?object
    {
        return JWT::decode($token, $this->key(), [$this->encrypt()]);
    }

    /**
     * @return string|null
     */
    protected function encrypt(): ?string
    {
        return $this->encrypt;
    }
}
