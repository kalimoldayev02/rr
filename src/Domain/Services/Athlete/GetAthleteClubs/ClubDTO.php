<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\GetAthleteClubs;

use App\Domain\Enums\SportTypeEnum;

final readonly class ClubDTO
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        public int $id,
        public string $name,
        public array $sportTypes,
        public ?string $description,
        public ?int $ownerExternalId,
    ) {}
}
