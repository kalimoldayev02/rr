<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cache\Repositories;

use App\Domain\Entities\AccessTokenEntity;
use App\Domain\Repositories\AccessTokenRepositoryInterface;
use App\Domain\Services\Jwt\JwtServiceInterface;
use Predis\ClientInterface;
use Ramsey\Uuid\UuidInterface;

final readonly class AccessTokenCacheRepository implements AccessTokenRepositoryInterface
{
    private const string PREFIX = 'access_token:';
    private const string REVOKE_PREFIX = 'revoke_access_token:';

    public function __construct(
        private ClientInterface $client,
        private JwtServiceInterface $jwtService,
    ) {}

    public function isRevoked(UuidInterface $id): bool
    {
        if ($this->client->get(self::REVOKE_PREFIX . $id->toString())) {
            return true;
        }
        return false;
    }

    public function revoke(AccessTokenEntity $accessTokenEntity): void
    {
        $key = self::REVOKE_PREFIX . $accessTokenEntity->getId()->toString();
        $this->client->set($key, '1', 'EX', 60 * 10);
    }

    public function generate(UuidInterface $userId): AccessTokenEntity
    {
        return $this->jwtService->generateAccessToken($userId);
    }
}
