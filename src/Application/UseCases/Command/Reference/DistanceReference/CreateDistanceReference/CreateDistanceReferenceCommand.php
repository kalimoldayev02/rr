<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\CreateDistanceReference;

use App\Domain\ValueObjects\DistanceVO;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateDistanceReferenceCommand
{
    public function __construct(
        public UuidInterface $userId,
        public DistanceVO $distance,
    ) {}
}
