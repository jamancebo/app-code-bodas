<?php

declare(strict_types=1);

namespace DevBodas\Shared\Domain\Event;


use DevBodas\Shared\Domain\Aggregate\AggregateId;

interface DomainEvent
{
    /**
     * @return AggregateId
     */
    public function getAggregateId(): AggregateId;

    /**
     * @return array
     */
    public function toPrimitives(): array;

    /**
     * @param  array $primitives
     * @return self
     */
    public static function fromPrimitives(array $primitives): self;
}
