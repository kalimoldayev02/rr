<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\GetActivityById;

use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Domain\Services\Activity\SyncActivityDetail\SyncActivityDetailService;
use Ramsey\Uuid\UuidInterface;

final readonly class GetActivityByIdService
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private SyncActivityDetailService $syncActivityDetailService,
    ) {}

    public function get(UuidInterface $id): ActivityAggregate
    {
        $activityAggregate = $this->activityRepository->getById($id);

        if ($activityAggregate->getLaps()->isEmpty() && $activityAggregate->getSplits()->isEmpty()) {
            $this->syncActivityDetailService->sync($activityAggregate);
            $activityAggregate = $this->activityRepository->getById($id);
        }

        return $activityAggregate;
    }
}
