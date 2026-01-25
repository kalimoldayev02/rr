<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Aggregates\EventAggregate;
use App\Domain\Collections\EventCollection;
use App\Domain\Criteria\Event\EventCriteriaInterface;
use App\Domain\Exceptions\Event\EventNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface EventRepositoryInterface
{
    public function create(EventAggregate $eventAggregate): void;

    /**
     * @throws EventNotFoundException
     */
    public function update(EventAggregate $eventAggregate): void;

    /**
     * @throws EventNotFoundException
     */
    public function delete(EventAggregate $eventAggregate): void;

    /**
     * @throws EventNotFoundException
     */
    public function getById(UuidInterface $id): EventAggregate;

    public function getByCriteria(EventCriteriaInterface $criteria): EventCollection;
}
