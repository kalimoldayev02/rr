<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

use App\Domain\Entities\AthleteEntity;

final readonly class RegisterAthleteOutputDTO
{
    public function __construct(
        public AthleteEntity $athleteEntity,
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
