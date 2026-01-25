<?php

declare(strict_types=1);

namespace App\Endpoint\Http\Contexts;

use App\Domain\Entities\AccessTokenEntity;
use Ramsey\Uuid\UuidInterface;

final readonly class UserContext
{
    public function __construct(
        private UuidInterface $id,
        private AccessTokenEntity $accessTokenEntity,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getAccessToken(): AccessTokenEntity
    {
        return $this->accessTokenEntity;
    }
}
