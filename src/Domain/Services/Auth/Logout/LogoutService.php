<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Logout;

use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\Services\Jwt\JwtServiceInterface;
use App\Domain\Services\Auth\DeleteExpiredTokens\DeleteExpiredTokensService;

final readonly class LogoutService
{
    public function __construct(
        private JwtServiceInterface $jwtService,
        private AccessTokenRepositoryInterface  $accessTokenRepository,
        private DeleteExpiredTokensService $removeExpiredTokensService,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {}

    public function logout(LogoutDTO $logoutData): void
    {
        $accessTokenEntity = $this->jwtService->decodeAccessToken($logoutData->accessToken);
        $this->accessTokenRepository->revoke($accessTokenEntity);
        $refreshTokenCollection = $this->refreshTokenRepository->getByCriteria(new RefreshTokenQueryCriteria(
            tokens: [$logoutData->refreshToken],
        ));
        $this->removeExpiredTokensService->delete($accessTokenEntity->getUserId());

        /** @var RefreshTokenEntity $refreshTokenEntity */
        foreach ($refreshTokenCollection->toArray() as $refreshTokenEntity) {
            $this->refreshTokenRepository->delete($refreshTokenEntity);
        }
    }
}
