<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEventResult;

use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Exceptions\Event\EventResultNotFoundException;
use App\Domain\Repositories\ActivityRepositoryInterface;
use App\Domain\Repositories\DistanceReferenceRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class UpdateEventResultCommandHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
        private ActivityRepositoryInterface $activityRepository,
        private DistanceReferenceRepositoryInterface $distanceReferenceRepository,
    ) {}

    public function handle(UpdateEventResultCommand $command): void
    {
        $distanceEntity = $this->distanceReferenceRepository->getById($command->distanceId);
        $eventAggregate = $this->eventRepository->getById($command->eventId);
        $activityEntity = null;

        if ($command->activityId) {
            $activityEntity = $this->activityRepository->getById($command->activityId);
            if (!$activityEntity->getAthleteId()->equals($command->athleteId)) {
                throw new AccessForbiddenException('Athlete does not belong to the event activity athlete');
            }
        }

        if (!$eventResultEntity = $eventAggregate->getResult()->getById($command->eventResultId)) {
            throw new EventResultNotFoundException();
        }
        if (!$eventResultEntity->getAthleteId()->equals($command->athleteId)) {
            throw new AccessForbiddenException('Athlete does not belong to the event result athlete');
        }

        $eventResultEntity->setDuration($command->duration);
        $eventResultEntity->setActivityId($activityEntity?->getId() ?? null);
        $eventResultEntity->setDistanceReferenceId($distanceEntity->getId());

        $this->eventRepository->update($eventAggregate);
    }
}
