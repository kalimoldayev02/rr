<?php

declare(strict_types=1);

namespace App\Domain\Criteria\OAuthToken;

use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use Ramsey\Uuid\UuidInterface;

final readonly class OAuthTokenQueryCriteria implements OAuthTokenCriteriaInterface
{
    /**
     * @param UuidInterface[]|null $userIds
     * @param OAuthTokenProviderEnum[]|null $providers
     */
    public function __construct(
        public ?array $userIds = null,
        public ?array $providers = null,
    ) {}
}
