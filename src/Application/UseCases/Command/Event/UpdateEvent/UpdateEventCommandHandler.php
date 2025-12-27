<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEvent;

use App\Application\Services\Access\AccessService;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class UpdateEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private AthleteRepositoryInterface $athleteRepository,
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(UpdateEventCommand $command): void
    {
        $athleteEntity = $this->athleteRepository->getById($command->userId);
        if (!$this->accessService->can($athleteEntity, $command->clubId)) {
            throw new AccessForbiddenException();
        }

        $eventAggregate = $this->eventRepository->getById($command->eventId);
        $eventAggregate->setClubId($command->clubId);
        $eventAggregate->setTitle($command->title);
        $eventAggregate->setDate($command->date);

        $this->eventRepository->update($eventAggregate);
    }
}
