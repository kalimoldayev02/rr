<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivities;

use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Criteria\Activity\ActivityQueryCriteria;
use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Entities\AthleteEntity;
use App\Domain\Enums\Sort\SortDirectionEnum;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\Athlete\OAuthTokenNotFoundException;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Services\OAuthToken\EnsureFreshOAuthToken\EnsureFreshOAuthTokenService;
use App\Domain\ValueObjects\IdVO;

final readonly class SyncActivitiesService
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private EnsureFreshOAuthTokenService $ensureFreshOAuthTokenService,
        private GetActivitiesExternalServiceInterface $syncActivitiesExternalService,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function sync(AthleteEntity $athleteEntity): void
    {
        $activityCollection = $this->activityRepository->getByCriteria(new ActivityQueryCriteria(
            athleteIds: [$athleteEntity->getId()],
            sorts: [new SortCriteria('startDate', SortDirectionEnum::desc)],
            pagination: new PaginationCriteria(
                page: 1,
                pageSize: 1,
            ),
        ));

        if ($activityCollection->isEmpty()) {
            $fromDate = $athleteEntity->getCreateAt();
        } else {
            $fromDate = $activityCollection->first()->getStartDate();
        }

        if (!$oAuthTokenEntity = $athleteEntity->getOAuthTokens()->getByProvider(OAuthTokenProviderEnum::strava)) {
            throw new OAuthTokenNotFoundException();
        }
        if ($oAuthTokenEntity->isExpired()) {
            $oAuthTokenEntity = $this->ensureFreshOAuthTokenService->ensure($oAuthTokenEntity);
            $athleteEntity->getOAuthTokens()->replace($oAuthTokenEntity);
            $this->athleteRepository->update($athleteEntity);
        }

        $activities = $this->syncActivitiesExternalService->get(
            accessToken: $oAuthTokenEntity->getAccessToken(),
            fromDate: $fromDate,
        );

        if ($activities) {
            $this->createActivities($activities, $athleteEntity);
        }
    }

    /**
     * @param ActivityDTO[] $activities
     */
    private function createActivities(array $activities, AthleteEntity $athleteEntity): void
    {
        foreach ($activities as $activity) {
            $this->activityRepository->create(new ActivityAggregate(
                id: new IdVO()->getValue(),
                externalId: $activity->id,
                athleteId: $athleteEntity->getId(),
                name: $activity->name,
                distance: $activity->distance,
                movingTime: $activity->movingTime,
                elapsedTime: $activity->elapsedTime,
                sportType: $activity->sportType,
                startDate: $activity->startDate,
                summaryPolyline: $activity->summaryPolyline,
            ));
        }
    }
}
