<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Club;

use App\Domain\Enums\Club\SportTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class ClubQueryCriteria implements ClubCriteriaInterface
{
    /**
     * @param ?UuidInterface[] $ids
     * @param ?int[] $externalIds
     * @param ?SportTypeEnum[] $sportTypes
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $externalIds = null,
        public ?array $sportTypes = null,
    ) {}
}
