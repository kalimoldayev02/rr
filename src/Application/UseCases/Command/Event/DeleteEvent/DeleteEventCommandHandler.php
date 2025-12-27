<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\DeleteEvent;

use App\Application\Services\Access\AccessService;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class DeleteEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private AthleteRepositoryInterface $athleteRepository,
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(DeleteEventCommand $command): void
    {
        $athleteEntity = $this->athleteRepository->getById($command->userId);
        $eventAggregate = $this->eventRepository->getById($command->eventId);

        if (!$this->accessService->can($athleteEntity, $eventAggregate->getClubId())) {
            throw new AccessForbiddenException();
        }

        $this->eventRepository->delete($eventAggregate);
    }
}
