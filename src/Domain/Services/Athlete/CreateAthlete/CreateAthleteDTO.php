<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\CreateAthlete;

use App\Domain\Collections\ClubIdCollection;
use App\Domain\Enums\User\UserGenderEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateAthleteDTO
{
    public function __construct(
        public UuidInterface $id,
        public string $email,
        public int $externalId,
        public string $firstname,
        public string $lastname,
        public ?UserGenderEnum $gender,
        public string $password,
        public string $oAuthAccessToken,
        public string $oAuthRefreshToken,
        public int $oAuthExpiresIn,
        public ClubIdCollection $clubIds,
    ) {}
}
