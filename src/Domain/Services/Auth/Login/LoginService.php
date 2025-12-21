<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Login;

use App\Domain\Criteria\User\UserQueryCriteria;
use App\Domain\DTO\Token\TokenDTO;
use App\Domain\Entities\UserEntity;
use App\Domain\Exceptions\Auth\InvalidCredentialsException;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Auth\GenerateRefreshToken\GenerateRefreshTokenService;
use App\Domain\Services\Auth\DeleteExpiredTokens\DeleteExpiredTokensService;

final readonly class LoginService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private AccessTokenRepositoryInterface $accessTokenRepository,
        private GenerateRefreshTokenService $generateRefreshTokenService,
        private DeleteExpiredTokensService $deleteExpiredTokensService,
    ) {}

    public function login(LoginDTO $loginData): TokenDTO
    {
        $userCollection = $this->userRepository->getByCriteria(new UserQueryCriteria(
            emails: [$loginData->email],
        ));

        if ($userCollection->isEmpty()) {
            throw new InvalidCredentialsException();
        }

        /** @var UserEntity $userEntity */
        $userEntity = $userCollection->first();
        if (!\password_verify($loginData->password, $userEntity->getPassword())) {
            throw new InvalidCredentialsException();
        }
        $accessTokenEntity = $this->accessTokenRepository->generate($userEntity->getId());
        $refreshTokenEntity = $this->generateRefreshTokenService->generate($userEntity->getId());

        $this->deleteExpiredTokensService->delete($userEntity->getId());

        return new TokenDTO(
            accessTokenEntity: $accessTokenEntity,
            refreshTokenEntity: $refreshTokenEntity,
        );
    }
}
