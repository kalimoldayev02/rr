<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEventResult;

use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Exceptions\Event\EventResultNotFoundException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class UpdateEventResultCommandHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private AthleteRepositoryInterface $athleteRepository,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(UpdateEventResultCommand $command): void
    {
        $distanceEntity = $this->distanceReferenceRepository->getById($command->distanceId);
        $eventAggregate = $this->eventRepository->getById($command->eventId);
        $athleteEntity = $this->athleteRepository->getById($command->athleteId);

        if (!$athleteEntity->getClubIds()->contains($eventAggregate->getClubId())) {
            throw new AccessForbiddenException('Athlete does not belong to the event club');
        }

        if (!$eventResultEntity = $eventAggregate->getResult()->getById($command->eventResultId)) {
            throw new EventResultNotFoundException();
        }
        if (!$eventResultEntity->getAthleteId()->equals($command->athleteId)) {
            throw new AccessForbiddenException('Athlete does not belong to the event result athlete');
        }

        $eventResultEntity->setDuration($command->duration);
        $eventResultEntity->setActivityId($command->activityId);
        $eventResultEntity->setDistanceReferenceId($distanceEntity->getId());

        $this->eventRepository->update($eventAggregate);
    }
}
