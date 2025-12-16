<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\DeleteDistanceReference;

use Ramsey\Uuid\UuidInterface;

final readonly class DeleteDistanceReferenceCommand
{
    public function __construct(
        public UuidInterface $userId,
        public UuidInterface $distanceReferenceId,
    ) {}
}
