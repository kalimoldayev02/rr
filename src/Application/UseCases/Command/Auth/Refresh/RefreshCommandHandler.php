<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Auth\Refresh;

use App\Application\DTO\Token\TokenDTO;
use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Exceptions\Auth\TokenExpiredException;
use App\Domain\Exceptions\RefreshToken\RefreshTokenNotFoundException;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;

final readonly class RefreshCommandHandler
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
        private AccessTokenRepositoryInterface $accessTokenRepository,
    ) {}

    public function handle(RefreshCommand $command): TokenDTO
    {
        $refreshTokenCollection = $this->refreshTokenRepository->getByCriteria(new RefreshTokenQueryCriteria(
            tokens: [$command->refreshToken],
        ));

        if ($refreshTokenCollection->isEmpty()) {
            throw new RefreshTokenNotFoundException();
        }

        /** @var RefreshTokenEntity $refreshTokenEntity */
        $refreshTokenEntity = $refreshTokenCollection->first();
        if ($refreshTokenEntity->isExpired()) {
            throw new TokenExpiredException();
        }

        $accessTokenEntity = $this->accessTokenRepository->generate($refreshTokenEntity->getUserId());

        return new TokenDTO(
            accessToken: $accessTokenEntity->getToken(),
            refreshToken: $refreshTokenEntity->getToken(),
        );
    }
}
