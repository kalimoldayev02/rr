<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\RemoveEventResult;

use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Exceptions\Event\EventResultNotFoundException;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class RemoveEventResultCommandHandler
{
    public function __construct(
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(RemoveEventResultCommand $command): void
    {
        $eventAggregate = $this->eventRepository->getById($command->eventId);
        if (!$eventResultEntity = $eventAggregate->getResult()->getById($command->eventResultId)) {
            throw new EventResultNotFoundException();
        }

        if (!$eventResultEntity->getAthleteId()->equals($command->athleteId)) {
            throw new AccessForbiddenException('Athlete does not belong to the event result athlete');
        }

        $eventAggregate->getResult()->remove($eventResultEntity);

        $this->eventRepository->update($eventAggregate);
    }
}
