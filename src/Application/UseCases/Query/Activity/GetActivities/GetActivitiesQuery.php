<?php

declare(strict_types=1);

namespace App\Application\UseCases\Query\Activity\GetActivities;

use App\Application\UseCases\Query\PaginationQuery;
use App\Application\UseCases\Query\SortQuery;
use Ramsey\Uuid\UuidInterface;

final readonly class GetActivitiesQuery
{
    /**
     * @param UuidInterface[]|null $athleteIds
     * @param SortQuery[]|null $sorts
     */
    public function __construct(
        public ?array $athleteIds = null,
        public ?\DateTimeImmutable $fromDate = null,
        public ?\DateTimeImmutable $toDate = null,
        public ?array $sorts = null,
        public ?PaginationQuery $pagination = null,
    ) {}
}
