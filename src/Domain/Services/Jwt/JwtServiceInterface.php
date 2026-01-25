<?php

declare(strict_types=1);

namespace App\Domain\Services\Jwt;

use App\Domain\Entities\AccessTokenEntity;
use Ramsey\Uuid\UuidInterface;

interface JwtServiceInterface
{
    public function generateAccessToken(UuidInterface $userId): AccessTokenEntity;

    public function decodeAccessToken(string $accessToken): AccessTokenEntity;
}
