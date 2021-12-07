<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Utils;

use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class Collection implements Countable, IteratorAggregate
{
    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items
     */
    public function __construct(array $items)
    {
        $this->checkTypes($items);

        $this->items = $items;
    }

    /**
     * @return string
     */
    abstract protected function type(): string;

    /**
     * @return ArrayIterator|Traversable
     */
    public function getIterator()
    {
        return new ArrayIterator($this->items());
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->items());
    }

    /**
     * @return array
     */
    public function items(): array
    {
        return $this->items;
    }

    /**
     * @param  int $index
     * @return object
     */
    public function item(int $index): object
    {
        return $this->items()[$index];
    }

    /**
     * @param  array $items
     * @return void
     */
    public function checkTypes(array $items): void
    {
        foreach ($items as $item) {
            $type = $this->type();
            if (!$item instanceof $type) {
                throw new InvalidArgumentException(
                    sprintf('The object <%s> is not an instance of <%s>', $type, get_class($item))
                );
            }
        }
    }

    /**
     * @param  Collection|null $otherCollection
     * @return bool
     */
    public function equals(?Collection $otherCollection): bool
    {
        if (!isset($otherCollection)) {
            return false;
        }

        return $this->items() == $otherCollection->items();
    }
}
