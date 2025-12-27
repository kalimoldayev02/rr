<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\DeleteDistanceReference;

use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class DeleteDistanceReferenceCommandHandler
{
    public function __construct(
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(DeleteDistanceReferenceCommand $command): void
    {
        $this->distanceReferenceRepository->delete(
            $this->distanceReferenceRepository->getById($command->distanceReferenceId),
        );
    }
}
