<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\Login;

use App\Domain\Criteria\User\UserQueryCriteria;
use App\Domain\DTO\Token\TokenDTO;
use App\Domain\Entities\UserEntity;
use App\Domain\Enums\Token\TokenTypeEnum;
use App\Domain\Exceptions\Auth\InvalidCredentialsException;
use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Services\Token\CreateToken\CreateTokenDTO;
use App\Domain\Services\Token\CreateToken\CreateTokenService;
use App\Domain\Services\Token\DeleteExpiredTokensByUserId\DeleteExpiredTokensByUserIdService;
use App\Domain\Services\Token\GenerateAccessToken\GenerateAccessTokenService;
use App\Domain\Services\Token\GenerateRefreshToken\GenerateRefreshTokenService;
use App\Domain\ValueObjects\TokenVO;
use Ramsey\Uuid\UuidInterface;

final readonly class LoginService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private GenerateAccessTokenService $generateAccessTokenService,
        private GenerateRefreshTokenService $generateRefreshTokenService,
        private CreateTokenService $createTokenService,
        private DeleteExpiredTokensByUserIdService $deleteExpiredTokensByUserIdService,
    ) {}

    public function login(LoginInputDTO $login): TokenDTO
    {
        $userCollection = $this->userRepository->getByCriteria(new UserQueryCriteria(
            emails: [$login->email],
        ));

        if ($userCollection->isEmpty()) {
            throw new InvalidCredentialsException('Invalid email or password');
        }

        /** @var UserEntity $userEntity */
        $userEntity = $userCollection->first();

        if (!\password_verify($login->password, $userEntity->getPassword())) {
            throw new InvalidCredentialsException('Invalid email or password');
        }

        $accessTokenVO = $this->generateAccessTokenService->generate($userEntity->getId());
        $refreshTokenVO = $this->generateRefreshTokenService->generate();

        $this->deleteExpiredTokensByUserIdService->delete($userEntity->getId());

        $this->createToken($userEntity->getId(), $accessTokenVO, TokenTypeEnum::access);
        $this->createToken($userEntity->getId(), $refreshTokenVO, TokenTypeEnum::refresh);

        return new TokenDTO(
            accessToken: $accessTokenVO->getToken(),
            refreshToken: $refreshTokenVO->getToken(),
        );
    }

    private function createToken(UuidInterface $userId, TokenVO $tokenVO, TokenTypeEnum $type): void
    {
        $this->createTokenService->create(new CreateTokenDTO(
            userId: $userId,
            type: $type,
            tokenVO: $tokenVO,
        ));
    }
}
