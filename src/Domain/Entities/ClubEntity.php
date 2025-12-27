<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\SportTypeEnum;
use Ramsey\Uuid\UuidInterface;

final class ClubEntity
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        private readonly UuidInterface $id,
        private readonly int $externalId,
        private string $name,
        private ?string $description = null,
        private array $sportTypes,
        private ?int $ownerExternalId,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getSportTypes(): array
    {
        return $this->sportTypes;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): void
    {
        $this->description = $description;
    }

    public function getOwnerExternalId(): int
    {
        return $this->ownerExternalId;
    }

    public function setExternalOwnerId(int $ownerExternalId): void
    {
        $this->ownerExternalId = $ownerExternalId;
    }
}
