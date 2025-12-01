<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Activity\GetActivityById;

use App\Application\DTO\Activity\ActivityDTO;
use App\Application\Mappers\Activity\ActivityAggregateToActivityDTOMapper;
use App\Domain\Services\Activity\GetActivityById\GetActivityByIdService;

final readonly class GetActivityByIdQueryHandler
{
    public function __construct(
        private GetActivityByIdService $getActivityByIdService,
        private ActivityAggregateToActivityDTOMapper $toActivityDTOMapper,
    ) {}

    public function handle(GetActivityByIdQuery $query): ActivityDTO
    {
        $activityAggregate = $this->getActivityByIdService->get($query->id);

        return $this->toActivityDTOMapper->map($activityAggregate);
    }
}
