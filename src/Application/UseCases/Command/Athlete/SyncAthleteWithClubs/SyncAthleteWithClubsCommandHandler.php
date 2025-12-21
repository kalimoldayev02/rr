<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Athlete\SyncAthleteWithClubs;

use App\Application\Exceptions\ApplicationException;
use App\Domain\Services\Athlete\SyncAthleteWithClubs\SyncAthleteWithClubsService;
use Psr\Log\LoggerInterface;

final readonly class SyncAthleteWithClubsCommandHandler
{
    public function __construct(
        private LoggerInterface $logger,
        private SyncAthleteWithClubsService $syncAthleteWithClubsService,
    ) {}

    /**
     * @throws ApplicationException
     */
    public function handle(SyncAthleteWithClubsCommand $command): void
    {
        try {
            $this->syncAthleteWithClubsService->sync($command->athleteId);
        } catch (\DomainException $exception) {
            $this->logger->error('SyncAthleteWithClubs', [
                'message' => $exception->getMessage(),
                'athleteId' => $command->athleteId,
            ]);

            throw new ApplicationException($exception->getMessage());
        }
    }
}
