<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\UpdateDistanceReference;

use App\Domain\ValueObjects\DistanceVO;
use Ramsey\Uuid\UuidInterface;

final readonly class UpdateDistanceReferenceCommand
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $distanceReferenceId,
        public DistanceVO $distance,
    ) {}
}
