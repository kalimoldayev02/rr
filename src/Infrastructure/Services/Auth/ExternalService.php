<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Auth;

use App\Domain\DTO\Athlete\AthleteExternalDataDTO;
use App\Domain\DTO\Club\ClubExternalDataDTO;
use App\Domain\Enums\Club\SportTypeEnum;
use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Repositories\AuthStateRepositoryInterface;
use App\Domain\Services\ExternalServiceInterface;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;
use App\Infrastructure\Providers\Strava\StravaProviderConfig;
use Psr\Log\LoggerInterface;

final readonly class ExternalService implements ExternalServiceInterface
{
    public function __construct(
        private LoggerInterface $logger,
        private AuthStateRepositoryInterface $authStateRepository,
        private StravaProviderConfig $stravaProviderConfig,
        private StravaProvider $stravaProvider,
    ) {}

    public function getAuthURL(): string
    {
        $state = $this->authStateRepository->generateState();
        $this->authStateRepository->create($state);

        $query = [
            'client_id' => $this->stravaProviderConfig->getClientId(),
            'redirect_uri' => $this->stravaProviderConfig->getRedirectUri(),
            'response_type' => 'code',
            'scope' => 'read,activity:read_all',
            'state' => $state,
        ];

        return $this->stravaProviderConfig->getUrl() . 'oauth/authorize?' . \http_build_query($query);
    }

    public function exchangeCode(string $code): AthleteExternalDataDTO
    {
        try {
            $response = $this->stravaProvider->post(path: 'oauth/token', data: new \stdClass(), query: [
                'client_id' => $this->stravaProviderConfig->getClientId(),
                'client_secret' => $this->stravaProviderConfig->getClientSecret(),
                'code' => $code,
                'grant_type' => 'authorization_code',
            ]);
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }

        $this->logger->info('Exchange code', ['data' => $response]);

        return new AthleteExternalDataDTO(
            externalId: $response->athlete->id,
            gender: match ($response->athlete->sex) {
                'M' => UserGenderEnum::male,
                'F' => UserGenderEnum::female,
            },
            firstname: $response->athlete->firstname,
            lastname: $response->athlete->lastname,
            accessToken: $response->access_token,
            refreshToken: $response->refresh_token,
        );
    }

    /**
     * @return ClubExternalDataDTO[]
     */
    public function getClubsByToken(string $accessToken): array
    {
        try {
            $responseData = $this->stravaProvider->withToken($accessToken)->get(path: 'athlete/clubs');

            return \array_map(fn(object $club) => new ClubExternalDataDTO(
                externalId: $club->id,
                name: $club->name,
                description: $club->description ?? null,
                sportTypes: \array_map(fn(string $sportType) => $this->mapSportType(
                    sportType: $sportType,
                ), $club->activity_types),
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
