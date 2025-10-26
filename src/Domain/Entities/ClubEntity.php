<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\Enums\Club\SportTypeEnum;
use App\Domain\ValueObjects\IdVO;

final class ClubEntity
{
    /**
     * @param SportTypeEnum[] $sportTypes
     */
    public function __construct(
        private readonly IdVO $id,
        private readonly string $externalId,
        private string $name,
        private ?string $description = null,
        private array $sportTypes,
    ) {}

    public function getId(): IdVO
    {
        return $this->id;
    }

    public function getExternalId(): string
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
}
