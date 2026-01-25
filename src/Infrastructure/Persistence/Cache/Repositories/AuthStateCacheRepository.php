<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\Cache\Repositories;

use App\Domain\Repositories\AuthStateRepositoryInterface;
use Predis\ClientInterface;

final readonly class AuthStateCacheRepository implements AuthStateRepositoryInterface
{
    private const string PREFIX = 'state:';
    private const int TTL = 60 * 10;

    public function __construct(
        private ClientInterface $client,
    ) {}

    public function generateState(): string
    {
        return \bin2hex(\random_bytes(16));
    }

    public function create(string $state): void
    {
        $this->client->set(self::PREFIX . $state, '1', 'EX', self::TTL);
    }

    public function delete(string $state): void
    {
        $this->client->del(self::PREFIX . $state);
    }

    public function exists(string $state): bool
    {
        return $this->client->exists(self::PREFIX . $state) > 0;
    }
}
