<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\UpdateDistanceReference;

use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;

final readonly class UpdateDistanceReferenceCommandHandler
{
    public function __construct(
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(UpdateDistanceReferenceCommand $command): void
    {
        $distanceReferenceCollection = $this->distanceReferenceRepository->getByCriteria(new DistanceReferenceQueryCriteria(
            fromDistance: $command->distance->getValue(),
            toDistance: $command->distance->getValue(),
            distanceTypes: [$command->distance->getType()],
        ));
        if (!$distanceReferenceCollection->isEmpty()) {
            throw new \DomainException('Distance reference already exists.');
        }

        $this->distanceReferenceRepository->update(new DistanceReferenceEntity(
            id: $command->distanceReferenceId,
            distance: $command->distance,
        ));
    }
}
