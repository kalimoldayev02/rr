<?php

declare(strict_types=1);

namespace App\Domain\Services\Auth\DeleteExpiredTokens;

use App\Domain\Criteria\RefreshToken\RefreshTokenQueryCriteria;
use App\Domain\Entities\RefreshTokenEntity;
use App\Domain\Repositories\RefreshTokenRepositoryInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class DeleteExpiredTokensService
{
    public function __construct(
        private RefreshTokenRepositoryInterface $refreshTokenRepository,
    ) {}

    public function delete(UuidInterface $userId): void
    {
        $refreshTokenCollection = $this->refreshTokenRepository->getByCriteria(new RefreshTokenQueryCriteria(
            userIds: [$userId],
            toExpiresAt: new \DateTimeImmutable(),
        ));

        /** @var RefreshTokenEntity $refreshTokenEntity */
        foreach ($refreshTokenCollection->toArray() as $refreshTokenEntity) {
            $this->refreshTokenRepository->delete($refreshTokenEntity);
        }
    }
}
