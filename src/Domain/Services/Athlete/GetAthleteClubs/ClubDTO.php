<?php

declare(strict_types=1);

namespace App\Domain\Services\Athlete\GetAthleteClubs;

use App\Domain\Enums\Club\SportTypeEnum;

final readonly class ClubDTO
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        public string $id,
        public string $name,
        public array $sportTypes,
        public ?string $description,
    ) {}
}
