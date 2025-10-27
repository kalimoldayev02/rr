<?php

declare(strict_types=1);

namespace App\Domain\Services\Token\DeleteExpiredTokensByUserId;

use App\Domain\Criteria\Token\TokenQueryCriteria;
use App\Domain\Entities\TokenEntity;
use App\Domain\Repositories\TokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteExpiredTokensByUserIdService
{
    public function __construct(
        private TokenRepositoryInterface $tokenRepository,
    ) {}

    public function delete(UuidInterface $userId): void
    {
        $tokenCollection = $this->tokenRepository->getByCriteria(new TokenQueryCriteria(
            userIds: [$userId],
            toExpiresAt: new \DateTimeImmutable(),
        ));

        /** @var TokenEntity $tokenEntity */
        foreach ($tokenCollection->toArray() as $tokenEntity) {
            $this->tokenRepository->delete($tokenEntity);
        }
    }
}
