<?php

declare(strict_types=1);

namespace App\Infrastructure\Listeners\Athlete;

use App\Application\Dispatchers\CommandDispatcher\CommandDispatcherInterface;
use App\Application\UseCases\Command\Athlete\SyncAthleteWithClubs\SyncAthleteWithClubsCommand;
use App\Domain\Events\Athlete\AthleteRegisteredEvent;
use Spiral\Events\Attribute\Listener;

#[Listener(event: AthleteRegisteredEvent::class)]
final readonly class SyncAthletesWithClubsOnAthleteRegisteredListener
{
    public function __construct(
        private CommandDispatcherInterface $commandDispatcher,
    ) {}

    public function __invoke(AthleteRegisteredEvent $event): void
    {
        $this->commandDispatcher->dispatch(new SyncAthleteWithClubsCommand(athleteId: $event->athleteId));
    }
}
