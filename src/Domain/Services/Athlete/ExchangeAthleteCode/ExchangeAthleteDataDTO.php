<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\ExchangeAthleteCode;

use App\Domain\Enums\User\UserGenderEnum;

final readonly class ExchangeAthleteDataDTO
{
    public function __construct(
        public string $externalId,
        public UserGenderEnum $gender,
        public string $firstname,
        public string $lastname,
        public string $accessToken,
        public string $refreshToken,
        public int $expiresIn,
    ) {}
}
