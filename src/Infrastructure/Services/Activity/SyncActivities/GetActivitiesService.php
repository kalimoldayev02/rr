<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Activity\SyncActivities;

use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\Enums\SportTypeEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\Activity\SyncActivities\ActivityDTO;
use App\Domain\Services\Activity\SyncActivities\GetActivitiesExternalServiceInterface;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;

final readonly class GetActivitiesService implements GetActivitiesExternalServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
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
                sportType: $this->mapSportType($activity->sport_type),
                startDate: new \DateTimeImmutable($activity->start_date),
                summaryPolyline: $activity->map?->summary_polyline ?? null,
            ),
            $responseData,
        );
    }

    private function mapSportType(string $sportType): SportTypeEnum
    {
        return match ($sportType) {
            'AlpineSki' => SportTypeEnum::alpineSki,
            'BackcountrySki' => SportTypeEnum::backcountrySki,
            'Badminton' => SportTypeEnum::badminton,
            'Canoeing' => SportTypeEnum::canoeing,
            'Crossfit' => SportTypeEnum::crossfit,
            'EBikeRide' => SportTypeEnum::eBikeRide,
            'Elliptical' => SportTypeEnum::elliptical,
            'EMountainBikeRide' => SportTypeEnum::eMountainBikeRide,
            'Golf' => SportTypeEnum::golf,
            'GravelRide' => SportTypeEnum::gravelRide,
            'Handcycle' => SportTypeEnum::handcycle,
            'HighIntensityIntervalTraining' => SportTypeEnum::highIntensityIntervalTraining,
            'Hike' => SportTypeEnum::hike,
            'IceSkate' => SportTypeEnum::iceSkate,
            'InlineSkate' => SportTypeEnum::inlineSkate,
            'Kayaking' => SportTypeEnum::kayaking,
            'Kitesurf' => SportTypeEnum::kitesurf,
            'MountainBikeRide' => SportTypeEnum::mountainBikeRide,
            'NordicSki' => SportTypeEnum::nordicSki,
            'Pickleball' => SportTypeEnum::pickleball,
            'Pilates' => SportTypeEnum::pilates,
            'Racquetball' => SportTypeEnum::racquetball,
            'Ride' => SportTypeEnum::ride,
            'RockClimbing' => SportTypeEnum::rockClimbing,
            'RollerSki' => SportTypeEnum::rollerSki,
            'Rowing' => SportTypeEnum::rowing,
            'Run' => SportTypeEnum::run,
            'Sail' => SportTypeEnum::sail,
            'Skateboard' => SportTypeEnum::skateboard,
            'Snowboard' => SportTypeEnum::snowboard,
            'Snowshoe' => SportTypeEnum::snowshoe,
            'Soccer' => SportTypeEnum::soccer,
            'Squash' => SportTypeEnum::squash,
            'StairStepper' => SportTypeEnum::stairStepper,
            'StandUpPaddling' => SportTypeEnum::standUpPaddling,
            'Surfing' => SportTypeEnum::surfing,
            'Swim' => SportTypeEnum::swim,
            'TableTennis' => SportTypeEnum::tableTennis,
            'Tennis' => SportTypeEnum::tennis,
            'TrailRun' => SportTypeEnum::trailRun,
            'Velomobile' => SportTypeEnum::velomobile,
            'VirtualRide' => SportTypeEnum::virtualRide,
            'VirtualRow' => SportTypeEnum::virtualRow,
            'VirtualRun' => SportTypeEnum::virtualRun,
            'Walk' => SportTypeEnum::walk,
            'WeightTraining' => SportTypeEnum::weightTraining,
            'Wheelchair' => SportTypeEnum::wheelchair,
            'Windsurf' => SportTypeEnum::windsurf,
            'Workout' => SportTypeEnum::workout,
            'Yoga' => SportTypeEnum::yoga,
            default => throw new \InvalidArgumentException("Unknown sport type: {$sportType}"),
        };
    }
}
