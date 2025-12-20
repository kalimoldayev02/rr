<?php

declare(strict_types=1);

namespace App\Application\DTO\Athlete;

use App\Application\Enums\User\UserGenderEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class AthleteDTO
{
    public function __construct(
        public UuidInterface $id,
        public string $firstName,
        public string $lastName,
        public array $clubIds,
        public string $email,
        public UserGenderEnum $gender,
        public ?\DateTimeImmutable $birthday = null,
    ) {}
}
