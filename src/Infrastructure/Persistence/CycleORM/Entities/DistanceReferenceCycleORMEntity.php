<?php

declare(strict_types=1);

namespace App\Infrastructure\Persistence\CycleORM\Entities;

use Cycle\Annotated\Annotation\Column;
use Cycle\Annotated\Annotation\Entity;
use Cycle\ORM\Entity\Behavior\Uuid\Uuid7;
use Ramsey\Uuid\UuidInterface;

#[Entity(table: 'distance_references')]
#[Uuid7(field: 'id', nullable: false)]
class DistanceReferenceCycleORMEntity
{
    public function __construct(
        #[Column(type: 'uuid', primary: true)]
        private UuidInterface $id,
        #[Column(type: 'float')]
        private float $distance,
        #[Column(type: 'string', name: 'distance_type')]
        private string $distanceType,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function setId(UuidInterface $id): void
    {
        $this->id = $id;
    }

    public function getDistance(): float
    {
        return $this->distance;
    }

    public function setDistance(float $distance): void
    {
        $this->distance = $distance;
    }

    public function getDistanceType(): string
    {
        return $this->distanceType;
    }

    public function setDistanceType(string $distanceType): void
    {
        $this->distanceType = $distanceType;
    }
}
