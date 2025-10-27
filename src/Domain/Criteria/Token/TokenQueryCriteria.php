<?php

declare(strict_types=1);

namespace App\Domain\Criteria\Token;

use App\Domain\Criteria\PaginationCriteria;
use App\Domain\Criteria\SortCriteria;
use App\Domain\Enums\Token\TokenTypeEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class TokenQueryCriteria implements TokenCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $userIds
     * @param string[]|null $tokens
     * @param TokenTypeEnum[]|null $types
     * @param SortCriteria[]|null $sorts
     */
    public function __construct(
        public ?array $userIds = null,
        public ?array $tokens = null,
        public ?array $types = null,
        public ?\DateTimeImmutable $toExpiresAt = null,
        public ?array $sorts = null,
        public ?PaginationCriteria $pagination = null,
    ) {}
}
