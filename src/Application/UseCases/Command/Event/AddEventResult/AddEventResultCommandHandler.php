<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\AddEventResult;

use App\Domain\Entities\EventResultEntity;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;
use App\Domain\ValueObjects\IdVO;

final readonly class AddEventResultCommandHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private AthleteRepositoryInterface $athleteRepository,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(AddEventResultCommand $command): void
    {
        $distanceReferenceEntity = $this->distanceReferenceRepository->getById($command->distanceId);
        $eventAggregate = $this->eventRepository->getById($command->eventId);
        $athleteEntity = $this->athleteRepository->getById($command->athleteId);

        if (!$athleteEntity->getClubIds()->contains($eventAggregate->getClubId())) {
            throw new AccessForbiddenException('Athlete does not belong to the event club');
        }

        $eventAggregate->addResult(new EventResultEntity(
            id: new IdVO()->getValue(),
            athleteId: $athleteEntity->getId(),
            activityId: $command->activityId,
            distanceReferenceId: $distanceReferenceEntity->getId(),
            duration: $command->duration,
        ));

        $this->eventRepository->update($eventAggregate);
    }
}
