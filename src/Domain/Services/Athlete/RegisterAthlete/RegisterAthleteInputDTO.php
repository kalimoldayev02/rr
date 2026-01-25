<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\RegisterAthlete;

final readonly class RegisterAthleteInputDTO
{
    public function __construct(
        public string $state,
        public string $code,
        public string $email,
        public string $password,
    ) {}
}
