<?php

declare(strict_types=1);

namespace App\Application\DTO\Reference;

use App\Domain\ValueObjects\DistanceVO;
use Ramsey\Uuid\UuidInterface;

final readonly class DistanceReferenceDTO
{
    public function __construct(
        public UuidInterface $id,
        public DistanceVO $distance,
    ) {}
}
