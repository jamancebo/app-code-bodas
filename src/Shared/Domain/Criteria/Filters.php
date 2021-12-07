<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Criteria;

use DevBodas\Shared\Domain\Utils\Collection;

final class Filters extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Filter::class;
    }

    /**
     * @param  array $values
     * @return Filters
     */
    public static function fromValues(array $values): self
    {
        $items = [];

        foreach ($values as $field => $value) {
            $items[] = Filter::fromValues($field, $value);
        }

        return new self($items);
    }

    /**
     * @param  Filter $filter
     * @return Filters
     */
    public function add(Filter $filter): self
    {
        return new self(array_merge($this->items(), [$filter]));
    }

    /**
     * @return array
     */
    public function getFilters(): array
    {
        return $this->items();
    }

    /**
     * @return array
     */
    public function plainFilters(): array
    {
        $items = [];

        foreach ($this->items() as $item) {
            $items[$item->field()] = $item->value();
        }

        return $items;
    }
}
