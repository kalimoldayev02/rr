<?php

declare(strict_types=1);

namespace App\Domain\Entities;

use App\Domain\ValueObjects\DistanceVO;
use Ramsey\Uuid\UuidInterface;

final readonly class DistanceReferenceEntity
{
    public function __construct(
        private UuidInterface $id,
        private DistanceVO $distance,
    ) {}

    public function getId(): UuidInterface
    {
        return $this->id;
    }

    public function getDistance(): DistanceVO
    {
        return $this->distance;
    }
}
