<?php

declare(strict_types=1);

namespace App\Domain\Criteria\OAuthToken;

use App\Domain\Enums\Token\OAuthTokenProviderEnum;

final readonly class OAuthTokenQueryCriteria implements OAuthTokenCriteriaInterface
{
    /**
     * @param OAuthTokenProviderEnum[]|null $providers
     */
    public function __construct(
        public ?array $providers = null,
    ) {}
}
