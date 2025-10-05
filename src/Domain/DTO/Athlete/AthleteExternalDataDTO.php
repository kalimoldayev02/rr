<?php

declare(strict_types=1);

namespace App\Domain\DTO\Athlete;

use App\Domain\Enums\User\UserGenderEnum;

final readonly class AthleteExternalDataDTO
{
    public function __construct(
        public string $externalId,
        public UserGenderEnum $gender,
        public string $firstname,
        public string $lastname,
        public string $accessToken,
        public string $refreshToken,
    ) {}
}
