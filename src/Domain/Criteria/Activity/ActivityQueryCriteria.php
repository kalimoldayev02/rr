<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Activity;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use Ramsey\Uuid\UuidInterface;

final readonly class ActivityQueryCriteria implements ActivityCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $athleteIds
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $athleteIds = null,
        public ?\DateTimeImmutable $fromDate = null,
        public ?\DateTimeImmutable $toDate = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
