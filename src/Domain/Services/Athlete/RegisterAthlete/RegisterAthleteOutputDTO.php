<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

use Ramsey\Uuid\UuidInterface;

final readonly class RegisterAthleteOutputDTO
{
    public function __construct(
        public UuidInterface $athleteId,
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
