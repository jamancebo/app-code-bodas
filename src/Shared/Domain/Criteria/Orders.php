<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Criteria;

use DevBodas\Shared\Domain\Utils\Collection;

final class Orders extends Collection
{
    /**
     * @return string
     */
    protected function type(): string
    {
        return Order::class;
    }

    /**
     * @param  array $values
     * @return Orders
     */
    public static function fromValues(array $values): self
    {
        $items = [];

        foreach ($values as $field => $value) {
            $items[] = Order::fromValues($field, $value);
        }

        return new self($items);
    }

    /**
     * @param  array $orders
     * @return Orders
     */
    public static function fromStrings(array $orders): self
    {
        $items = [];
        foreach ($orders as $order) {
            $items[] = Order::fromString($order);
        }

        return new self($items);
    }

    /**
     * @param  Order $order
     * @return Orders
     */
    public function add(Order $order): self
    {
        return new self(array_merge($this->items(), [$order]));
    }

    /**
     * @return array
     */
    public function getOrders(): array
    {
        return $this->items();
    }

    /**
     * @return array
     */
    public function plainOrders(): array
    {
        $items = [];

        foreach ($this->items() as $item) {
            $items[$item->field()] = $item->type();
        }

        return $items;
    }

    /**
     * @return array
     */
    public function toStrings(): array
    {
        $items = [];

        foreach ($this->items() as $item) {
            $items[] = (string) $item;
        }

        return $items;
    }
}
