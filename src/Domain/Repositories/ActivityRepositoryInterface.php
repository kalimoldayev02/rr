<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Collections\ActivityCollection;
use App\Domain\Criteria\Activity\ActivityCriteriaInterface;
use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Exceptions\Activity\ActivityNotFoundException;
use Ramsey\Uuid\UuidInterface;

interface ActivityRepositoryInterface
{
    public function create(ActivityAggregate $activityAggregate): void;

    public function update(ActivityAggregate $activityAggregate): void;

    /**
     * @throws ActivityNotFoundException
     */
    public function getById(UuidInterface $id): ActivityAggregate;

    public function getByCriteria(ActivityCriteriaInterface $criteria): ActivityCollection;
}
