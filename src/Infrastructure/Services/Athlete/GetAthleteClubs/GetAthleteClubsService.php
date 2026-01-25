<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Athlete\GetAthleteClubs;

use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\Athlete\GetAthleteClubs\ClubDTO;
use App\Domain\Services\Athlete\GetAthleteClubs\GetAthleteClubsServiceInterface;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Mappers\Activity\SportTypeToActivitySportTypeMapper;
use App\Infrastructure\Providers\Strava\StravaProvider;

final readonly class GetAthleteClubsService implements GetAthleteClubsServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
        private SportTypeToActivitySportTypeMapper $toActivitySportTypeMapper,
    ) {}

    public function get(string $athleteAccessToken): array
    {
        try {
            $result = [];
            $responseData = $this->stravaProvider->withToken($athleteAccessToken)->get(path: 'athlete/clubs');

            foreach ($responseData as $club) {
                if (!$club->private) {
                    continue;
                }

                $clubResponseData = $this->stravaProvider->withToken($athleteAccessToken)->get(path: 'clubs/' . $club->id);
                $result[] = new ClubDTO(
                    id: $clubResponseData->id,
                    name: $clubResponseData->name,
                    sportTypes: \array_map(fn(string $sportType) => $this->toActivitySportTypeMapper->map(
                        sportType: $sportType,
                    ), $clubResponseData->activity_types),
                    description: $clubResponseData->description,
                    ownerExternalId: $clubResponseData?->owner_id ?? null,
                );
            }

            return $result;
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }
    }
}
