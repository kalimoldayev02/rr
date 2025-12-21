<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\Athlete\ExchangeAthleteCode;

use App\Domain\Enums\User\UserGenderEnum;
use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Exceptions\TooManyRequestsException;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;
use App\Infrastructure\Providers\Strava\StravaProviderConfig;
use App\Domain\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteCodeInterface;
use App\Domain\Services\Athlete\ExchangeAthleteCode\ExchangeAthleteDataDTO;

final readonly class ExchangeAthleteCodeService implements ExchangeAthleteCodeInterface
{
    public function __construct(
        private StravaProviderConfig $stravaProviderConfig,
        private StravaProvider $stravaProvider,
    ) {}

    /**
     * @throws InvalidTokenException
     * @throws TooManyRequestsException
     * @throws InfrastructureException
     */
    public function exchange(string $code): ExchangeAthleteDataDTO
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

        return new ExchangeAthleteDataDTO(
            externalId: $response->athlete->id,
            gender: match ($response->athlete->sex) {
                'M' => UserGenderEnum::male,
                'F' => UserGenderEnum::female,
            },
            firstname: $response->athlete->firstname,
            lastname: $response->athlete->lastname,
            accessToken: $response->access_token,
            refreshToken: $response->refresh_token,
            expiresIn: $response->expires_in,
        );
    }
}
