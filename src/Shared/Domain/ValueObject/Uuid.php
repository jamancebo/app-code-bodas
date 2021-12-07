<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\ValueObject;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    private function __construct(string $value)
    {
        $this->ensureIsValidUuid($value);

        $this->value = $value;
    }

    /**
     * @param  string $aggregateId
     * @return self
     */
    public static function fromString(string $aggregateId): self
    {
        return new static($aggregateId);
    }

    /**
     * @return self
     */
    public static function random(): self
    {
        return new static(RamseyUuid::uuid4()->toString());
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @param  string $id
     * @return void
     */
    private function ensureIsValidUuid(string $id): void
    {
        if (!RamseyUuid::isValid($id)) {
            throw new InvalidArgumentException(sprintf('<%s> does not allow the value <%s>.', static::class, $id));
        }
    }

    /**
     * @param  Uuid $other
     * @return boolean
     */
    public function equals(Uuid $other): bool
    {
        return $this->value() === $other->value();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }
}
