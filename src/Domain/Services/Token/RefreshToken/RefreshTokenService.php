<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\RefreshToken;

use App\Domain\Criteria\Token\TokenQueryCriteria;
use App\Domain\DTO\Token\TokenDTO;
use App\Domain\Entities\TokenEntity;
use App\Domain\Enums\Token\TokenTypeEnum;
use App\Domain\Exceptions\Auth\InvalidTokenException;
use App\Domain\Repositories\TokenRepositoryInterface;
use App\Domain\Services\Token\CreateToken\CreateTokenDTO;
use App\Domain\Services\Token\CreateToken\CreateTokenService;
use App\Domain\Services\Token\DeleteExpiredTokensByUserId\DeleteExpiredTokensByUserIdService;
use App\Domain\Services\Token\GenerateAccessToken\GenerateAccessTokenService;

final readonly class RefreshTokenService
{
    public function __construct(
        private TokenRepositoryInterface $tokenRepository,
        private CreateTokenService $createTokenService,
        private DeleteExpiredTokensByUserIdService $deleteExpiredTokensService,
        private GenerateAccessTokenService $generateAccessTokenService,
    ) {}

    public function refresh(string $refreshToken): TokenDTO
    {
        $tokenCollection = $this->tokenRepository->getByCriteria(new TokenQueryCriteria(
            tokens: [$refreshToken],
            types: [TokenTypeEnum::refresh],
        ));

        if ($tokenCollection->isEmpty()) {
            throw new InvalidTokenException('Invalid token');
        }

        /** @var TokenEntity $tokenEntity */
        $tokenEntity = $tokenCollection->first();
        if ($tokenEntity->isExpired()) {
            $this->tokenRepository->delete($tokenEntity);
            throw new InvalidTokenException('Refresh token expired');
        }

        $newAccessTokenVO = $this->generateAccessTokenService->generate($tokenEntity->getUserId());
        $this->deleteExpiredTokensService->delete($tokenEntity->getUserId());

        $this->createTokenService->create(new CreateTokenDTO(
            userId: $tokenEntity->getUserId(),
            type: TokenTypeEnum::access,
            tokenVO: $newAccessTokenVO,
        ));

        return new TokenDTO(
            accessToken: $newAccessTokenVO->getToken(),
            refreshToken: $refreshToken,
        );
    }
}
