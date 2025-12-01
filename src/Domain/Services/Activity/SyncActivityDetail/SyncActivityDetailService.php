<?php

declare(strict_types=1);

namespace App\Domain\Services\Activity\SyncActivityDetail;

use App\Domain\Aggregates\ActivityAggregate;
use App\Domain\Collections\ActivityLapCollection;
use App\Domain\Collections\ActivitySplitCollection;
use App\Domain\Entities\ActivityLapEntity;
use App\Domain\Entities\ActivitySplitEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\Athlete\OAuthTokenNotFoundException;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Services\OAuthToken\EnsureFreshOAuthToken\EnsureFreshOAuthTokenService;
use App\Domain\ValueObjects\IdVO;

final readonly class SyncActivityDetailService
{
    public function __construct(
        private ActivityRepositoryInterface $activityRepository,
        private GetActivityDetailExternalServiceInterface $getDetailService,
        private EnsureFreshOAuthTokenService $ensureFreshOAuthTokenService,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function sync(ActivityAggregate $activityAggregate): void
    {
        $athleteEntity = $this->athleteRepository->getById($activityAggregate->getAthleteId());

        if (!$oAuthTokenEntity = $athleteEntity->getOAuthTokens()->getByProvider(OAuthTokenProviderEnum::strava)) {
            throw new OAuthTokenNotFoundException();
        }
        if ($oAuthTokenEntity->isExpired()) {
            $oAuthTokenEntity = $this->ensureFreshOAuthTokenService->ensure($oAuthTokenEntity);
            $athleteEntity->getOAuthTokens()->replace($oAuthTokenEntity);
            $this->athleteRepository->update($athleteEntity);
        }
        $activityDetail = $this->getDetailService->get($oAuthTokenEntity->getAccessToken(), $activityAggregate->getExternalId());

        $activityAggregate->setSplits(new ActivitySplitCollection($this->collectSplits($activityDetail->splits)));
        $activityAggregate->setLaps(new ActivityLapCollection($this->collectLaps($activityDetail->laps)));

        $this->activityRepository->update($activityAggregate);
    }

    /**
     * @param SplitDTO[] $splits
     * @return ActivitySplitEntity[]
     */
    private function collectSplits(array $splits): array
    {
        return \array_map(
            fn(SplitDTO $split) => new ActivitySplitEntity(
                id: new IdVO()->getValue(),
                distance: $split->distance,
                movingTime: $split->movingTime,
                elapsedTime: $split->elapsedTime,
                split: $split->split,
            ),
            $splits,
        );
    }

    /**
     * @param LapDTO[] $laps
     * @return ActivityLapEntity[]
     */
    private function collectLaps(array $laps): array
    {
        return \array_map(
            fn(LapDTO $lap) => new ActivityLapEntity(
                id: new IdVO()->getValue(),
                externalId: $lap->id,
                name: $lap->name,
                distance: $lap->distance,
                movingTime: $lap->movingTime,
                elapsedTime: $lap->elapsedTime,
                lapIndex: $lap->lapIndex,
            ),
            $laps,
        );
    }
}
