<?php

declare(strict_types=1);

namespace App\Domain\Services\Club\CreateClub;

use App\Domain\Enums\Club\SportTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateClubDTO
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        public UuidInterface $id,
        public int $externalId,
        public string $name,
        public ?string $description,
        public array $sportTypes,
    ) {}
}
