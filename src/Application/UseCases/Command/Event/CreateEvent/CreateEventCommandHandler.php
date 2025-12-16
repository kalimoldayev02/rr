<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\CreateEvent;

use App\Application\Services\Access\AccessService;
use App\Domain\Aggregates\EventAggregate;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\EventRepositoryInterface;
use App\Domain\ValueObjects\IdVO;
use App\Application\Enums\Access\PermissionEnum;
use App\Application\Enums\Access\RoleEnum;

final readonly class CreateEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private EventRepositoryInterface $eventRepository,
    ) {}

    public function handle(CreateEventCommand $command): void
    {
        if (!$this->accessService->can(userId: $command->userId, role: RoleEnum::event, permission: PermissionEnum::create)) {
            throw new AccessForbiddenException();
        }

        $eventAggregate = new EventAggregate(
            id: new IdVO()->getValue(),
            authorId: $command->userId,
            clubId: $command->clubId,
            date: $command->date,
            title: $command->title,
        );

        $this->eventRepository->create($eventAggregate);
    }
}
