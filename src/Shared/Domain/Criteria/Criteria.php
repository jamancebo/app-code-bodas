<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Criteria;

class Criteria
{

    private $filters;
    private $orders;
    private $offset;
    private $limit;

    /**
     * @param Filters|null $filters
     * @param Orders|null  $orders
     * @param int|null     $offset
     * @param int|null     $limit
     */
    private function __construct(
        ?Filters $filters = null,
        ?Orders $orders = null,
        ?int $offset = null,
        ?int $limit = null
    ) {
        if ($filters === null) {
            $filters = Filters::fromValues([]);
        }

        if ($orders === null) {
            $orders = Orders::fromValues([]);
        }

        $this->filters = $filters;
        $this->orders = $orders;
        $this->offset = $offset;
        $this->limit = $limit;
    }

    /**
     * @param  Filters|null $filters
     * @param  Orders|null  $orders
     * @param  int|null     $offset
     * @param  int|null     $limit
     * @return Criteria
     */
    public static function create(
        ?Filters $filters = null,
        ?Orders $orders = null,
        ?int $offset = null,
        ?int $limit = null
    ): self {
        return new self(
            $filters,
            $orders,
            $offset,
            $limit
        );
    }

    /**
     * @return bool
     */
    public function hasFilters(): bool
    {
        return $this->filters->count() > 0;
    }

    /**
     * @return array
     */
    public function plainFilters(): array
    {
        return $this->filters->plainFilters();
    }

    /**
     * @return Filters
     */
    public function filters(): Filters
    {
        return $this->filters;
    }

    /**
     * @return bool
     */
    public function hasOrders(): bool
    {
        return $this->orders->count() > 0;
    }

    /**
     * @return array
     */
    public function plainOrders(): array
    {
        return $this->orders->plainOrders();
    }

    /**
     * @return array
     */
    public function stringOrders(): array
    {
        return $this->orders->toStrings();
    }

    /**
     * @return Orders
     */
    public function orders(): Orders
    {
        return $this->orders;
    }

    /**
     * @return int|null
     */
    public function offset(): ?int
    {
        return $this->offset;
    }

    /**
     * @return int|null
     */
    public function limit(): ?int
    {
        return $this->limit;
    }
}
