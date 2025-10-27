<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\CreateToken;

use App\Domain\Entities\TokenEntity;
use App\Domain\Repositories\TokenRepositoryInterface;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateTokenService
{
    public function __construct(
        private TokenRepositoryInterface $tokenRepository,
    ) {}

    public function create(CreateTokenDTO $createToken): void
    {
        $this->tokenRepository->create(new TokenEntity(
            id: new IdVO()->getValue(),
            userId: $createToken->userId,
            token: $createToken->tokenVO->getToken(),
            type: $createToken->type,
            expiresAt: $createToken->tokenVO->getExpiresAt(),
        ));
    }
}
