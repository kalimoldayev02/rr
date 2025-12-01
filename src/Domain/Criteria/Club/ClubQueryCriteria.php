<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Club;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\SportTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class ClubQueryCriteria implements ClubCriteriaInterface
{
    /**
     * @param ?UuidInterface[] $ids
     * @param ?int[] $externalIds
     * @param ?SportTypeEnum[] $sportTypes
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $externalIds = null,
        public ?array $sportTypes = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
