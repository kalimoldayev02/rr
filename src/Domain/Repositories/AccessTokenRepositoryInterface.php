<?php

declare(strict_types=1);

namespace App\Domain\Repositories;

use App\Domain\Entities\AccessTokenEntity;
use Ramsey\Uuid\UuidInterface;

interface AccessTokenRepositoryInterface
{
    public function isRevoked(UuidInterface $id): bool;

    public function revoke(AccessTokenEntity $accessTokenEntity): void;

    public function generate(UuidInterface $userId): AccessTokenEntity;
}
