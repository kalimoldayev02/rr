<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Reference\DistanceReference;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\Activity\DistanceTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class DistanceReferenceQueryCriteria implements DistanceReferenceCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $ids
     * @param DistanceTypeEnum[]|null $distanceTypes
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $ids = null,
        public ?float $fromDistance = null,
        public ?float $toDistance = null,
        public ?array $distanceTypes = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
