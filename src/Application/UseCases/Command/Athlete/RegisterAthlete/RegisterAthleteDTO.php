<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\RegisterAthlete;

final readonly class RegisterAthleteDTO
{
    public function __construct(
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
