<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\GenerateAccessToken;

use App\Domain\Services\Auth\JwtServiceInterface;
use App\Domain\ValueObjects\TokenVO;
use Ramsey\Uuid\UuidInterface;

final readonly class GenerateAccessTokenService
{
    public function __construct(
        private JwtServiceInterface $jwtService,
    ) {}

    public function generate(UuidInterface $userId): TokenVO
    {
        return $this->jwtService->generateAccessToken($userId);
    }
}
