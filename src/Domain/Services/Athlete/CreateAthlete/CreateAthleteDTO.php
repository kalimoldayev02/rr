<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\CreateAthlete;

use App\Domain\Enums\User\UserGenderEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateAthleteDTO
{
    public function __construct(
        public UuidInterface $id,
        public int $externalId,
        public string $firstname,
        public string $lastname,
        public UserGenderEnum $gender,
    ) {}
}
