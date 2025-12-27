<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use App\Infrastructure\Persistence\CycleORM\Repositories\RefreshTokenCycleORMRepository;
use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Ramsey\Uuid\UuidInterface;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;

#[Entity(repository: RefreshTokenCycleORMRepository::class, table: 'refresh_tokens')]
#[Uuid7(field: 'id', nullable: false)]
class RefreshTokenCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', name: 'id', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'uuid', name: 'athlete_id')]
        private UuidInterface $athleteId,
        #[Column(type: 'string')]
        private string $token,
        #[Column(type: 'timestamptz', name: 'expires_at', typecast: 'datetime')]
        private \DateTimeImmutable $expiresAt,
        #[Column(type: 'timestamptz', name: 'created_at', typecast: 'datetime')]
        private ?\DateTimeImmutable $createdAt = null,
        #[Column(type: 'timestamptz', name: 'updated_at', typecast: 'datetime')]
        private ?\DateTimeImmutable $updatedAt = null,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getAthleteId(): UuidInterface
    {
        return $this->athleteId;
    }

    public function setAthleteId(UuidInterface $athleteId): void
    {
        $this->athleteId = $athleteId;
    }

    public function getToken(): string
    {
        return $this->token;
    }

    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    public function getExpiresAt(): \DateTimeImmutable
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(\DateTimeImmutable $expiresAt): void
    {
        $this->expiresAt = $expiresAt;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeImmutable $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?\DateTimeImmutable $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }
}
