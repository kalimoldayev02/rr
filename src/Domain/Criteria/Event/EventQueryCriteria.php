<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Event;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use Ramsey\Uuid\UuidInterface;

final readonly class EventQueryCriteria implements EventCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $ids
     * @param UuidInterface[]|null $clubIds
     * @param UuidInterface[]|null $athleteIds
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $clubIds = null,
        public ?array $athleteIds = null,
        public ?\DateTimeImmutable $fromDate = null,
        public ?\DateTimeImmutable $toDate = null,
        public ?string $title = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
