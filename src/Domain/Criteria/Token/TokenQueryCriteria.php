<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Token;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use Ramsey\Uuid\UuidInterface;

final readonly class TokenQueryCriteria implements TokenCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $userIds
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $userIds = null,
        public ?\DateTimeImmutable $toExpiresAt = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
