<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\DeleteEvent;

use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;
use App\Application\Services\Access\AccessService;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\EventRepositoryInterface;

final readonly class DeleteEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(DeleteEventCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::event, permission: PermissionEnum::delete)) {
            throw new AccessForbiddenException();
        }

        $this->eventRepository->delete(
            $this->eventRepository->getById($command->eventId),
        );
    }
}
