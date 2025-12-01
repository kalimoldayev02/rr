<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Athlete\GetAthleteClubs;

use App\Domain\Enums\SportTypeEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\Athlete\GetAthleteClubs\ClubDTO;
use App\Domain\Services\Athlete\GetAthleteClubs\GetAthleteClubsServiceInterface;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;

final readonly class GetAthleteClubsService implements GetAthleteClubsServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
    ) {}

    public function get(string $athleteAccessToken): array
    {
        try {
            $responseData = $this->stravaProvider->withToken($athleteAccessToken)->get(path: 'athlete/clubs');

            return \array_map(fn(object $club) => new ClubDTO(
                id: $club->id,
                name: $club->name,
                sportTypes: \array_map(fn(string $sportType) => $this->mapSportType(
                    sportType: $sportType,
                ), $club->activity_types),
                description: $club->description ?? null,
            ), $responseData);
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }
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
