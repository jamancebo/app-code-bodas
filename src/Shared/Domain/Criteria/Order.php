<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Criteria;

final class Order
{
    public const ASC = 'ASC';
    public const DESC = 'DESC';

    private $field;
    private $type;

    /**
     * @param string $field
     * @param string $type
     */
    private function __construct(string $field, string $type)
    {
        $this->field = $field;
        $this->type = $type;
    }

    /**
     * @param  string $field
     * @param  string $type
     * @return Order
     */
    public static function fromValues(string $field, string $type): self
    {
        return new self($field, $type);
    }

    /**
     * @param  string $order
     * @return Order
     */
    public static function fromString(string $order): self
    {
        if (strpos($order, '-') !== false) {
            return new self(str_replace('-', '', $order), self::DESC);
        }

        return new self(str_replace('+', '', $order), self::ASC);
    }

    /**
     * @param  string $field
     * @return Order
     */
    public static function createAsc(string $field): self
    {
        return new self($field, self::ASC);
    }

    /**
     * @param  string $field
     * @return Order
     */
    public static function createDesc(string $field): self
    {
        return new self($field, self::DESC);
    }

    /**
     * @return string
     */
    public function field(): string
    {
        return $this->field;
    }

    /**
     * @return string
     */
    public function type(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if ($this->type == self::DESC) {
            return '-' . $this->field;
        }

        return $this->field;
    }
}
