<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Activity\GetActivityDetail;

use App\Domain\Enums\Activity\DistanceTypeEnum;
use App\Domain\Enums\Activity\DurationTypeEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\Activity\SyncActivityDetail\ActivityDetailDTO;
use App\Domain\Services\Activity\SyncActivityDetail\GetActivityDetailExternalServiceInterface;
use App\Domain\Services\Activity\SyncActivityDetail\LapDTO;
use App\Domain\Services\Activity\SyncActivityDetail\SplitDTO;
use App\Domain\ValueObjects\DistanceVO;
use App\Domain\ValueObjects\DurationVO;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;

final readonly class GetActivityDetailService implements GetActivityDetailExternalServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
    ) {}

    public function get(string $accessToken, int $id): ActivityDetailDTO
    {
        try {
            $responseData = $this->stravaProvider->withToken($accessToken)
                ->get(path: "activities/$id");
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }

        return new ActivityDetailDTO(
            laps: $this->collectLaps($responseData->laps),
            splits: $this->collectSplits($responseData->splits_metric),
        );
    }

    private function collectLaps(array $externalLaps): array
    {
        return \array_map(
            static fn(object $externalLap) => new LapDTO(
                id: $externalLap->id,
                name: $externalLap->name,
                distance: new DistanceVO(
                    value: $externalLap->distance,
                    type: DistanceTypeEnum::meters,
                ),
                movingTime: new DurationVO(
                    value: $externalLap->moving_time,
                    type: DurationTypeEnum::seconds,
                ),
                elapsedTime: new DurationVO(
                    value: $externalLap->elapsed_time,
                    type: DurationTypeEnum::seconds,
                ),
                lapIndex: $externalLap->lap_index,
            ),
            $externalLaps,
        );
    }

    private function collectSplits(array $externalSplits): array
    {
        return \array_map(
            static fn(object $externalSplit) => new SplitDTO(
                distance: new DistanceVO(
                    value: $externalSplit->distance,
                    type: DistanceTypeEnum::meters,
                ),
                movingTime: new DurationVO(
                    value: $externalSplit->moving_time,
                    type: DurationTypeEnum::seconds,
                ),
                elapsedTime: new DurationVO(
                    value: $externalSplit->elapsed_time,
                    type: DurationTypeEnum::seconds,
                ),
                split: $externalSplit->split,
            ),
            $externalSplits,
        );
    }
}
