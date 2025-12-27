<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Event\CreateEvent;

use App\Application\Services\Access\AccessService;
use App\Domain\Aggregates\EventAggregate;
use App\Domain\Exceptions\AccessForbiddenException;
use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Repositories\EventRepositoryInterface;
use App\Domain\ValueObjects\IdVO;

final readonly class CreateEventCommandHandler
{
    public function __construct(
        private AccessService $accessService,
        private EventRepositoryInterface $eventRepository,
        private AthleteRepositoryInterface $athleteRepository,
    ) {}

    public function handle(CreateEventCommand $command): void
    {
        $athleteEntity = $this->athleteRepository->getById($command->userId);
        if (!$this->accessService->can($athleteEntity, $command->clubId)) {
            throw new AccessForbiddenException();
        }

        $eventAggregate = new EventAggregate(
            id: new IdVO()->getValue(),
            clubId: $command->clubId,
            date: $command->date,
            title: $command->title,
        );

        $this->eventRepository->create($eventAggregate);
    }
}
