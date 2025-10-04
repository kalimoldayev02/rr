<?php

declare(strict_types=1);

namespace App\Domain\DTO\Club;

use App\Domain\Enums\Club\SportTypeEnum;

final readonly class ClubExternalDataDTO
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        public int $externalId,
        public string $name,
        public ?string $description,
        public array $sportTypes,
    ) {}
}
