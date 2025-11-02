<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Logout;

use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use App\Domain\Services\Auth\DeleteExpiredTokens\DeleteExpiredTokensService;
use App\Domain\Services\Jwt\JwtServiceInterface;

final readonly class LogoutCommandHandler
{
    public function __construct(
        private JwtServiceInterface $jwtService,
        private AccessTokenRepositoryInterface $accessTokenRepository,
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
        private DeleteExpiredTokensService $deleteExpiredTokensService,
    ) {}

    public function handle(LogoutCommand $command): void
    {
        $accessTokenEntity = $this->jwtService->decodeAccessToken($command->accessToken);
        $this->accessTokenRepository->revoke($accessTokenEntity);
        $this->deleteExpiredTokensService->delete(userId: $accessTokenEntity->getUserId());
        $refreshTokens = $this->refreshTokenRepository->getByCriteria(new RefreshTokenQueryCriteria(
            tokens: [$command->refreshToken],
        ));

        /** @var RefreshTokenEntity $refreshTokenEntity */
        foreach ($refreshTokens->toArray() as $refreshTokenEntity) {
            $this->refreshTokenRepository->delete($refreshTokenEntity);
        }
    }
}
