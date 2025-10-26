<?php

declare(strict_types=1);

namespace App\Domain\ValueObjects;

final readonly class TokenVO
{
    public function __construct(
        private string $token,
        private \DateTimeImmutable $expiresAt,
    ) {
        if (empty($this->token)) {
            throw new \InvalidArgumentException('Access token cannot be empty');
        }
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }
}
