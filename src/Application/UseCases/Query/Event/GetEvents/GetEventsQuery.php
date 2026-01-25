<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Event\GetEvents;

use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\SortQuery;
use Ramsey\Uuid\UuidInterface;

final readonly class GetEventsQuery
{
    /**
     * @param UuidInterface[]|null $ids
     * @param UuidInterface[]|null $clubIds
     * @param UuidInterface[]|null $athleteIds
     * @param SortQuery[]|null $sorts
     */
    public function __construct(
        public ?array $ids = null,
        public ?array $clubIds = null,
        public ?array $athleteIds = null,
        public ?\DateTimeImmutable $fromDate = null,
        public ?\DateTimeImmutable $toDate = null,
        public ?string $title = null,
        public ?array $sorts = null,
        public PaginationQuery $pagination,
    ) {}
}
