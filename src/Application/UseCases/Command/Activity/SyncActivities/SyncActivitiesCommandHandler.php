<?php

declare(strict_types=1);

namespace App\Application\UseCases\Command\Activity\SyncActivities;

use App\Domain\Repositories\AthleteRepositoryInterface;
use App\Domain\Services\Activity\SyncActivities\SyncActivitiesService;

final readonly class SyncActivitiesCommandHandler
{
    public function __construct(
        private AthleteRepositoryInterface $athleteRepository,
        private SyncActivitiesService $syncAthleteActivitiesService,
    ) {}

    public function handle(SyncActivitiesCommand $command): void
    {
        $athleteEntity = $this->athleteRepository->getById($command->athleteId);
        $this->syncAthleteActivitiesService->sync($athleteEntity);
    }
}
