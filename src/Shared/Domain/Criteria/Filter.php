<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Criteria;

final class Filter
{

    private $field;
    private $value;

    /**
     * @param string $field
     * @param mixed  $value
     */
    private function __construct(string $field, $value)
    {
        $this->field = $field;
        $this->value = $value;
    }

    /**
     * @param  string $field
     * @param  mixed  $value
     * @return Filter
     */
    public static function fromValues(string $field, $value): self
    {
        return new self($field, $value);
    }

    /**
     * @return string
     */
    public function field(): string
    {
        return $this->field;
    }

    /**
     * @return mixed
     */
    public function value()
    {
        return $this->value;
    }
}
