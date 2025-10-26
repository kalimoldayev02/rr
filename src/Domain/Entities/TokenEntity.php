<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\Token\TokenTypeEnum;
use Ramsey\Uuid\UuidInterface;

final class TokenEntity
{
    public function __construct(
        private UuidInterface $id,
        private UuidInterface $userId,
        private string $token,
        private TokenTypeEnum $type,
        private \DateTimeImmutable $expiresAt,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getUserId(): UuidInterface
    {
        return $this->userId;
    }

    public function setUserId(UuidInterface $userId): void
    {
        $this->userId = $userId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getType(): TokenTypeEnum
    {
        return $this->type;
    }

    public function setType(TokenTypeEnum $type): void
    {
        $this->type = $type;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function isExpired(): bool
    {
        return $this->expiresAt < new \DateTimeImmutable();
    }
}
