<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\UpdateEvent;

use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;
use App\Application\Services\Access\AccessService;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class UpdateEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(UpdateEventCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::event, permission: PermissionEnum::update)) {
            throw new AccessForbiddenException();
        }

        $eventAggregate = $this->eventRepository->getById($command->eventId);
        $eventAggregate->setClubId($command->clubId);
        $eventAggregate->setTitle($command->title);
        $eventAggregate->setDate($command->date);

        $this->eventRepository->update($eventAggregate);
    }
}
