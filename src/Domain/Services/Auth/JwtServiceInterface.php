<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth;

use App\Domain\ValueObjects\TokenVO;
use Ramsey\Uuid\UuidInterface;

interface JwtServiceInterface
{
    public function generateAccessToken(UuidInterface $userId): TokenVO;

    public function validateAccessToken(string $token): array;

    public function getAthleteIdFromToken(string $token): UuidInterface;
}
