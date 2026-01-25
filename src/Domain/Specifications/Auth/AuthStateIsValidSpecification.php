<?php

declare(strict_types=1);

namespace App\Domain\Specifications\Auth;

use App\Domain\Repositories\AuthStateRepositoryInterface;

final readonly class AuthStateIsValidSpecification
{
    public function __construct(
        private AuthStateRepositoryInterface $authStateRepository,
    ) {}

    public function isSatisfiedBy(string $state): bool
    {
        return $this->authStateRepository->exists($state);
    }
}
