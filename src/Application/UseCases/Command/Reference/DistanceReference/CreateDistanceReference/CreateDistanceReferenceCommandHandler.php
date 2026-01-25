<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Reference\DistanceReference\CreateDistanceReference;

use App\Domain\Criteria\Reference\DistanceReference\DistanceReferenceQueryCriteria;
use App\Domain\Entities\DistanceReferenceEntity;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateDistanceReferenceCommandHandler
{
    public function __construct(
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(CreateDistanceReferenceCommand $command): void
    {
        $distanceReferenceCollection = $this->distanceReferenceRepository->getByCriteria(new DistanceReferenceQueryCriteria(
            fromDistance: $command->distance->getValue(),
            toDistance: $command->distance->getValue(),
            distanceTypes: [$command->distance->getType()],
        ));
        if (!$distanceReferenceCollection->isEmpty()) {
            throw new \DomainException('Distance reference already exists.');
        }

        $this->distanceReferenceRepository->create(new DistanceReferenceEntity(
            id: new IdVO()->getValue(),
            distance: $command->distance,
        ));
    }
}
