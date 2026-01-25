<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Activity\SyncActivities;

use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\Activity\SyncActivities\ActivityDTO;
use App\Domain\Services\Activity\SyncActivities\GetActivitiesExternalServiceInterface;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Mappers\Activity\SportTypeToActivitySportTypeMapper;
use App\Infrastructure\Providers\Strava\StravaProvider;

final readonly class GetActivitiesService implements GetActivitiesExternalServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
        private SportTypeToActivitySportTypeMapper $toActivitySportTypeMapper,
    ) {}

    public function get(string $accessToken, \DateTimeImmutable $fromDate): array
    {
        try {
            $responseData = $this->stravaProvider->withToken($accessToken)
                ->get('athlete/activities', [
                    'after' => $fromDate->getTimestamp(),
                ]);
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }

        return \array_map(
            fn(object $activity) => new ActivityDTO(
                id: $activity->id,
                name: $activity->name,
                distance: new DistanceVO(
                    value: $activity->distance,
                    type: DistanceTypeEnum::meters,
                ),
                movingTime: new DurationVO(
                    value: $activity->moving_time,
                    type: DurationTypeEnum::seconds,
                ),
                elapsedTime: new DurationVO(
                    value: $activity->elapsed_time,
                    type: DurationTypeEnum::seconds,
                ),
                sportType: $this->toActivitySportTypeMapper->map($activity->sport_type),
                startDate: new \DateTimeImmutable($activity->start_date),
                summaryPolyline: $activity->map?->summary_polyline ?? null,
            ),
            $responseData,
        );
    }
}
