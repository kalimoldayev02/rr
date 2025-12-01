<?php

declare(strict_types=1);

namespace App\Infrastructure\Services\OAuthToken\RefreshOAuthToken;

use App\Domain\Entities\OAuthTokenEntity;
use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use App\Domain\Exceptions\InfrastructureException;
use App\Domain\Services\OAuthToken\RefreshOAuthToken\RefreshOAuthTokenServiceInterface;
use App\Infrastructure\Exceptions\HttpClientProviderException;
use App\Infrastructure\Providers\Strava\StravaProvider;
use App\Infrastructure\Providers\Strava\StravaProviderConfig;

final readonly class RefreshOAuthTokenService implements RefreshOAuthTokenServiceInterface
{
    public function __construct(
        private StravaProvider $stravaProvider,
        private StravaProviderConfig $stravaProviderConfig,
    ) {}

    public function get(OAuthTokenEntity $oAuthTokenEntity): OAuthTokenEntity
    {
        try {
            $response = $this->stravaProvider->post(path: 'oauth/token', data: new \stdClass(), query: [
                'client_id' => $this->stravaProviderConfig->getClientId(),
                'client_secret' => $this->stravaProviderConfig->getClientSecret(),
                'grant_type' => 'refresh_token',
                'refresh_token' => $oAuthTokenEntity->getRefreshToken(),
            ]);
        } catch (HttpClientProviderException $exception) {
            throw new InfrastructureException($exception->getMessage());
        }

        return new OAuthTokenEntity(
            id: $oAuthTokenEntity->getId(),
            provider: OAuthTokenProviderEnum::strava,
            accessToken: $response->access_token,
            refreshToken: '',
            expiresAt: new \DateTimeImmutable()
                ->setTimezone(new \DateTimeZone('Asia/Almaty'))
                ->modify("+$response->expires_in seconds"),
        );
    }
}
