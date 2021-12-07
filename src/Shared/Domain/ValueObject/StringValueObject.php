<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\ValueObject;

class StringValueObject
{
    /**
     * @var string
     */
    protected $value;

    /**
     * @param string $value
     */
    protected function __construct(string $value)
    {
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return $this->value();
    }

    /**
     * @param  string|null $value
     * @return static|null
     */
    public static function fromString(?string $value): ?self
    {
        if (is_null($value)) {
            return null;
        }

        return new static($value);
    }

    /**
     * @param  StringValueObject|null $other
     * @return bool
     */
    public function equals(?StringValueObject $other): bool
    {
        if (!isset($other)) {
            return false;
        }

        return $this->value() === $other->value();
    }

    /**
     * @return string
     */
    public function capitalize(): string
    {
        return ucwords(strtolower($this->value));
    }
}
