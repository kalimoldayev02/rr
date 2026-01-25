<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\Token\OAuthTokenProviderEnum;
use Ramsey\Uuid\UuidInterface;

final class OAuthTokenEntity
{
    public function __construct(
        private readonly UuidInterface $id,
        private OAuthTokenProviderEnum $provider,
        private string $accessToken,
        private string $refreshToken,
        private \DateTimeImmutable $expiresAt,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getProvider(): OAuthTokenProviderEnum
    {
        return $this->provider;
    }

    public function getAccessToken(): string
    {
        return $this->accessToken;
    }

    public function setAccessToken(string $accessToken): void
    {
        $this->accessToken = $accessToken;
    }

    public function getRefreshToken(): string
    {
        return $this->refreshToken;
    }

    public function setRefreshToken(string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
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
